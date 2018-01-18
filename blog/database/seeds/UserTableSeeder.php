<?php
use App\User as User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder {
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'username' => 'test',
            'password' => Hash::make('test'),
        ]);
    }
}