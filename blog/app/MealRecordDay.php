<?php

namespace App;

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

    public function gramByPercent()
    {
        $user_id = $this->user_id;
        $gram = $this->weight;

        if ($gram == 0.0) {
            return 0.0;
        }

        $userProfile = UserProfile::where('user_id', $user_id)->first();
        $sex = $userProfile->sex;
        $weight = $userProfile->weight;
        $height = $userProfile->height;
        $age = $userProfile->age;

        $ACTIVITY_AMOUNT_ARR = Config::get('constants.ACTIVITY_AMOUNT_ARR');
        $activity_amount = $userProfile->activity_amount;

        $activity_amount_value = $ACTIVITY_AMOUNT_ARR[$activity_amount]['value'];
        if ($sex == 0) {
            $cal = (66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age)) * $activity_amount_value;
        } else {
            $cal = (655 + (9.6 * $weight) + (1.7 * $height) - (4.7 * $age)) * $activity_amount_value;
        }

        $gram = $gram / $cal * 100;
        // echo $userProfile->sex;
        return number_format($gram, 2);
        // return $query->where('votes', '>', 100);
    }

    public function mealRecords()
    {
        $date = $this->date;
        $user_id = $this->user_id;

        $mealRecords = MealRecord::where('user_id', $user_id)->whereDate('datetime', $date)->get();
        return $mealRecords;
//        return $this->hasMany('App\MealRecord', 'datetime', 'date');
    }

    public function getBSColorTagAttribute()
    {
        $color = $this->getCalcColorAttribute();
        if ($color == "g") {
            return "success";
        } elseif ($color == "y") {
            return "warning";
        }elseif ($color == "r") {
            return "danger";
        }else{
            return "default";
        }
    }

    public function getCalcColorAttribute()
    {
        $pos = $this->gramByPercent() / 100;
        if ($pos == 0) {
            return "n";
        } elseif ($pos <= 0.05) {
            return "g";
        } elseif ($pos <= 0.1) {
            return "y";
        } else {
            return "r";
        }
    }

}

/***
 *    private static String calcColor(double c) {
 * double pas = getPercentage(c);
 * if (pas==0) return "w";
 * if (pas <= 0.05) {
 * return "g";
 * } else if (pas <= 0.1) {
 * return "y";
 * } else {
 * return "r";
 * }
 * }
 *
 */