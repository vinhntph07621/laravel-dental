<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Doctor;
use App\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    //
    public function index(){
        $doctors = Doctor::all();
        return response()->json($doctors, 200);
    }

    public function store(Request $request){
        $doctors = Doctor::all();
        
        $services = Service::all();

        $appointments = Appointment::create([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'date_time' => $request->date_time,
            'has_people' => $request->has_people,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'message' => $request->message,
            'status' => $request->status
        ]);
    }
}
