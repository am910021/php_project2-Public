<?php
use App\User as User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Group;

class TestUserDeeder extends Seeder {
    public function createGroup(){
        for ( $i=0 ; $i<10 ; $i++ ) {
            $user = new User();
            $user->email = 'Gtest' . $i . '@localhost.com';
            $user->username = 'GtestUser'.$i;
            $user->nickname = 'Gtu'.$i;
            $user->isActive = true;
            $user->password = Hash::make('test');
            $user->type = 2;
            $user->group = Group::where('id',1)->first()->id;
            $user->save();
            
            $group = new Group();
            $group->manager = $user->id;
            $group->name = 'group_test'.$i;
            $group->remarks = '測試群組'.$i;
            $group->save();
        }
    }
    
    public function createUser(){
        for ( $i=0 ; $i<20 ; $i++ ) {
            $user = new User();
            $user->email = 'test' . $i . '@localhost.com';
            $user->username = 'testUser'.$i;
            $user->nickname = 'tu'.$i;
            $user->isActive = true;
            $user->password = Hash::make('test');
            $user->type = 3;
            $user->group = rand(1,11);
            $user->save();
        }
    }
    
    
    
    public function run()
    {
        $this->createGroup();
        $this->createUser();

    }
}