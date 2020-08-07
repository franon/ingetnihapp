<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\Notifikasi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function getNotifikasiUserPribadi(){

        try {
            $result = Notifikasi::where('pengguna.user_id',Auth()->user()->user_id)
                ->leftJoin('pengguna','notifikasi.user_id','=','pengguna.user_id')
                ->leftJoin('group','notifikasi.group_id','=','group.group_id')
                ->leftJoin('acara','notifikasi.event_id','=','acara.event_id')
                ->leftJoin('berita','notifikasi.berita_id','=','berita.berita_id')
                ->select('pengguna.user_id','berita.berita_judul','acara.event_name','acara.event_date','group.group',
                'notifikasi.notifikasi_id','notifikasi.group_id','notifikasi.event_id','notifikasi.berita_id','notifikasi.message','notifikasi.date_notified')->get();
        } catch (\Throwable $th) {
            return response()->json(["status"=> 404, "message"=>$th->getMessage()],404);
        }
        return response()->json(["status"=> 200, "message"=>"Notifikasi User", 'data'=>$result], 200);
    }
    public function getNotifikasiUserTertentu(Request $request){
        $user_id = $request->get('user_id');
        if(!empty($request->get('notified'))){
            $result = Notifikasi::where([['pengguna.user_id','=',$user_id],['already_notified','=',$request->get('notified')]])
                    ->leftJoin('pengguna','notifikasi.user_id','=','pengguna.user_id')
                    ->leftJoin('group','notifikasi.group_id','=','group.group_id')
                    ->leftJoin('acara','notifikasi.event_id','=','acara.event_id')
                    ->leftJoin('berita','notifikasi.berita_id','=','berita.berita_id')
                    ->select('pengguna.user_id','berita.berita_judul',
                            'notifikasi.notifikasi_id','notifikasi.group_id','notifikasi.event_id','notifikasi.berita_id','notifikasi.message','already_notified')->get();
        }else{
            $result = Notifikasi::where('pengguna.user_id',$user_id)
            ->leftJoin('pengguna','notifikasi.user_id','=','pengguna.user_id')
            ->leftJoin('group','notifikasi.group_id','=','group.group_id')
            ->leftJoin('acara','notifikasi.event_id','=','acara.event_id')
            ->leftJoin('berita','notifikasi.berita_id','=','berita.berita_id')
            ->select('pengguna.user_id','berita.berita_judul',
                    'notifikasi.notifikasi_id','notifikasi.group_id','notifikasi.event_id','notifikasi.berita_id','notifikasi.message')->get();
        }
        return response()->json(["status"=> 200, "message"=>"Notifikasi User", 'data'=>$result], 200);
    }

    public function NotifyUser($type, $data, $message){
        switch ($type) {
            case 'group':
                $insert = [
                    "notifikasi_id"=>'nt-'.sha1(time()),
                    "message"=>$message,
                    "group_id"=>$data["group_id"],
                    "user_id"=>$data["user_id"],
                    "date_notified"=>Carbon::now()->toDateString(),
                    "already_notified"=>0,
                ];
                $datax = Notifikasi::create($insert);
                break;
            case 'event':
                $event = Event::where('event_id', $data['event_id'])->first();
                $user = User::where('user_id', $data['user_id'])->first();
                $user->UserNotif()->sync($event->event_id);
                break;
        }
        // var_dump(json_encode($datax));die;
        // return response()->json(["status"=> 200, "message"=>"Ok", 'data'=>$datax], 200);
    }

    public function notifiedBroadcast(Request $request){
        $notified = $request->notified;
        $notifikasi_id = $request->notifikasi_id;
        
        $notifikasi = Notifikasi::where('notifikasi_id',$notifikasi_id)->first();
        $notifikasi->already_notified = $notified;
        $notifikasi->save();

        $notifikasiClear = Notifikasi::where('notifikasi_id',$notifikasi_id)->first();

        return response()->json(['message' => 'Update Success!','data' => $notifikasiClear]);
    }

    public function insertInject(Request $request){
        // dd($request->event_id);
        $insert = [
            "notifikasi_id"=>'nt-'.sha1(time()),
            "event_id"=>$request->event_id,
            "user_id"=>$request->user_id,
            "date_notified"=>Carbon::now()->toDateString(),
            "already_notified"=>0,
        ];
        $datax = Notifikasi::create($insert);
        return response()->json(["status"=>200,"message"=>"OK", 'data'=>$datax],200);
    }
}
