<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Events\AdminCreateEvent;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Mail\EventReminderEmail;
use App\Notifikasi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function __construct(){
    }
    
    public function getAllEvent(){
        try {
            $dataEvent = Event::where("acara.user_id","like", "adm_%")->orWhere("acara.user_id","like", "bot")->get();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return response()->json(["status"=>200, "message"=>"Semua Event", "data"=>$dataEvent],200);
    }

    public function getEventSpesific($event_id){
        try {
            $dataEvent = Event::where('event_id', $event_id)->first();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return response()->json(['status'=>200, 'message'=>'Cari acara tertentu','data'=>$dataEvent],200);
    }

    public function getEventBy($type, $id){
        try {
            switch ($type) {
                case 'user':
                    $user = User::where('user_id', $id)->first();
                    $event = $user->eventUsers;
                    break;
                case 'group':
                    $group = Group::where('group_id', $id)->first();
                    $event = $group->groupEvent;
                    break;
                default:
                    return response()->json(["status"=>500, "message"=>"Harus memilih tipe Grup atau pengguna!"],500);
            }            
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }

        return response()->json(["status"=>200, "message"=>"OK", "data"=>$event],200);
    }

    public function store(StoreEvent $request){
        try {
        $dataEvent = $request->validated();
        $dataEvent['event_id'] = 'evt-'.sha1(rand());
        $dataEvent['user_id'] = auth()->user()->user_id;
        $dataEvent['created_by'] = auth()->user()->name;
        
        $event = Event::create($dataEvent);

        $notif = new Notifikasi();
        $user = User::all();
        if(substr($dataEvent['user_id'],0,3) === "adm") $notif->toMultiDevice($user,$event->event_name, 'Haloo, Ada acara baru nih di UBL, Cek Yuk!', null,null,$event->toArray());
        // $notif->singleTopic('event',$event->event_name,'Admin menambahkan acara baru, Cek Yuk!');

        if(!empty($request->belongs_to)) self::shareEventWith($event->event_id, $request->belongs_to);
        self::shareEventWith($event->event_id, $dataEvent["user_id"]);
    
        } catch (\Throwable $th) {
            return response()->json(["Error"=>$th->getMessage()],422);
        }
    
        return response()->json(["status"=>200, "message"=>"Data acara berhasil ditambah", "data"=>$event],200);
    }
    
    public function storeFromScrap($data){
        try {
        $data['event_id'] = 'evt-PF'.sha1(rand());
        $data['event_name'] = $data["title"];
        $data['event_date'] = $data["date"];
        if(isset($data["date_end"])) $data['event_date_end'] = $data["date_end"];
        $data['user_id'] = 'bot';
        $data['created_by'] = 'bot';
        $data['views'] = 'public';
        // $belongs_to = 'g20-pkh';

        $data = Event::create($data);
        // self::shareEventWith($data["event_id"], $belongs_to);    
        } catch (\Throwable $th) {
            return false;
        }
        return $data;
    }

    public function shareEventWith($event,$belongs_to){
        $shareWith = substr($belongs_to,0,1);
        switch ($shareWith) {
            case 'g' :
                self::storeGroupEvent($event,$belongs_to);
                break;
            case 'u':
                self::storeUserEvent($event,$belongs_to);
                break;
            case 'm':
                self::storeUserEvent($event,$belongs_to);
            break;
            case 'd':
                self::storeUserEvent($event,$belongs_to);
            break;
            case 'a':
                self::storeUserEvent($event,$belongs_to);
            break;
            
        }
    }

    public function storeGroupEvent($event_id,$group_id){
        $group = \App\Group::where('group_id', $group_id)->first(); //btuh validasi jika tidak ada group
        $groupClear = \App\Group::where('group_id', $group_id)->get(); //btuh validasi jika tidak ada group
        $event = Event::where('event_id', $event_id)->first();
        $event->groupEvent()->sync($group->group_id,false);

        foreach($groupClear as $grp){
            foreach($grp->groupUsers as $user){
                self::storeUserEvent($event_id, $user->user_id);
            }
        }
    }

    public function storeUserEvent($event_id,$user_id){
        $user = \App\User::where('user_id', $user_id)->first(); //btuh validasi jika tidak ada user
        // var_dump($event_id);
        $event = Event::where('event_id', $event_id)->first();
        $event->eventUsers()->attach($user->user_id);
    }
    
    public function updateEvent(UpdateEvent $request, $event_id){
        $dataEvent = $request->validated();
        
        $previous_event = Event::where('event_id', $event_id)->first();
        $event = Event::where('event_id', $event_id)->first();
        // var_dump($dataEvent);
        $event->user_id = auth()->user()->user_id;
        $event->event_name = $dataEvent['event_name'];
        $event->event_date = $dataEvent['event_date'];
        $event->event_date_end = $dataEvent['event_date_end'];
        $event->event_time = $dataEvent['event_time'];
        $event->event_detail = $dataEvent['event_detail'];
        $event->views = $dataEvent['views'];
        $event->save();

        return response()->json(['message' => 'Update Success!','previous_data'=>$previous_event, 'data' => $event]);
    }

    public function removeEvent($event_id){
        Event::destroy($event_id);
        return response()->json(["status"=>202, 'message' => "event deleted!"]);
    }

    // Duplicate
    public function addEventToGroup($group_id,$event_id){
        $team = \App\Group::where('group_id', $group_id)->first(); //btuh validasi jika tidak ada group
        $event = Event::where('event_id', $event_id)->first();
        $event->groupEvent()->sync($team->group_id,false);
        return response()->json(['data'=>$event],$this->successStatus);
    }

    public function acaraJadwal(){
        $event = Event::all();
        return Datatables::of($event)
                            ->addColumn("action", function($evt){
                                return '
                                <td> 
                                <a href="/admin/event/edit/'.$evt->event_id.'" class="btn btn-outline-info mb-3"><i class="fa fa-pencil" aria-hidden="true">edit</i></a> |
                                <a href="/admin/event/delete/'.$evt->event_id.'" class="btn btn-outline-info mb-3"><i class="fa-ban"></i> remove</a>
                                </td>';
                            })
                            ->make(true);
    }

    public function filterEvent($type, Request $request){
        $date = trim(preg_replace('/[\t|\s]*/','',$request->when));
        // $date = $request->when;
        $views = $request->views;
        $user = $request->user_id;
        $time = $request->time;
        try {
            switch ($type) {
                case 'date':
                    if(isset($date)){
                        if(isset($time)){
                            $event = Event::where([['event_date','=',$date],['pengguna.user_id','=',$user],['views','=',$views],['event_time','=',$time]])
                                ->join('user_event','acara.event_id','=','user_event.event_id')
                                ->join('pengguna','pengguna.user_id','=','user_event.user_id')
                                ->select('acara.*')->get()->toArray();
                            $official = Event::where([['user_id','like','adm_%'],['event_time','=',$time],['event_date','=',$date]])->orWhere([['user_id','like','bot%'],['event_time','=',$time],['event_date','=',$date]])->get()->toArray();
                            $event = array_merge($event,$official);
                        }else{
                            $event = Event::where([['event_date','=',$date],['pengguna.user_id','=',$user],['views','=',$views]])
                                ->join('user_event','acara.event_id','=','user_event.event_id')
                                ->join('pengguna','pengguna.user_id','=','user_event.user_id')
                                ->select('acara.*')->get()->toArray();
                                $official = Event::where([['user_id','like','adm_%'],['event_date','=',$date]])->orWhere([['user_id','like','bot%'],['event_date','=',$date]])->get()->toArray();
                            $event = array_merge($event,$official);
                        }
                    }else{
                        $event = Event::where([['event_date','=',Carbon::now()->toDateString()],['pengguna.user_id','=',$user],['views','=',$views]])
                                ->join('user_event','acara.event_id','=','user_event.event_id')
                                ->join('pengguna','pengguna.user_id','=','user_event.user_id')
                                ->select('acara.*')->get()->toArray();
                        $official = Event::where('user_id','like','adm_%')->orWhere('user_id','like','bot%')->get()->toArray();
                        $event = array_merge($event,$official);
                    }
                    break;
                default:
                    // return false;
                    break;
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
        
        
        return response()->json(["status"=>200,"message"=>"OK", "data"=>$event],200);
    }

    public function searchEvent(Request $request){
        $event = Event::where([["event_name","like",'%'.$request->get("search").'%'],["user_id","like",'adm%']])->get();
        return response()->json(["status"=>200,"message"=>"Search Event", "data"=>$event],200);
    }
}
