<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //
    protected $fillable = [
        'user_id', 'category', 'category_name', 'name', 'weight', 'unit', 'sugar_gram', 'kcal'
    ];
    
    
    public function category(){
        return FoodCategory::where('id',$this->category)->first();
    }
    
    public function user(){
        return User::where('id',$this->user_id)->first();
    }
    
}
