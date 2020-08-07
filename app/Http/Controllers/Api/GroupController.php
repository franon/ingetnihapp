<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public function addNewGroup(Request $request){
        $dataGroup = $request->validate([
            'group_id' => 'required',
            'group' => 'required'
        ]);

        $dataGroup['created_by'] = Auth()->user()->name;
        $dataGroup = Group::create($dataGroup);

        return response()->json(["status"=>200, "message"=>"Group Baru berhasil dibuat!", "data"=>$dataGroup],200);

    }

    public function getAllGroup(){
        $dataGroup = Group::all();
        return response()->json(["status"=> 200, "message"=>"Berhasil mengambil semua Group", "data"=>$dataGroup], 200);
    }

    public function getGroupSpesific($group_id){
        $dataGroup = Group::where('group_id', $group_id)->first();
        return response()->json(["status"=> 200, "message"=>"Berhasil mengambil Group Tertentu", "data"=>$dataGroup], 200);
    }

    public function getGroupEvent($group_id){
        $data = Event::where('group.group_id', $group_id)
                        ->join('group_event', 'acara.event_id' , '=', 'group_event.event_id')
                        ->join("group", 'group.group_id', '=', 'group_event.group_id')
                        ->select('*')->get();
        return response()->json(["status"=> 200, "message"=>"OK", "data"=>$data], 200);
    }

    public function getGroupDataEventUser($group_id){
        $data = [];
        $data['group'] = self::getGroupDetail($group_id);
        $data['user'] = self::getDataRelateWithGroup('user',$group_id);
        $data['event'] = self::getDataRelateWithGroup('event',$group_id);
        return response()->json(["status"=> 200, "message"=>"OK", "data"=>$data],200);
    }

    public function getGroupDetail($group_id){
        $data = Group::where('group_id', $group_id)->get();
        return $data;
    }

    public function getDataRelateWithGroup($type,$group_id){
        switch ($type) {
            
            case 'user':
                $data = User::where('group.group_id', $group_id)
                    ->join('group_users', 'pengguna.user_id' , '=', 'group_users.user_id')
                    ->join("group", 'group.group_id', '=', 'group_users.group_id')
                    ->select('*')->get();        
                break;
            
            case 'event':
                $data = Event::where('group.group_id', $group_id)
                        ->join('group_event', 'acara.event_id' , '=', 'group_event.event_id')
                        ->join("group", 'group.group_id', '=', 'group_event.group_id')
                        ->select('*')->get();
                break;
        }
        return $data;
    }

    public function destroyGroup($group_id){
        $data = Group::where('group_id',$group_id);
        $data->delete();
        return response()->json(["status"=> $this->successStatus, "message"=>"Group deleted!"], $this->successStatus);
    }

    public function getMyGroup(){
        try {
            $user_id = Auth()->user()->user_id;
        // var_dump($user_id);die;
        $data = User::where('pengguna.user_id', $user_id)
                        ->join('group_users', 'pengguna.user_id' , '=', 'group_users.user_id')
                        ->join("group", 'group.group_id', '=', 'group_users.group_id')
                        ->select('*')->get();

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
        return response()->json(["status">200, "message"=>"List Grup yang dimiliki User", 'data'=>$data],200);
    }
}
