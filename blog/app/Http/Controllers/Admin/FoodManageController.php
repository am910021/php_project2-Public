<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\FoodCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Food;
use App\MealRecord;


class FoodManageController extends Controller{
    
    public function showCatrgory(){
        $message = [
            'categories'=> FoodCategory::where('id', '>','2')->get(),
        ];
        return View::make('admin.food.showCategory',$message);
    }
    
    public function editCatrgory($id){
        $category = FoodCategory::where('id',$id)->first();
        if($id <= 2 || $category == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的類別選擇。');
        }
        
        
        
        $message = [
            'category'=> $category,
        ];
        return View::make('admin.food.editCategory',$message);
    }
    
    public function updateCatrgory(Request $request, $id){
        $category = FoodCategory::where('id',$id)->first();
        if($id <= 2 || $category == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的類別選擇。');
        }
        
        
        
        
        $rules = [
            'categoryName' => 'required|string',
        ];
        $messages = [
            'categoryName.required'=> '類別名稱 不能留空。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.editCatrgory', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $old_name = $category->name;
        $new_name = $request->get('categoryName');
        
        $category->name = $request->get('categoryName');
        $category->save();
        
        if($old_name != $new_name){
            return Redirect::route('admin.showCategory')->with('message','類別"'.$old_name.'"成功變更為"'.$new_name.'"。');
        }
        return Redirect::route('admin.showCategory')->with('message','類別"'.$old_name.'"儲存成功。');
        
    }
    
    public function foodShow($id){
        $category = FoodCategory::where('id',$id)->first();
        if($id <= 2 || $category == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的類別選擇。');
        }
        
        $message = [
            'category' => $category,
            'foods'=> Food::where('category',$id)->get(),
        ];
        return View::make('admin.food.showFood',$message);
        
    }
    
    public function foodCreate($id){
        $category = FoodCategory::where('id',$id)->first();
        if($id <= 2 || $category == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的類別選擇。');
        }
        
        $message = [
            'category' => $category,
        ];
        
        return View::make('admin.food.create',$message);
    }
    
    public function foodCreateStore(Request $request, $id){
        $category = FoodCategory::where('id',$id)->first();
        if($id <= 2 || $category == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的類別選擇。');
        }
        $validator = Validator::make($request->all(), $this->getRules(0), $this->getMessages());
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.foodCreate', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $user = Auth::user();
        
        $food = new Food;
        $food->user_id = $user->id;
        $food->category = $category->id;
        $food->category_name = $category->name;
        $food->name = $request->name;
        $food->weight = $request->weight;
        $food->unit = $request->unit;
        $food->sugar_gram = $request->sugar_gram;
        $food->kcal = $request->kcal;
        $food->save();
        
        return Redirect::route('admin.foodShow', ['id'=>$category->id])->with('message', '新增成功');
    }
    
    
    
    public function foodEdit($id){
        $food = Food::where('id',$id)->first();
        if($food == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的食品選擇。');
        }
        $message = [
            'food' => $food,
            'categorys' =>FoodCategory::where('id','>',2)->get(),
        ];
        
        
        return View::make('admin.food.edit',$message);
    }
    
    public function foodEditStore(Request $request, $id){
        $food = Food::where('id',$id)->first();
        if($food == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的食品選擇。');
        }
        $validator = Validator::make($request->all(), $this->getRules(), $this->getMessages());
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.foodEdit', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $category = FoodCategory::where('id',$request->category)->first();
        
        $food->category = $category->id;
        $food->category_name = $category->name;
        $food->name = $request->name;
        $food->weight = $request->weight;
        $food->unit = $request->unit;
        $food->sugar_gram = $request->sugar_gram;
        $food->kcal = $request->kcal;
        $food->save();
        
        return Redirect::route('admin.foodShow', ['id'=>$category->id])->with('message', $food->name.'修改成功。');
    }
    
    public function customList(){
        $message = [
            'list' => Food::where('category',2)->get(),
            
        ];
        
        return View::make('admin.food.customList',$message);
    }
    
    public function customAdd($id){
        $food = Food::where('id',$id)->first();
        if($food == NULL){
            return Redirect::route('admin.foodCustom')->with('message-fail','錯誤的食品選擇。');
        }
        $message = [
            'food' => $food,
            'categorys' =>FoodCategory::where('id','>',2)->get(),
        ];
        
        
        return View::make('admin.food.customAdd',$message);
    }

    public function customUpdate(Request $request, $id){
        $food = Food::where('id',$id)->first();
        if($food == NULL){
            return Redirect::route('admin.foodCustom')->with('message-fail','錯誤的食品選擇。');
        }
        $validator = Validator::make($request->all(), $this->getRules(), $this->getMessages());
        //fails
        // $validator->passes()
        if ($validator->fails()) {
            return Redirect::route('admin.foodCustomAdd', ['id'=>$id])
            ->withErrors($validator)
            ->withInput();
        }
        
        $category = FoodCategory::where('id',$request->get('category'))->first();
        
        $mealRecords = MealRecord::where('food_id', $food->id)->get();
        foreach($mealRecords as $mealRecord){
            $mealRecord->category = $category->id;
            $mealRecord->timestamps = false;
            $mealRecord->save();
        }
        
        
        $food->user_id = 1;
        $food->category = $category->id;
        $food->category_name = $category->name;
        $food->name = $request->name;
        $food->weight = $request->weight;
        $food->unit = $request->unit;
        $food->sugar_gram = $request->sugar_gram;
        $food->kcal = $request->kcal;
        $food->save();
        
        return Redirect::route('admin.foodShow', ['id'=>$category->id])->with('message', $food->name.'修改成功。');
    }
    
    
    
    
    private function getRules($mode=1){
        $rules = [
            'name' => 'required|string',
            'weight' => 'required|numeric',
            'unit' => 'required|string',
            'sugar_gram' => 'required|numeric',
            'kcal' => 'required|numeric',
        ];
        
        if($mode==1){
            $rules['category'] = 'required|exists:food_categories,id';
        }
        
        return $rules;
    }
    
    private function getMessages(){
        $messages = [
            'category.exists'=> '所選擇的 類別 選項無效。',
            'category.required'=> '類別 不能留空。',
            'name.required'=> '名稱 不能留空。',
            'weight.required'=> '份量 不能留空。',
            'unit.required'=> '單位 不能留空。',
            'sugar_gram.required'=> '糖量 不能留空。',
            'kcal.required'=> '熱量 不能留空。',
            
            'weight.numeric'=> '份量 欄位請隃入數字。',
            'sugar_gram.numeric'=> '糖量 欄位請隃入數字。',
            'kcal.numeric'=> '熱量 欄位請隃入數字。',
            
        ];
        return $messages;
    }
    
}