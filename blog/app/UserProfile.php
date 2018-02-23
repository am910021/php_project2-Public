<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class UserProfile extends Model
{
    //
    
    protected $fillable = [
        'age', 'height', 'weight', 'sex', 'activity_amount'
    ];

    public function getSexValueAttribute()
    {
        $SEX_ARR  = Config::get('constants.SEX_ARR');
        $sex = $this->sex;
        return $SEX_ARR[$sex];
        
    }

    public function getActivityAmountValueAttribute()
    {
        $ACTIVITY_AMOUNT_ARR  = Config::get('constants.ACTIVITY_AMOUNT_ARR');
        $activity_amount = $this->activity_amount;
        return $ACTIVITY_AMOUNT_ARR[$activity_amount]['text'];
        
    }
    
    public function getRecommendedCalories()
    {
        $user_id = $this->user_id;
        
        
        $pSex = $this->sex;
        $pWeight = $this->weight;
        $pHeight = $this->height;
        $pAge = $this->age;
        
        $ACTIVITY_AMOUNT_ARR = Config::get('constants.ACTIVITY_AMOUNT_ARR');
        $activity_amount = $this->activity_amount;
        
        $activity_amount_value = $ACTIVITY_AMOUNT_ARR[$activity_amount]['value'];
        if ($pSex == 0) {
            $cal = (66 + (13.7 * $pWeight) + (5 * $pHeight) - (6.8 * $pAge)) * $activity_amount_value;
        } else {
            $cal = (655 + (9.6 * $pWeight) + (1.7 * $pHeight) - (4.7 * $pAge)) * $activity_amount_value;
        }
        
        return $cal;
        // return $query->where('votes', '>', 100);
    }
    
    public function setRecommendedCalories()
    {
        $this->rc = $this->getRecommendedCalories();
    }
    
    public function getRecommendedCaloriesAttribute()
    {
        return number_format($this->getRecommendedCalories(), 2);
        // return $query->where('votes', '>', 100);
    }
        
}
