<?php 
namespace App\Helpers;

use App\MealRecord;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Helper{
   
    
    public static function getBSColor($percent)
    {
        $pos = $percent / 100;
        if ($pos == 0) {
            return "";
        } elseif ($pos <= 0.05) {
            return "success";
        } elseif ($pos <= 0.1) {
            return "warning";
        } else {
            return "danger";
        }
    }
    
    
    public static function  getScore($day, $percent){
        $rep = 100 - $percent;
        
        
        
        
        return (100 - $percent)*$day;
    }
    
}

