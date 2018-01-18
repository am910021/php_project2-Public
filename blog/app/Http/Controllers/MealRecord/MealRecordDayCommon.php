<?php

namespace App\Http\Controllers\MealRecord;

//namespace App\Traits;

use App\MealRecord;
use App\MealRecordDay;
use Illuminate\Support\Facades\DB;

trait MealRecordDayCommon
{
    // 建立 每天的資料 user(obj), $date
    public function createMealRecordDay($user, $date, $isCreate = true)
    {
        $mealRecord = MealRecord::
            select(DB::raw('SUM(calories) calories, SUM(weight) weight'))
            ->where('user_id', $user->id)
            ->whereDate('datetime', $date)->first();
        $calories = $mealRecord['calories'] ?? 0;
        $weight = $mealRecord['weight'] ?? 0;

        // 建立
        if ($isCreate) {
            $mealRecordDay = new MealRecordDay;
        } else {
            // 修改
            $mealRecordDay = MealRecordDay::
                where('user_id', $user->id)
                ->whereDate('date', $date)->first();
//            沒資料
            if (!$mealRecordDay) {
                $mealRecordDay = new MealRecordDay;
            }
        }

        $mealRecordDay->user_id = $user->id;
        $mealRecordDay->date = $date;
        $mealRecordDay->calories = $calories;
        $mealRecordDay->weight = $weight;
        $mealRecordDay->save();
    }
}
