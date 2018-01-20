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
        return $this->hasOne('App\User', 'id', 'manager')->first();
    }
}
