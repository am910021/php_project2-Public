<?php

namespace App\Http\Controllers\MealRecord;

use App\User;
use App\MealRecord;
use App\MealRecordDay;
use App\Http\Controllers\Controller;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

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

        $dateAvg =$this->getDate($startDate, $endDate);
        $mealRecordDays = $this->getMealRecordDays($startDate, $endDate);

        return view('mealRecord.dateListRead')
            ->with('startDate', $startDate)
            ->with('endDate', $endDate)
            ->with('mealRecordDays', $mealRecordDays)
            ->with('dateAvg', $dateAvg);
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

    private function getDate($startDate, $endDate){
        $user = Auth::user();
        
        
        $dateAvg = MealRecord::selectRaw('ROUND((SUM(percent)/Count(DISTINCT DATE(datetime))),3) as dpercent ,'
            . 'ROUND(((SUM(weight)/Count(DISTINCT DATE(datetime)))*4),3) as dtcal,'
            . 'ROUND((SUM(weight)/Count(DISTINCT DATE(datetime))),3) as dsugar')->where('user_id', $user->id)
                                                        ->whereDate('datetime', '>=', $startDate)
                                                        ->whereDate('datetime', '<=', $endDate)
                                                        ->groupBy('user_id')->first();
        return $dateAvg;
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
            select(DB::raw('SUM(calories) calories, 
                            SUM(weight) weight, 
                            ROUND(SUM(percent),3) percent '))
                ->where('user_id', $user->id)
                ->whereDate('datetime', $today)->first();
            $calories = $mealRecord['calories'] ?? 0;
            $weight = $mealRecord['weight'] ?? 0;
            $percent = $mealRecord['percent'] ?? 0;

            $mealRecordDay = new MealRecordDay;
            $mealRecordDay->user_id = $user->id;
            $mealRecordDay->calories = $calories;
            $mealRecordDay->weight = $weight;
            $mealRecordDay->date = $today;

            $mealRecordDay->percent = $percent;
            $userProfile = UserProfile::where('user_id', $user->id)->first();

            $mealRecordDay->age = $userProfile->age;
            $mealRecordDay->height = $userProfile->height;
            $mealRecordDay->p_weight = $userProfile->weight;
            $mealRecordDay->activity_amount = $userProfile->activity_amount;
            $mealRecordDay->rc = $userProfile->rc;

            $temp[] = $mealRecordDay;
        }

        $mealRecordDays = $temp;
        return $mealRecordDays;
    }




}