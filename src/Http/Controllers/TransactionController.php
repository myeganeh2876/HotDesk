<?php

namespace TCG\Voyager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Response;
use App\Models\Sms;
use App\Models\Transaction;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller{

    public static function idPay(Request $request, $price, $product_id = 0){
        $transaction = $request->user()->transaction()->create([
            'product_id' => $product_id,
            'forsms' => $product_id == 0 ? true : false,
            'status' => 'waiting',
            'transaction_date' => now(),
            'from' => $request->from,
        ]);
        $api_key = config('hotdesk.id_pay_api_key');
        $sanbox = config('hotdesk.id_pay_sandbox');
        $params = [
            'order_id' => $transaction->id,
            'amount' => $price,
            'callback' => url(route('idpay-callback')),
            'desc' => "شماره تراکنش: $transaction->id",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "X-API-KEY: $api_key",
            $sanbox ? "X-SANDBOX: 1" : '',
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);

        if(!isset($result->id)){
            $str = [];
            if(is_array($result)){
                foreach($result as $key => $value){
                    $str[] = "$key => $value";
                }
                $str = implode(',  ', $str);
                Log::error($str);
            }
            abort(503, 'Can not connect to IDPay');
        }

        $transaction->update([
            'transaction_data' => [
                'data' => [
                    'token' => Crypt::encryptString($result->id),
                    'price' => Crypt::encryptString($price),
                ],
            ],
        ]);
        return $result;
    }

    public function idPayCallback(Request $request){
        $transaction = Transaction::findOrFail($request->order_id);
        $from = $transaction->from;
        $requesteq = $request->all();
        foreach($requesteq as $key => $value){
            $requesteq[$key] = Crypt::encryptString($value);
        }
        //Check request
        if($request->status != 10){
            $transaction->forceFill([
                'transaction_data->data->info' => Crypt::encryptString('Not paid -- '),
                'transaction_data->data->result' => $requesteq,
            ]);
            $transaction->update(['status' => 'notpaid', 'transaction_date' => now()]);
            $message = "پرداخت ناموفق بود";
            if($transaction->forsms){
                return redirect('admin')->with(['status' => $message, 'success' => false]);
            } else {
                $success = false;
                $code = 4;
                return view('payment', compact('from', 'message', 'success', 'code'));
            }
        }
        // Check repeating request
        if(isset($transaction->transaction_data['data']['track_id'])){
            $transaction->forceFill([
                'transaction_data->data->info' => Crypt::encryptString('Repeated request -- '),
                'transaction_data->data->result' => $requesteq,
            ]);
            $transaction->update(['status' => 'repeated', 'transaction_date' => now()]);
            $message = "درخواست تکراری از درگاه";
            if($transaction->forsms){
                return redirect('admin')->with(['status' => $message, 'success' => false]);
            } else {
                $success = false;
                $code = 3;
                return view('payment', compact('from', 'message', 'success', 'code'));
            }
        }

        //Check if different id from IDPay provided
        if(Crypt::decryptString($transaction->transaction_data['data']['token']) != $request->id){
            $transaction->forceFill([
                'transaction_data->data->info' => Crypt::encryptString('Different ID from IDPay -- '),
                'transaction_data->data->result' => $requesteq,
            ]);
            $transaction->update(['status' => 'differentID', 'transaction_date' => now()]);
            $message = "شناسه تراکنش با شناسه درگاه یکسان نیست";
            if($transaction->forsms){
                return redirect('admin')->with(['status' => $message, 'success' => false]);
            } else {
                $success = false;
                $code = 2;
                return view('payment', compact('from', 'message', 'success', 'code'));
            }
        }
        $transaction->forceFill([
            'transaction_data->data->track_id' => Crypt::encryptString($request->track_id),
            'transaction_data->data->result' => $requesteq,
        ]);

        //Verify the transaction
        $api_key = config('hotdesk.id_pay_api_key');
        $sanbox = config('hotdesk.id_pay_sandbox');

        $params = [
            'id' => Crypt::decryptString($transaction->transaction_data['data']['token']),
            'order_id' => $transaction->id,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "X-API-KEY: $api_key",
            $sanbox ? "X-SANDBOX: 1" : '',
        ]);

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        foreach($result as $key => $value){
            $result->$key = Crypt::encryptString(serialize($value));
        }
        //Check if transaction was successful
        if(!isset($result->status) || $result->status != (100 || 200)){
            $transaction->forceFill([
                'transaction_data->data->info' => Crypt::encryptString('Could not verify'),
                'transaction_data->data->result' => $requesteq,
            ]);
            $transaction->update(['status' => 'notverify', 'transaction_date' => now()]);
            Log::error('Could not verify // ' . json_encode($result));
            $message = "تراکنش تایید نشد";
        } else {
            $transaction->forceFill([
                'transaction_data->data->info' => $result,
                'transaction_data->data->paid' => true,
            ]);
            $transaction->update(['status' => 'success', 'transaction_date' => now()]);
            if($transaction->forsms){
                $sms = Sms::first();
                $sms->sends = 0;
                $sms->stock += round($transaction->transaction_data['data']['price'] / config('hotdesk.message_price'));
                $sms->emergencysend = false;
                $sms->save();
                $message = "شارژ پیامک با موفقیت انجام شد";
            } else {
                $message = "تراکنش با موفقیت انجام شد";
                UserProduct::create([
                    'products_id' => $transaction->product_id,
                    'user_id' => $transaction->user_id,
                    'start_date' => now(),
                    'finish_date' => date("Y-m-d H:i:s", strtotime('+' . ($transaction->product()->exists() ? $transaction->product()->first()->duration : 0) . ' day')),
                    'transaction_data' => $transaction->transaction_data,
                    'status' => 'active',
                ]);
            }
        }
        if($transaction->forsms){
            return redirect('admin')->with(['status' => $message, 'success' => true]);
        } else {
            $success = true;
            $code = 1;
            return view('payment', compact('from', 'message', 'success', 'code'));
        }
    }

    public function chargesms(Request $request){
        $request->validate([
            'price' => 'required|integer',
        ]);
        $result = TransactionController::idPay($request, $request->price);
        return Response::create(true, "redirect to pay panel", [
            $result,
        ]);
    }

}
