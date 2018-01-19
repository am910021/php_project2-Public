<?php

namespace App\Http\Controllers\MealRecord;

use App\MealRecord;
use App\MealRecordDay;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DateMealRecordController extends Controller
{

    use MealRecordDayCommon;

    public function readList(Request $request)
    {

        $input = $request->all();
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if (!isset($startDate) or !isset($endDate)) {
            $startDate = Carbon::today()->subWeek()->addDay(1)->format("Y-m-d");
            $endDate = Carbon::today()->format("Y-m-d");
        }

        $validator = $this->getValidatorResult($input);
        if ($validator->fails()) {

            return view('mealRecord.dateListRead')
                ->withErrors($validator)
                ->with('startDate', $startDate)
                ->with('endDate', $endDate);
        }


        $mealRecordDays = $this->getMealRecordDays($startDate, $endDate);

        return view('mealRecord.dateListRead')
            ->with('startDate', $startDate)
            ->with('endDate', $endDate)
            ->with('mealRecordDays', $mealRecordDays);
    }

    public function readChart(Request $request)
    {
        $input = $request->all();
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        if (!isset($startDate) or !isset($endDate)) {
            $startDate = Carbon::today()->subWeek()->addDay(1)->format("Y-m-d");
            $endDate = Carbon::today()->format("Y-m-d");
        }


        $validator = $this->getValidatorResult($input);
        if ($validator->fails()) {
            return view('mealRecord.dateListRead')
                ->withErrors($validator)
                ->with('startDate', $startDate)
                ->with('endDate', $endDate);
        }


        $mealRecordDays = $this->getMealRecordDays($startDate, $endDate);
        $labelLists = [];
        foreach ($mealRecordDays as $mealRecordDay) {
            $labelLists[] = $mealRecordDay->date;
        }
//        $labelLists = json_encode($labelLists);

        return view('mealRecord.dateChartRead')
            ->with('mealRecordDays', $mealRecordDays)
            ->with('startDate', $startDate)
            ->with('endDate', $endDate)
            ->with('labelLists', $labelLists)
            ->with('mealRecordDays', $mealRecordDays);
    }


    private function getValidatorResult($input){
        $rules = [
            'startDate' => 'date',
            'endDate' => 'date|after_or_equal:startDate',
        ];
        $messages = [
            'endDate.after_or_equal' => '結束日期不能小於開始日期'
        ];

        $validator = Validator::make($input, $rules, $messages);
        return $validator;

    }



    private function getMealRecordDays($startDate, $endDate)
    {
        $user = Auth::user();

        $temp = [];

        $mealRecordDays = MealRecordDay::where('user_id', $user->id)
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->orderBy('date', 'ASC')->get();

        foreach ($mealRecordDays as $mealRecordDay) {
            $temp[] = $mealRecordDay;
        }

        // calc today
        $today = Carbon::today()->format("Y-m-d");
        if ($today == $endDate) {
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
            $mealRecordDay->date = $today;

            $temp[] = $mealRecordDay;
        }

        $mealRecordDays = $temp;
        return $mealRecordDays;
    }




}