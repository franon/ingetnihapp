<?php

namespace App\Http\Controllers\ingetnih\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profileShow(){
        return view('account.profile');
    }
    
    public function myNotify(){
        $token = session()->get('token');
        // $headers
    }
    
    
}
