<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Doctor;
use App\UserRole;

class DoctorController extends Controller
{
    //
    public function index(){
        $doctors = Doctor::all();
        return response()->json($doctors, 200);
    }

    public function store(Request $request){
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
            'avatar' => $request->avatar,
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
        return response()->json('Success');
    }

    public function update(Request $request, Doctor $doctor){
        $doctor->update($request->all());
        return response()->json($doctor, 200);
    }

    
}
