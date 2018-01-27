<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'manager', 'name', 'remarks'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $table = 'groups';
    
    public function manager()
    {
        if ($this->manager == NULL){
            $this->manager = 1;
            $this->save();
        }
        return $this->hasOne('App\User', 'id', 'manager')->first();
    }
    
    
    public function member(){
        return User::where('group',$this->id)->get();
    }
    
    
    public function amount(){
        
        return $this->member()->count();
        
    }
    
    public function getamountAttribute()
    {
        return $this->member()->count();
    }
    
    public function getapplyingAttribute()
    {
        return $this->member()->where('isApplying',true)->count();
    }
    
}
