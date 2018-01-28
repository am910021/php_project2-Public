<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Common;
    
    //
    protected $fillable = [
        'username', 'nickname', 'email', 'password', 'remarks', 'group'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $dates = ['created_at','updated_at', 'expiry_date'];
    
    
    protected $table = 'users';
    
    
    public function group()
    {
        if ($this->group == NULL){
            $this->group = 1;
            $this->save();
        }
        
        return $this->hasOne('App\Group', 'id', 'group')->first();
    }
    
    
    public function getSevenMealRecordAmount()
    {
        $count = 0;
        $now = Carbon::today();
        $temp = [];
        $date = Carbon::create($now->year,$now->month, $now->day, 0)->subWeek();
        $next_date = Carbon::create($now->year,$now->month, $now->day, 0)->subWeek()->addDay(1);
        for ($i = 0; $i <= 6; $i++) {
            $date->addDay(1);
            $next_date->addDay(1);
            
            $mealRecord = MealRecord::where('user_id',$this->id)->whereDate('datetime', '>=', $date->toDateString())
            ->whereDate('datetime', '<', $next_date->toDateString())->count();
            
            if($mealRecord > 0){
                $count++;
            }
            
        }

        
        
        
        //$mealRecordDay = MealRecordDay::where([['user_id','=', $this->id],[]])->whereDate('date', $date)->count();


        return $count;
    }
    
    public function getAmount()
    {
        $count = 0;
        $now = Carbon::today();
        $temp = [];
        $date = Carbon::create($now->year,$now->month, $now->day, 0)->subWeek()->subDay(1);
        $next_date = Carbon::create($now->year,$now->month, $now->day, 0)->subWeek();
        for ($i = 0; $i <= 6; $i++) {
            $date->addDay(1);
            $next_date->addDay(1);
            
            $mealRecord = MealRecord::where('user_id',$this->id)->whereDate('datetime', '>=', $date->toDateString())
            ->whereDate('datetime', '<', $next_date->toDateString())->count();
            
            if($mealRecord > 0){
                $count++;
            }
            
        }
        
        
        
        
        //$mealRecordDay = MealRecordDay::where([['user_id','=', $this->id],[]])->whereDate('date', $date)->count();
        
        
        return $count;
    }
    
}

