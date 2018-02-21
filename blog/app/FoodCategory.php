<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    //
    
    
    public function gettheAmountOfFoodAttribute(){
        return Food::where('category_id',$this->id)->count();
    }
    
    
}
