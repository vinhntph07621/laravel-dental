<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Doctor;
use App\UserRole;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    //
    public function index(){
        $doctors = Doctor::all();
        return response()->json($doctors, 200);
    }

    public function store(Request $request){
        $avatar = $request->avatar; //base64 string from frontend

        $images      = app('firebase.firestore')->database()->collection('images')->document('defT5uT7SDu9K5RFtIdl');
        
        $firebase_storage_path = 'images/';
        
        $name          = $images->id();
        
        $localfolder = public_path('firebase-temp-uploads') .'/';
        
        if (!file_exists($localfolder)) {
               mkdir($localfolder, 0777, true);
        }
        
        $parts = explode(";base64,", $image);
        $type_aux = explode("image/", $parts[0]);
        $type = $aux[1];
        $base64 = base64_decode($parts[1]);
        
        $file = $name . '.png';
        
        if (file_put_contents($localfolder . $file, $base64)) {
        
               $uploadedfile = fopen($localfolder . $file, 'r');
        
               app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $name]);
        
               //will remove from local laravel folder
               unlink($localfolder . $file);
        
               echo 'success';
        } else {
               echo 'error';
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
            'avatar' => $avatar,
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
        return $avatar;
    }

    public function update(Request $request, Doctor $doctor){
        $doctor->update($request->all());
        return response()->json($doctor, 200);
    }

    
}
