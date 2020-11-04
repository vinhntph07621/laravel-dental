<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Doctor;
use App\Service;
use App\AppointmentHasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    //
    public function index(){
        $appointments = Appointment::all(); 
        return response()->json($appointments, 200);
    }

    public function show(){
        $users = Auth::user();
        $user_id = $users->id;

        $appointments = DB::table('appointment')
        ->where('user_id','=',$user_id)
        ->get();

        return response()->json($appointments, 200);
    }

    public function store(Request $request){
        
        $doctors = Doctor::all();
        
        $users = Auth::user();
        $user_id = $users->id;
        
        // $services = Service::all();

        // $array = array('appointment_id' => 1, 'service_id' => $request->service_id);

        $appointments = Appointment::create([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'date_time' => $request->date_time,
            'has_people' => $request->has_people,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'message' => $request->message,
            'user_id' => $user_id,
        ]);
        
        $services = $request->service_id;
        

        for ($i = 0; $i < count($services); $i++){
            $array = array(
                'appointment_id' => $appointments->id,
                'service_id' => $services[$i],
            );
            $app_has_service = DB::table('appointment_has_service')->insert($array);
        }   
        return response()->json("Complete", 200);
    }
}
