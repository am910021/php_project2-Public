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
}
