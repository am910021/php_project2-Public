<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;


class MealRecord extends Model
{
    //

    public function getDatetimeByTimeAttribute()
    {
        $datetime = $this->datetime;
        $time = Carbon::parse($datetime)->format('H:i:s');
        return $time;

    }

    public function getDatetimeByDateAttribute()
    {
        $datetime = $this->datetime;
        $date = Carbon::parse($datetime)->format('Y-m-d');
        return $date;

    }

    public function gramByPercent()
    {
        $calories = $this->calories;
        if ($calories == 0.0) {
            return 0.0;
        }

        $userProfile = UserProfile::where('user_id', $this->user_id)->first();
        $pSex = $userProfile->sex;
        $pWeight = $userProfile->weight;
        $pHeight = $userProfile->height;
        $pAge = $userProfile->age;

        $ACTIVITY_AMOUNT_ARR = Config::get('constants.ACTIVITY_AMOUNT_ARR');
        $activity_amount = $userProfile->activity_amount;

        $activity_amount_value = $ACTIVITY_AMOUNT_ARR[$activity_amount]['value'];
        if ($pSex == 0) {
            $needCalories = (66 + (13.7 * $pWeight) + (5 * $pHeight) - (6.8 * $pAge)) * $activity_amount_value;
        } else {
            $needCalories = (655 + (9.6 * $pWeight) + (1.7 * $pHeight) - (4.7 * $pAge)) * $activity_amount_value;
        }

        $percent = $calories / $needCalories * 100;
        // echo $userProfile->sex;
        return number_format($percent, 2);
        // return $query->where('votes', '>', 100);
    }
    
    public function setPercent(){
        $this->percent = $this->gramByPercent();
    }
    
    public function food(){
        return Food::where('id',$this->food_id)->first();
    }
    
    
    

//    public function getBSColorTagAttribute()
//    {
//        $color = $this->calcColor();
//        if ($color == "g") {
//            return "success";
//        } elseif ($color == "y") {
//            return "warning";
//        } elseif ($color == "r") {
//            return "danger";
//        } else {
//            return "default";
//        }
//    }
//
//    public function calcColor()
//    {
//        $pos = $this->gramByPercent() / 100;
//        if ($pos == 0) {
//            return "w";
//        } elseif ($pos <= 0.05) {
//            return "g";
//        } elseif ($pos <= 0.1) {
//            return "y";
//        } else {
//            return "r";
//        }
//    }

}
