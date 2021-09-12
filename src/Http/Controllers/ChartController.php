<?php

namespace TCG\Voyager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Resources\Chart;

class ChartController extends Controller{

    public function __invoke(Request $request){
        $request->validate([
            'model' => 'required|in:user',
        ]);
        $period = new DatePeriod(new DateTime(Carbon::now()->startOfMonth()->subMonths(12)->toDateString()), new DateInterval('P1M'), new DateTime(Carbon::now()->startOfMonth()->addMonth()->toDateString()));
        $chartdata = User::where('updated_at', '>=', Carbon::now()->startOfMonth()->subMonths(12)->toDateString())->selectRaw('DATE_FORMAT(updated_at, "%Y-%m") date, count(*) data')->groupBy('date')->orderBy('date', 'desc')->get()->toArray();
        $dates = array_column($chartdata, 'date');

        foreach($period as $key => $value){
            if(!in_array($value->format('Y-m'), $dates)){
                $chartdata[] = ['date' => $value->format('Y-m'), 'data' => 0];
            }
        }
        usort($chartdata, [$this, "compareByTimeStamp"]);
        return Chart::collection($chartdata);
    }

    private function compareByTimeStamp($time1, $time2){
        if(strtotime($time1['date']) > strtotime($time2['date'])){
            return 1;
        } else if(strtotime($time1['date']) < strtotime($time2['date'])){
            return -1;
        } else {
            return 0;
        }

    }

}
