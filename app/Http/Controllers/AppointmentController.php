<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Doctor;
use App\Service;
use App\DoctorScheduleBooking;
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
        ->where('appointment.status','!=','3')
        ->get();
        
        return response()->json($appointments);
    }

    public function store(Request $request){
        
        $doctors = Doctor::all();
        
        $users = Auth::user();
        $user_id = $users->id;
        
        // $services = Service::all();

        // $array = array('appointment_id' => 1, 'service_id' => $request->service_id);
        DB::enableQueryLog();
        $end_date = Carbon::createFromFormat('Y-m-d H:i', $request->date_time)->addHours(2);
        $date_exist = DB::table('doctor_schedule_booking')
        ->join('appointment','appointment.id','=','doctor_schedule_booking.appointment_id')
        ->select('appointment.doctor_id','doctor_schedule_booking.*')
        ->where('start_time','=',$request->date_time)
        ->where('doctor_id',$request->doctor_id)
        ->get();

        if(count($date_exist) > 1){
            return response()->json(["message" => "Exist"]);
        }else{
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

    public function getDetail($id){
        DB::enableQueryLog();
        $appointments = DB::table('appointment')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('doctors.first_name','doctors.last_name','appointment.patient_name','appointment.has_people','appointment.email','appointment.phone_number', 'appointment.date_time','appointment.message','appointment.status','appointment.doctor_id','appointment.id')
        ->where('appointment.id',$id)->get();

        // dd(DB::getQueryLog());
        return response()->json($appointments, 200);
    }

    public function updateByUser(Request $request, Appointment $appointment){
        $appointment->update([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'date_time' => $request->date_time,
            'has_people' => $request->has_people,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'message' => $request->message
        ]);

        $removeUpdate = DB::table('appointment_has_service')
        ->where('appointment_id', $appointment->id)
        ->delete();

        $services = $request->service_id;
      
        for ($i = 0; $i < count($services); $i++){
            $array = array(
                'appointment_id' => $appointment->id,
                'service_id' => $services[$i],
            );
        $app_has_service = DB::table('appointment_has_service')->insert($array);
        }
        return response()->json('Update complete', 200);
    }

    public function edit(Request $request, Appointment $appointment){
        DB::enableQueryLog();
        $appointment->update([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'date_time' => $request->date_time,
            'has_people' => $request->has_people,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'message' => $request->message,
            'status' => $request->status
        ]);

        if($request->status == 2){
            $date = Carbon::createFromFormat('Y-m-d H:i', $appointment->date_time)->addHours(2);
            $schedule = DoctorScheduleBooking::create([
                'status' => 1,
                'start_time' => $appointment->date_time,
                'end_time' => $date,
                'appointment_id' => $appointment->id
            ]);
        }

        $removeUpdate = DB::table('appointment_has_service')
        ->where('appointment_id', $appointment->id)
        ->delete();

        $services = $request->service_id;
        for ($i = 0; $i < count($services); $i++){
            $array = array(
                'appointment_id' => $appointment->id,
                'service_id' => $services[$i],
            );
        $app_has_service = DB::table('appointment_has_service')->insert($array);
        $display = Appointment::with('service')->where('id',$appointment->id)->get();
        // dd($app_has_service);
    }
        return response()->json($display, 200);
    }

    public function updateStatus(Request $request, Appointment $appointment){
        $appointment->update([
            'status' => $request->status
        ]);
        return response()->json($appointment, 200);
    }


}
