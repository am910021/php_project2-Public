<?php

namespace App\Http\Controllers\MealRecord;


use App\MealRecord;
use App\MealRecordDay;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait MealRecordDayCommon
{
    // 建立 每天的資料 user(obj), $date
    public function createMealRecordDay($user, $date)
    {
        $today = Carbon::today()->format('Y-m-d');
        $date = Carbon::parse($date)->format('Y-m-d');
        // 今天不建立 要轉date判斷
        if ($date == $today){
            return;
        }
        $mealRecordSum = MealRecord::
            select(DB::raw('SUM(calories) calories, 
                            SUM(weight) weight,
                            ROUND(SUM(percent),3) percent 
                            '))
            ->where('user_id', $user->id)
            ->whereDate('datetime', $date)->first();
        $calories = $mealRecordSum['calories'] ?? 0;
        $weight = $mealRecordSum['weight'] ?? 0;
        $percent = $mealRecordSum['percent'] ?? 0;

        // 先找有沒有資料
        $mealRecordDay = MealRecordDay::
            where('user_id', $user->id)
            ->whereDate('date', $date)->first();
//            沒資料 就建立
        if (!$mealRecordDay) {
            $mealRecordDay = new MealRecordDay;
        }


        $mealRecordDay->user_id = $user->id;
        $mealRecordDay->date = $date;
        $mealRecordDay->calories = $calories;
        $mealRecordDay->weight = $weight;
        $mealRecordDay->percent = $percent;

        // 先抓當天的飲食一筆 去找 當天的身高體重
        $userDataObj = MealRecord:: where('user_id', $user->id)
                ->whereDate('datetime', $date)->first();

        // 如果沒有 就抓目前個人資料的 欄位變數不一樣
        if (!$userDataObj){
            $userDataObj = UserProfile::where('user_id', $user->id)->first();
            $weight = $userDataObj->weight;
        }else{
            $weight = $userDataObj->p_weight;
        }
        $mealRecordDay->age = $userDataObj->age;
        $mealRecordDay->height = $userDataObj->height;
        $mealRecordDay->p_weight = $weight;
        $mealRecordDay->activity_amount = $userDataObj->activity_amount;
        $mealRecordDay->rc = $userDataObj->rc;

        $mealRecordDay->save();
    }
}
