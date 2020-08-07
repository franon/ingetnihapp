<?php

namespace App\Http\Controllers\ingetnih;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function Notifikasi(){
            $token = session()->get('token');
            // dd($token);
            $headers = 'Authorization: Bearer '.$token;
            $notifikasi = parent::callAPI('GET', 'localhost:8000/api/get/notifikasi',false,$headers);

            $notifikasi = json_decode($notifikasi,true);
            $notifikasi = $notifikasi["data"];
            return $notifikasi;
    }

    public function index(){
        $event = parent::callAPI('GET', 'localhost:8000/api/event/all',false);
        // $notif = parent::callAPI('GET', 'localhost:8000/api/testing/push',false);
        $event = json_decode($event,true);
        $event = $event["data"];
        if(!empty(session()->get('token'))){
            $notifikasi = self::Notifikasi();
            return view('ingetnih.homepage', compact(['event','notifikasi']));
        }
        return view('ingetnih.homepage', compact('event'));
    }

    public function registerShow(){
        return view('account.register');
    }

    public function register(Request $request){
        $data = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "role_id" => "required"
            ]);
        $result = parent::callAPI("POST", "localhost:8000/api/users/register", $data);
        $result = json_decode($result);
        if($result->message != "registered!"){
            return back()->with("error", "gagal buat akun");
        }
        return redirect('/users/login')->with("success","Akun berhasil dibuat");

    }

    public function loginShow(){
        return view('account.login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'device_token'=>'nullable'
        ]);

        $data = ["email"=>"$request->email", "password"=>"$request->password", "device_token"=>$request->device_token];
        $result = parent::callAPI('POST', 'localhost:8000/api/users/login', $data);
        $result = json_decode($result);
        if($result->status == 401) return redirect()->back()->withErrors("error", "Email/Password");
        session()->put(['token'=>$result->token, 'data'=> $result->data]);

        if(session()->get('data')->role_id == 1) return redirect('/admin/dashboard');

        return redirect()->intended('/');
    }

    public function logout(Request $request){
        $token = session()->get('token');
        if(empty($token)) return redirect('ccc');
        $headers = "Authorization: Bearer ".$token;
        $data = parent::callAPI('DELETE','localhost:8000/api/users/logout',false,$headers);
        session()->flush();
        return redirect('/')->with("info", "kamu berhasil logout!");

    }

    public function searchDosenShow(){
        if(!empty(session()->get('token'))){
            $notifikasi = self::Notifikasi();
            return view('ingetnih.dosen-results',compact('notifikasi'));
        }
        return view('ingetnih.dosen-results');
    }

    public function searchDosenData(Request $request){
        $search = $request->get("search");
        
        if(!isset($search)) {
            $dosen = parent::callAPI('GET', 'localhost:8000/api/search/dosen/all',false);
        }else{
            $dosen = parent::callAPI('GET', 'localhost:8000/api/search/dosen?search='.$search,false);
        }
        $dosen = json_decode($dosen);
        $dosenData = $dosen->data;
        if(!empty(session()->get('token'))){
            $notifikasi = self::Notifikasi();
            return view("ingetnih.dosen-results",compact(['dosenData','notifikasi']));
        }
        return view('ingetnih.dosen-results',compact('dosenData'));

    }

    public function searchEventData(Request $request){
        $search = $request->get("cariacara");
        // session()->get('token');
        // dd($search);
        if(empty($search)) {
            $event = parent::callAPI('GET', 'localhost:8000/api/search/event',false,false);
        }else{
            $event = parent::callAPI('GET', 'localhost:8000/api/search/event?search='.$request->get("cariacara"),false);
        }
        $event = json_decode($event);
        $eventData = $event->data;
        if(!empty(session()->get('token'))){
            $notifikasi = self::Notifikasi();
            return view("ingetnih.event-results",compact(['eventData','notifikasi']));
        }
        return view("ingetnih.event-results",compact('eventData'));
    }
    
}