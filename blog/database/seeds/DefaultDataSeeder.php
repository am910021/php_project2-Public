<?php 
use App\User as User;
use App\Food as Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultDataSeeder extends Seeder {
    public function run()
    {
        DB::table('users')->delete();      
        $user = new User;
        $user->username = 'root';
        $user->nickname = 'root';
        $user->email = 'root@localhost';
        $user->password = Hash::make('root');
        $user->save();
        
        
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
                    'user_id' => $user->id,
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
        
        
    }
}
