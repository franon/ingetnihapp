<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CAJadwalController extends AdminController
{
    public function acaraJadwal(){
        return view('admin.config-jadwal.jadwal.jadwal');
    }

    public function acaraJadwalAddShow(){
        return view('admin.config-jadwal.jadwal.jadwal-add');
    }

    public function acaraJadwalAddData(Request $request){
        $dataEvent = $request->validate([
            'event_name'=>'required',
            'event_date'=>'required | date_format:Y-m-d',
            'event_detail'=>'nullable',
            'event_date_end'=>'date_format:Y-m-d',
            'event_time'=>'nullable',
            'views' => 'required',
        ]);

        $headers = parent::getToken();
        $dataEvent = parent::callAPI("POST", "localhost:8000/api/event/add", $dataEvent, $headers);
        $dataEvent = json_decode($dataEvent);
        if($dataEvent->status != 200) return back()->with(["tambahjadwal-error"=>"Gagal Tambah Acara"]);

        return redirect('/admin/event')->with(["tambahjadwal-success"=>"berhasil tambah acara"]);
    }

    public function acaraJadwalEditShow($event_id){
        $headers = parent::getToken();
        $event = parent::callAPI('GET', "localhost:8000/api/event/".$event_id, false, $headers);
        $event = json_decode($event);
        $event = $event->data;
        return view('admin.config-jadwal.jadwal.jadwal-edit', compact('event'));
    }

    public function acaraJadwalEditData(Request $request){
        $dataEvent = $request->validate([
            'event_name'=>'required',
            'event_date'=>'required | date_format:Y-m-d',
            'event_detail'=>'nullable',
            'event_date_end'=>'date_format:Y-m-d',
            'event_time'=>'nullable',
            'views' => 'required',
        ]);

        // dd($request->event_id);
        $headers = parent::getToken();
        $dataEvent = parent::callAPI("PUT", "localhost:8000/api/event/".$request->$event_id, $dataEvent, $headers);
        $dataEvent = json_decode($dataEvent);
        if($dataEvent->status != 200) return back()->with(["editjadwal-error"=>"Gagal ubah Acara"]);

        return redirect('/admin/event')->with(["editjadwal-success"=>"berhasil ubah acara"]);
    }
}
