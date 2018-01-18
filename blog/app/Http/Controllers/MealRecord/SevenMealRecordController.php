<?php

namespace App\Http\Controllers\MealRecord;

use App\MealRecord;
use App\MealRecordDay;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SevenMealRecordController extends Controller
{

    use MealRecordDayCommon;

    public function readList()
    {
        $mealRecordDays = $this->getSevenMealRecordDays();
        $weeklyAvg = $this->getWeeklyAvg($mealRecordDays);
        return view('mealRecord.sevenListRead')
            ->with('mealRecordDays', $mealRecordDays)
            ->with('weeklyAvg', $weeklyAvg);
    }

    public function readChart()
    {
        $mealRecordDays = $this->getSevenMealRecordDays('ASC');
        $weeklyAvg = $this->getWeeklyAvg($mealRecordDays);
        return view('mealRecord.sevenChartRead')
            ->with('mealRecordDays', $mealRecordDays)
            ->with('weeklyAvg', $weeklyAvg);
    }


    private function getSevenMealRecordDays($order_by = 'DESC')
    {
        $user = Auth::user();

        $yesterday = Carbon::today()->subDay(1);

        $lastWeekDate = Carbon::today()->subWeek()->addDay(1);
        $mealRecordDayCount = MealRecordDay::where('user_id', $user->id)
            ->whereDate('date', '>=', $lastWeekDate)
            ->whereDate('date', '<=', $yesterday)
            ->count();

        // 是否 != 6 代表 沒資料
        if ($mealRecordDayCount != 6) {
            $date = Carbon::today()->subWeek();
            for ($i = 0; $i < 6; $i++) {
                $date = $date->addDay(1);

                $mealRecordDay = MealRecordDay::
                where('user_id', $user->id)
                    ->whereDate('date', $date)->get();
                // 如果有資料 就下一個
                if ($mealRecordDay->count() == 1) {
                    continue;
                }
                // 沒資料 計算
                $this->createMealRecordDay($user, $date);
            }
        }

        $temp = [];

        $mealRecordDays = MealRecordDay::where('user_id', $user->id)
            ->whereDate('date', '>=', $lastWeekDate)
            ->whereDate('date', '<=', $yesterday)
            ->orderBy('date', $order_by)->get();
        foreach ($mealRecordDays as $mealRecordDay) {
            $temp[] = $mealRecordDay;
        }

        // calc today
        $today = Carbon::today();
        $mealRecord = MealRecord::
        select(DB::raw('SUM(calories) calories, SUM(weight) weight'))
            ->where('user_id', $user->id)
            ->whereDate('datetime', $today)->first();
        $calories = $mealRecord['calories'] ?? 0;
        $weight = $mealRecord['weight'] ?? 0;
        $mealRecordDay = new MealRecordDay;
        $mealRecordDay->user_id = $user->id;
        $mealRecordDay->calories = $calories;
        $mealRecordDay->weight = $weight;
        $mealRecordDay->date = $today->toDateString();
        // 放第一個
        if ($order_by == 'DESC') {
            array_unshift($temp, $mealRecordDay);
        } else {
            $temp[] = $mealRecordDay;
        }

        $mealRecordDays = $temp;
        return $mealRecordDays;
    }

    private function getWeeklyAvg($mealRecordDays)
    {
        $user = Auth::user();
        $weekCalories = 0;
        $weekWeight = 0;
        $count = 0;
        foreach ($mealRecordDays as $mealRecordDay) {
            $temp[] = $mealRecordDay;
            if ($mealRecordDay->weight != 0) {
                $count += 1;
            }
            $weekCalories += $mealRecordDay->calories;
            $weekWeight += $mealRecordDay->weight;
        }

        if ($count != 0) {
            $weekCalories = $weekCalories / $count;
            $weekWeight = $weekWeight / $count;
        } else {
            $weekCalories = 0;
            $weekWeight = 0;
        }
        $mealRecordDay = new MealRecordDay;
        $mealRecordDay->calories = $weekCalories;
        $mealRecordDay->weight = $weekWeight;

        $mealRecordDay->date = "當週平均";
        $mealRecordDay->user_id = $user->id;
        return $mealRecordDay;
    }


}