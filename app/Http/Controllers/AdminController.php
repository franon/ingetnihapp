<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        return redirect('/users/login');
        
    }
    
    public function getToken(){
        $token = session()->get('token');
        $headers = "Authorization: Bearer ".$token;
        return $headers;
    }
}
