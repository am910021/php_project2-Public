<?php 
use App\User as User;
use App\Food as Food;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Group;

class DefaultDataSeeder extends Seeder {
    
    private function createGroup(){
        DB::statement("SET foreign_key_checks=0");
        Group::truncate();
        $group = new Group();
        $group->name = '無群組';
        $group->remarks = '無群組者專用';
        $group->save();
        return $group;
        
    }
    
    private function createUser(){
        DB::statement("SET foreign_key_checks=0");
        User::truncate(); 
        $user = new User;
        $user->username = 'root';
        $user->nickname = 'root';
        $user->email = 'root@localhost';
        $user->password = Hash::make('root');
        $user->isActive = true;
        $user->type = 0;
        $user->remarks = '此帳戶為超級管理員，請盡速更改密碼。';
        $user->save();
        return $user;
    }
    
    public function run()
    {
        $group = $this->createGroup();
        $user = $this->createUser();
        
        $group->manager = $user->id;
        $group->save();
        $user->group = $group->id;
        $user->save();
        $this->createFoodsCategory($user);
    }
    
    
    public function createFoodsCategory($user){
        Food::truncate();
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
