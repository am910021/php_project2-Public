<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Food as Food;


class MealRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // echo storage_path();  storage
        DB::table('foods')->delete();
        $CATEGORY_ARR = [
            "1" => "飲料類",
            "2" => "加工食品類",
            "3" => "糕餅類",
            "4" => "冰品類",
            "5" => "糖果類"
        ];
        $path = storage_path()."/json/category.json";
        $path = file_get_contents($path);
        
        $json = json_decode($path, TRUE);
        foreach ($json as $key => $category){
            $categoryId = $key;
            $categoryName = $CATEGORY_ARR[$key];
            foreach ($category as $key => $food){
                Food::create([
                    'user_id' => 0,  
                    'category' => $categoryId, 
                    'category_name' => $categoryName, 
                    'name' => $food['name'], 
                    'weight' => $food['weight'], 
                    'unit' => $food['unit'],
                    'sugar_gram' => $food['sugar_gram'], 
                    'kcal' =>  $food['kcal']
                ]);

            }

        }
        
        // echo $json[1][0]["name"];
        
        // $json = json_encode(file_get_contents($path)); 

        // $jsonIterator = new RecursiveIteratorIterator(
        //     new RecursiveArrayIterator(json_decode($json, TRUE)),
        //     RecursiveIteratorIterator::SELF_FIRST);

    
        // foreach ($jsonIterator as $key => $val) {
        //     if(is_array($val)) {
        //         echo "$key:\n";
        //     } else {
        //         echo "$key => $val\n";
        //     }
        // }
        // foreach($json as $key => $val){
        //     if(is_array($val)) {
        //         echo "$key:\n";
        //     } else {
        //         echo "$key => $val\n";
        //     }
        // }

    }
}
