<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\FoodCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Food;


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
            'foods'=> Food::where('category_id',$id)->get(),
        ];
        return View::make('admin.food.showFood',$message);
        
    }
    
    public function foodCreate($id){
        $category = FoodCategory::where('id',$id)->first();
        if($id <= 2 || $category == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的類別選擇。');
        }
        
        
        
        
        
        
        
        
        
        
    }
    
    public function foodEdit($id){
        $food = Food::where('id',$id)->first();
        if($food == NULL){
            return Redirect::route('admin.showCategory')->with('message-fail','錯誤的食品選擇。');
        }
        
    }
    
    
    
    
    
}