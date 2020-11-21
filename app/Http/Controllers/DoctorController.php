<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Doctor;
use App\UserRole;
use Storage;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    //
    public function index(){
        
        $doctors = Doctor::all();
        return response()->json($doctors, 200);
    }

    public function getSpecial(){
        $doctors = DB::table('doctors')
        ->orderBy('id','ASC')
        ->limit(3)
        ->get();
        return response()->json($doctors, 200);
    }

    public function show($id){
        $doctor = Doctor::find($id);
        return response()->json($doctor, 200);
    }

    public function store(Request $request){
        $avatars = $request->avatar;
       
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $destinationPath = 'uploads/';
            $file->move($destinationPath,$file->getClientOriginalName());
            $link_img = 'http://dental-project.herokuapp.com/uploads/'.$file->getClientOriginalName();
            $avatars = $link_img;
        }
        else{
            $avatars ='';
        }

        $users = User::create([
            'name' => $request->first_name." ".$request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $doctors = Doctor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'phone' => $users->phone,
            'email' => $users->email,
            'avatar' => $avatars,
            'gender' => $request->gender,
            'address' => $request->address,
            'short_bio' => $request->short_bio,
            'status' => $request->status,
            'user_id' => $users->id
        ]);

        $user_role = UserRole::create([
            'role_id' => 2,
            'user_id' => $users->id
        ]);
        return response()->json([
            'user' => $users,
            'doctor' => $doctors
        ]);
    }

    public function update(Request $request, Doctor $doctor){
        $doctor->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'avatar' => $request->avatar,
            'gender' => $request->gender,
            'short_bio' => $request->short_bio,
            'status' => $request->status
        ]);
        return response()->json($doctor, 200);
    }

    public function delete($user_id){
        DB::table("user_role")->where("user_id", $user_id)->delete();
        DB::table("doctors")->where("user_id", $user_id)->delete();
        DB::table("users")->where("id", $user_id)->delete();
        return response()->json(null, 204);
    }

    public function blockDoctor(Request $request, Doctor $doctor){
        $doctor->update([
            'status' => $request->status,
        ]);
        
        if($request->status == 2){
            $users = User::where('id',$doctor->user_id)->update(['status' => 2]);
        }else{
            $users = User::where('id',$doctor->user_id)->update(['status' => 1]);
        }

        return response()->json($doctor, 200);
    }
}
