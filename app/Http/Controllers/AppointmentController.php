<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Doctor;
use App\Service;
use App\AppointmentHasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    //
    public function index(){
        $appointments = DB::table('appointment')
        ->get(); 
        return response()->json($appointments, 200);
    }

    public function getDetailService($appointmentId){
        $getService = DB::table('appointment_has_service')
        ->join('service','service.id','=','appointment_has_service.service_id')
        ->select('service.id','service.name')
        ->where('appointment_has_service.appointment_id',$appointmentId)
        ->get();
        return response()->json($getService, 200);
    }

    public function show(){
        $users = Auth::user();
        $user_id = $users->id;

        $hasService = DB::table('appointment_has_service')
        ->get();
        
        $appointments = DB::table('appointment')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('appointment.id','doctors.first_name as doctor_first_name','doctors.last_name as doctor_last_name','appointment.status','appointment.has_people','appointment.date_time','appointment.patient_name')
        ->orderBy('appointment.id', 'DESC')
        ->where('appointment.user_id',$user_id)
        ->get();
        
        return response()->json($appointments);
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

    public function getDetail($id){
        DB::enableQueryLog();
        $appointments = DB::table('appointment_has_service')
        ->join('appointment','appointment_has_service.appointment_id','=','appointment.id')
        ->join('service','appointment_has_service.service_id','=','service.id')
        ->where('appointment.id',$id)->get();

        // dd(DB::getQueryLog());
        return response()->json($appointments, 200);
    }

    public function update(Request $request, Appointment $appointment){
        $appointment->update([
            'status' => $request->status
        ]);
        return response()->json($appointment, 200);
    }
}
