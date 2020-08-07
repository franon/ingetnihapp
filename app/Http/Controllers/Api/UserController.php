<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Group;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Requests\UpdateUser;
use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public $successStatus = 200;

    protected $NotifikasiController;
    public function __construct(NotifikasiController $NotifikasiController)
    {
        $this->NotifikasiController = $NotifikasiController;
        
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);
        try {
        if(!Auth()->attempt($credentials)) return response()->json(['status'=>401,'message'=>'email/password salah'], 401);

        $user = Auth()->user();
        if($user->is_active==1) return response()->json(["status"=>401,'message'=>'Akun ini sedang login'], 401);
        
        // $user->is_active=1;
        $user->device_token= $request->device_token;
        $user->save();
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        
        } catch (\Exception $e) {
            throw new Exception(500, $e->getMessage());
        }
        return response()->json(['status'=>$this->successStatus,'message'=>'Logged in','data'=>$user, 'token'=>$accessToken], $this->successStatus);
    }

    public function register(Request $request){

        try {
                $credentials = $request->validate([
                    'name'=>'required',
                    'email'=>'required',
                    'role_id'=>'required',
                    'phone_number'=>'nullable',
                    'gender'=>'nullable',
                    'jabatan' => 'nullable',
            ]);

            $credentials['password'] = bcrypt($request->password);
            $credentials['user_id'] = self::generateUserId($request->role_id);
            $credentials['is_active'] = 0;

            $user = User::create($credentials);
            $accessToken = $user->createToken('authToken')->accessToken;
        } catch (\Throwable $th) {
            return response()->json(['status'=> 404, 'message'=>'Check the rules!'],404);    
        }
            

        return response()->json(['status'=> $this->successStatus, 'message'=>'registered!', 'data'=>$user, 'token'=>$accessToken], $this->successStatus);
    }

    public function logout(){
        try {
            if(Auth()->check()){
                $user = Auth()->user();
                $user->is_active=0;
                $user->save();
                $user->token()->revoke();
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return response()->json(["message"=>"Account logged out!"],$this->successStatus);
    }

    public function editData(UpdateUser $request,$user_id){
        // dd($request->user_id);
        $dataUser = $request->validated();
        
        $previousDataUser = User::where('user_id', $user_id)->first();
        $user = User::where('user_id', $user_id)->first();
        // var_dump($dataUser);
        // $user->user_id = auth()->user()->user_id;
        $user->name = $dataUser['name'];
        $user->email = $dataUser['email'];
        $user->role_id = $dataUser['role_id'];
        $user->phone_number = $dataUser['phone_number'];
        $user->gender = $dataUser['gender'];
        $user->jabatan = $dataUser['jabatan'];
        $user->save();

        return response()->json(['status'=>$this->successStatus, 'message' => 'Update Success!','previous_data'=>$previousDataUser, 'data' => $user]);
    }

    public function generateUserId($role){
        // var_dump($role);die;
        switch ($role) {
            case '1':
                return 'adm_'.sha1(time());
            case '2':
                return 'd_'.sha1(time());
            case '3':
                return 'm_'.sha1(time());
        }
    }

    public function details(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function addUserToGroup(Request $request){
        try {
        $team = \App\Group::where('group_id', $request->group_id)->first(); //btuh validasi jika tidak ada group
        $user = User::where('user_id', $request->user_id)->first();
        $team->groupUsers()->sync($user->user_id,false);
        $data = [
            "group_id"=>$request->group_id,
            "user_id"=>$request->user_id,
        ];
        $this->NotifikasiController->NotifyUser("group", $data,"Added to Grup!");
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        
        return response()->json(["status"=>200, "message"=> "OK", 'data'=>$user],$this->successStatus);
        
    }

    public function getAllUser(){
        $dataUser = User::all();
        return response()->json(["status"=> $this->successStatus, "message"=>"Berhasil mengambil semua data user", "data"=>$dataUser], $this->successStatus);
    }

    public function getUser($user_id){
        $dataUser = User::where('user_id',$user_id)->first();
        return response()->json(["status"=> $this->successStatus, "message"=>"Berhasil mengambil data user", "data"=>$dataUser], $this->successStatus);
    }

    public function getAllUserP(){
        $dataUser = User::paginate(2);
        // $links = $dataUser->links();
        // $dataUser['links'] = $links;
        return response()->json(["status"=> $this->successStatus, "message"=>"Berhasil mengambil semua data user", "data"=>$dataUser], $this->successStatus);
    }

    public function getAllUserDT(){
        $users = User::all();
        return Datatables::of($users)
                            ->addColumn("action", function($usr){
                                return '
                                <td> 
                                <a href="/admin/user/user/edit/'.$usr->user_id.'" class="btn btn-outline-info mb-3"><i class="fa fa-pencil" aria-hidden="true">edit</i></a> |
                                <a href="/admin/user/user/delete/'.$usr->user_id.'" class="btn btn-outline-info mb-3"><i class="fa-ban"></i> remove</a>
                                </td>';
                            })
                            ->make(true);
    }

    public function removeUser($user_id){
        $data = User::where('user_id',$user_id);
        $data->delete();
        return response()->json(["status"=> $this->successStatus, "message"=>"account deleted!"], $this->successStatus);
    }

    public function searchUser(Request $request){
        $user = $request->get("search");
        if(empty($user)){
            $user = User::where('role_id','=','2')->get();
        }else{
            $user = User::where([['name','like', '%'.$user.'%'],['role_id','=','2']])->get();
        }
        return response()->json(["status"=> $this->successStatus, "message"=>"Berhasil mengambil semua data Dosen", "data"=>$user], $this->successStatus);
    }

    public function addUserToJabatan(Request $request){
        // $gelar = Auth()->user()->role_id;
        // if($gelar != 1) return response()->json(["status"=>401, "message"=> "Access Denied! Need Admin Access!"],401);
        $jabatan = \App\Jabatan::where('jabatan_id', $request->jabatan_id)->first(); //btuh validasi jika tidak ada group
        $user = User::where('user_id', $request->user_id)->first();
        $result = $user->jabatanUsers()->sync($jabatan->jabatan_id);
        if(empty($result["attached"][0])) return response()->json(["status"=>202, "message"=> "User Already has position"],202);

        return response()->json(["status"=>200, "message"=> "OK", 'data'=>$user],$this->successStatus);
        
    }

    public function showUserGroup(Request $request){
        $User = User::where("user_id",$request->user_id)->first();
    }
}
