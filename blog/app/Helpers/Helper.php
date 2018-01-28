<?php 
namespace App\Helpers;

use App\MealRecord;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Helper{
    public static function test($user_id, $weight) {
        
        if ($weight == 0.0) {
            return 0.0;
        }
        
        $userProfile = UserProfile::where('user_id', $user_id)->first();
        $pSex = $userProfile->sex;
        $pWeight = $userProfile->weight;
        $pHeight = $userProfile->height;
        $pAge = $userProfile->age;
        
        $ACTIVITY_AMOUNT_ARR = Config::get('constants.ACTIVITY_AMOUNT_ARR');
        $activity_amount = $userProfile->activity_amount;
        
        $activity_amount_value = $ACTIVITY_AMOUNT_ARR[$activity_amount]['value'];
        if ($pSex == 0) {
            $cal = (66 + (13.7 * $pWeight) + (5 * $pHeight) - (6.8 * $pAge)) * $activity_amount_value;
        } else {
            $cal = (655 + (9.6 * $pWeight) + (1.7 * $pHeight) - (4.7 * $pAge)) * $activity_amount_value;
        }
        
        $weight = $weight / $cal * 100;
        // echo $userProfile->sex;
        return number_format($weight, 2);
        
    }
    
    
    public static function  getScore($day, $percent){

        
        
        
        
        return '1';
    }
    
}

