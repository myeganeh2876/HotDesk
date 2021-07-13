<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed transaction_date
 * @property mixed paid
 * @property mixed client_id
 * @property mixed amount
 * @property mixed id
 * @property string bank_transaction_id
 * @property mixed wallet_transaction_id
 */
class Transaction extends Model{

    protected $fillable = [
        'product_id',
        'from',
        'forsms',
        'transaction_data',
        'status',
        'transaction_date',
        'address_id',
        'wallet_transaction_id',
        'amount',
        'paid',
        'client_id',
        'product_id',
        'options',
        'receive_time',
    ];

    protected $dates = ['created_at', 'updated_at', 'transaction_date'];

    protected $casts = [
        'transaction_data' => 'array',
    ];

    protected $appends = ['shamsi_date', 'status_text'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function getShamsiDateAttribute(){
        if(!$this->created_at)
            return "";
        $date = jdate($this->created_at);
        $date = substr($date, 0, strpos($date, " "));

        $date = explode("-", $date);

        switch($date[1]){
            case 1:
                $date[1] = "فروردین";
                break;
            case 2:
                $date[1] = "اردیبهشت";
                break;
            case 3:
                $date[1] = "خرداد";
                break;
            case 4:
                $date[1] = "تیر";
                break;
            case 5:
                $date[1] = "مرداد";
                break;
            case 6:
                $date[1] = "شهریور";
                break;
            case 7:
                $date[1] = "مهر";
                break;
            case 8:
                $date[1] = "آبان";
                break;
            case 9:
                $date[1] = "آذر";
                break;
            case 10:
                $date[1] = "دی";
                break;
            case 11:
                $date[1] = "بهمن";
                break;
            case 12:
                $date[1] = "اسفند";
                break;
        }

        return implode(" ", $date);
    }

    public function getStatusTextAttribute(){

        if($this->status == 0 && $this->paid == 0)
            return "پرداخت ناموفق";
        elseif($this->status == 0 && $this->paid == 1)
            return "پرداخت شده";
        else
            return "ارسال شده";
    }

    public function scopeGroupBy($query){
        return $query->groupBy('wallet_transaction_id');
    }

}
