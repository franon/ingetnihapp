<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CAAkunController extends AdminController
{
    public function index(){
        return view('admin.index');
    }

    public function userUser(){
        $headers = parent::getToken();
        $dataUser = parent::callAPI("GET", "localhost:8000/api/get/allusers", false, $headers);
        $dataUser = json_decode($dataUser);
        $dataUser = $dataUser->data;
        return view('admin.config-akun.user-user', ['dataUser'=>$dataUser]);
    }
    
    // public funtion userAdd(){
    //     $dataUser = $request->validate([
    //         'event_name'=>'required',
    //         'event_date'=>'required | date_format:Y-m-d',
    //         'event_detail'=>'nullable',
    //         'event_date_end'=>'date_format:Y-m-d',
    //         'event_time'=>'nullable',
    //         'views' => 'required',
    //     ]);

    //     $headers = parent::getToken();
    //     $dataUser = parent::callAPI("POST", "localhost:8000/api/event/add", $dataUser, $headers);
    //     $dataUser = json_decode($dataUser);
    //     if($dataUser->status != 200) return back()->with(["tambahjadwal-error"=>"Gagal Tambah Acara"]);

    //     return redirect('/admin/event')->with(["tambahjadwal-success"=>"berhasil tambah acara"]);
    // }

    public function userGroup(){
        $headers = parent::getToken();
        $dataGroup = parent::callAPI("GET", "localhost:8000/api/get/group/allgroup", false, $headers);
        $dataGroup = json_decode($dataGroup);
        // dd($dataGroup);
        $dataGroup = $dataGroup->data;
        return view('admin.config-akun.group.user-group', ['dataGroup'=>$dataGroup]);
    }

    public function userGroupDetail($group_id){
        $headers = parent::getToken();
        $data = parent::callAPI("GET", "localhost:8000/api/get/group/related/".$group_id,false,$headers);
        $data = json_decode($data);
        // dd($data->data);
        $data = $data->data;
        return view('admin.config-akun.group.user-group-detail', compact('data'));
    }

    public function userEditShow($user_id){
        $headers = parent::getToken();
        $users = parent::callAPI('GET', "localhost:8000/api/get/users/".$user_id, false, $headers);
        $users = json_decode($users);
        // dd($users);
        $users = $users->data;
        return view('admin.config-akun.user-edit', compact('users'));
    }

    public function userEditData(Request $request){
        $dataUser = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'role_id'=>'required',
            'phone_number'=>'required',
            'gender'=>'nullable',
            'jabatan' => 'required',
        ]);

        $headers = parent::getToken();
        $dataUser = parent::callAPI("PUT", "localhost:8000/api/event/".$request->$event_id, $dataUser, $headers);
        $dataUser = json_decode($dataUser);
        if($dataUser->status != 200) return back()->with(["edituser-error"=>"Gagal ubah data user"]);

        return redirect('/admin/user/user')->with(["edituser-success"=>"berhasil ubah data user"]);
    }


}
