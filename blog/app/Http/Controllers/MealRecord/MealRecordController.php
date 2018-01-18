<?php

namespace App\Http\Controllers\MealRecord;

use App\Food;
use App\MealRecord;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MealRecordController extends Controller
{

    use MealRecordDayCommon;

    public function read()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $mealRecords = MealRecord::where('user_id', $user->id)->whereDate('datetime', $today)->get();
        return view('mealRecord.mealRecordRead')->with('mealRecords', $mealRecords);
    }

    // 輸入當天
    public function create(Request $request)
    {
        $categorys = Food::select('category', 'category_name')->distinct('category')->get();
        return view('mealRecord.mealRecordCreate')->with('categorys', $categorys);
    }

    //輸入非當天
    public function createDate(Request $request)
    {
        $categorys = Food::select('category', 'category_name')->distinct('category')->get();
        return view('mealRecord.mealRecordCreate')
            ->with('categorys', $categorys)
            ->with('dateBool', true);
    }


    public function createStore(Request $request)
    {

        $input = $request->all();
        $dateExist = array_key_exists('date', $input);

        $rules = [
            'category' => 'required',
            'food' => 'required',
            'weight' => 'required',
            'num' => 'required',
        ];

        $messages = [
            'category.required' => '必填',
            'food.required' => '必填',
            'weight.required' => '必填',
            'num.required' => '必填',
        ];

        if ($dateExist) {
            $rules['date'] = 'required|date|date_format:"Y-m-d"|before:today';
            $messages['date.required'] = '必填';
            $messages['date.date'] = '只能輸入日期';
            $messages['date.before'] = '只能輸入今日以前';
            $messages['date.date_format'] = '日期格式為YYYY-MM-DD';
        }
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            if ($dateExist) {
                return Redirect::route('mealRecord.createDate')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                return Redirect::route('mealRecord.create')
                    ->withErrors($validator)
                    ->withInput();
            }

        }

        $user = Auth::user();
        // $datetime = date('Y-m-d H:i:s');
        if ($dateExist) {
            $datetime = $request->date;
        } else {
            $datetime = Carbon::now();
        }


        $foodId = $request->food;

        $food = Food::where('id', $foodId)->first();

        $mealRecord = new MealRecord;
        // 
        $gram = $request->weight * $request->num;
        $mealRecord->gram = $gram;
        // 
        $m_suger = $food->sugar_gram / $food->weight;
        $mealRecord->calories = $gram * $m_suger * 4;

        $mealRecord->user_id = $user->id;
        $mealRecord->weight = $gram * $m_suger;
        $mealRecord->num = $request->num;

        $mealRecord->datetime = $datetime;
//        $mealRecord->sugar_gram = $gram*$m_suger;
        $mealRecord->category = $food->category;
        $mealRecord->name = $food->name;
        $mealRecord->unit = $food->unit;
        $mealRecord->save();


        if ($dateExist) {
            $this->createMealRecordDay($user, $datetime, false);
            return Redirect::route('sevenMealRecord.readList')
                ->with('message', '新增成功');
        } else {
            return Redirect::route('mealRecord.read')
                ->with('message', '新增成功');
        }

    }


    public function getFood(Request $request)
    {
        $category = $request->category;
        if (!$category) {
            return response()->json([]);
        }
        $query = [['category', $category]];
        if ($category == 6) {
            $user = Auth::user();
            $query[] = ['user_id', $user->id];
        }
        $foods = Food::select('id', 'name')->where($query)->get();
        return response()->json($foods);
    }

    public function getFoodDesc(Request $request)
    {
        $food = $request->food;
        if (!$food) {
            return response()->json([]);
        }


        $food = Food::where('id', $food)->first();
        return response()->json($food);
    }

}
