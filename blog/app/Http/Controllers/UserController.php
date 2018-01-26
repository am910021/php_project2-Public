<?php

namespace App\Http\Controllers;


class UserController extends Controller
{
    
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return 
     */
    public function show($id)
    {
        
        return view('user.welcome2');
    }
}