<?php

namespace App;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class MealRecordDay extends Model
{
    //

    public function getDatetimeByDateAttribute()
    {
        $datetime = $this->datetime;
        $date = Carbon::parse($datetime)->format('Y-m-d');
        return $date;

    }



    public function mealRecords()
    {
        $date = $this->date;
        $user_id = $this->user_id;

        $mealRecords = MealRecord::where('user_id', $user_id)->whereDate('datetime', $date)->get();
        return $mealRecords;
//        return $this->hasMany('App\MealRecord', 'datetime', 'date');
    }




    public function getCalcColorAttribute()
    {
        $percent = $this->percent;
        $color = Helper::getBSColor($percent);
        if ($color == "success") {
            return "g";
        } elseif ($color == "warning") {
            return "y";
        } elseif ($color == "danger") {
            return "r";
        } else {
            return "n";
        }
    }

}

