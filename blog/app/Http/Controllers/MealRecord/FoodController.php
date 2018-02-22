<?php

namespace App\Http\Controllers\MealRecord;

use App\Food;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{

    public function create(Request $request)
    {
        $message = [
            'url' => $request->url,
            
        ];
        
        return view('mealRecord.foodCreate',$message);
    }

    public function createStore(Request $request)
    {

        $input = $request->all();

        $rules = [
            'name' => 'required',
            'weight' => 'required',
            'unit' => 'required',
            'sugar_gram' => 'required',
            'kcal' => 'required'
        ];

        $messages = [
            'name.required' => '必填',
            'weight.required' => '必填',
            'unit.required' => '必填',
            'sugar_gram.required' => '必填',
            'kcal.required' => '必填'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::route('food.create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $food = new Food;
        $food->user_id = $user->id;
        $food->category = 2;
        $food->category_name = '自行輸入';
        $food->name = $request->name;
        $food->weight = $request->weight;
        $food->unit = $request->unit;
        $food->sugar_gram = $request->sugar_gram;
        $food->kcal = $request->kcal;
        $food->save();

        
        if($request->url != null){
            return Redirect::to($request->url)
            ->with('message', '新增成功');
        }
        
        
        return Redirect::route('mealRecord.create')
                ->with('message', '新增成功');


    }


}