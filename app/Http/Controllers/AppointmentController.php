<?php

namespace App\Http\Controllers;
use App\Appointment;
use App\Doctor;
use App\Service;
use App\Notifications\TestNotification;
use App\User;
use App\DoctorScheduleBooking;
use App\AppointmentHasService;
use App\MedicalRecord;
use App\ReExamination;
use App\NumberBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;

class AppointmentController extends Controller
{
    //
    public function index(){
        $appointments = DB::table('appointments')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('appointments.*','doctors.first_name as first_name_doctor','doctors.last_name as last_name_doctor',DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('appointments.status','=',1)
        ->get(); 
        return response()->json($appointments, 200);
    }

    public function getDetailService($appointmentId){
        $getService = DB::table('appointment_has_service')
        ->join('services','services.id','=','appointment_has_service.service_id')
        ->select('services.id','services.name')
        ->where('appointment_has_service.appointment_id',$appointmentId)
        ->get();
        return response()->json($getService, 200);
    }

    public function show(){
        $users = Auth::user();
        $user_id = $users->id;
        $hasService = DB::table('appointment_has_service')
        ->get();
        
        $appointments = DB::table('appointments')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->leftJoin('number_bookings','number_bookings.appointment_id','=','appointments.id')
        ->select('number_bookings.id as number_booking_id','appointments.id','doctors.first_name as doctor_first_name','doctors.last_name as doctor_last_name','appointments.status','appointments.has_people','appointments.date_time','appointments.patient_name')
        ->orderBy('appointments.id', 'DESC')
        ->where('appointments.user_id',$user_id)
        ->where('appointments.status','=',1)
        ->where('appointments.status','=',2)
        ->get();
        
        return response()->json($appointments);
    }

    public function store(Request $request){
        $doctors = Doctor::all();
        
        $currentTime = Carbon::now('UTC')->addHours(7)->format('Y-m-d H:i:s');

        $users = Auth::user();
        $user_id = $users->id;
        
        // $services = Service::all();

        // $array = array('appointment_id' => 1, 'service_id' => $request->service_id);
        DB::enableQueryLog();
        // $end_date = Carbon::createFromFormat('Y-m-d H:i', $request->date_time)->addHours(2);
        // $date_exist = DB::table('doctor_schedule_booking')
        // ->join('appointment','appointment.id','=','doctor_schedule_booking.appointment_id')
        // ->select('appointment.doctor_id','doctor_schedule_booking.*')
        // ->where('start_time','=',$request->date_time)
        // ->where('doctor_id',$request->doctor_id)
        // ->get();

            $doctorRandom = Doctor::inRandomOrder()->limit(1)->get();

            if(!($request->doctor_id)){
                $appointments = Appointment::create([
                    'patient_name' => $request->patient_name,
                    'doctor_id' => $doctorRandom[0]->id,
                    'date_time' => $request->date_time,
                    'has_people' => $request->has_people,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'address' => $request->address,
                    'message' => $request->message,
                    'user_id' => $user_id,
                ]);
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
            }

            
            
            $services = $request->service_id;
            
            

            for ($i = 0; $i < count($services); $i++){
                $array = array(
                    'appointment_id' => $appointments->id,
                    'service_id' => $services[$i],
                );
                $app_has_service = DB::table('appointment_has_service')->insert($array);
            }   

            
            $data = [
            'name' => $appointments->patient_name,
            'timestamp' => $currentTime
            ];

            $user = User::find(1); // id của user mình đã đăng kí ở trên, user này sẻ nhận được thông báo
            $user->notify(new TestNotification($data));
            return response()->json("Complete", 200);
    }

    public function storeNoUser(Request $request){
        $appointments = Appointment::create([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'date_time' => $request->date_time,
            'has_people' => $request->has_people,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'message' => $request->message,
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
        $appointments = DB::table('appointments')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('doctors.first_name','doctors.last_name','appointments.patient_name','appointments.has_people','appointments.email','appointments.phone_number', 'appointments.date_time','appointments.message','appointments.status','appointments.doctor_id','appointments.id')
        ->where('appointments.id',$id)->get();

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

        $currentTime = Carbon::now('UTC')->addHours(7)->format('d-m-Y H:i:s');

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

        $checkStatus = NumberBooking::where('appointment_id',$appointment->id)->get();

        if($request->status == 2){
            if(count($checkStatus) != 0){
                return null;
            }else{
                $numBookings = NumberBooking::create([
                    'appointment_id' => $appointment->id,
                    'status' => 1
                ]);

                $getService = DB::table('appointment_has_service')
                ->join('services','services.id','=','appointment_has_service.service_id')
                ->select('services.id','services.name')
                ->where('appointment_has_service.appointment_id',$appointment->id)
                ->get();

                $email = $appointment->email;
   
                $mailData = [
                    'title' => 'Lịch đặt của bạn đã được xác nhận',
                    'patient_name' => $appointment->patient_name,
                    'phone' => $appointment->phone_number,
                    'date_time' => Carbon::parse($appointment->date_time)->format('d-m-Y H:i'),
                    'number_booking' => $numBookings->id,
                    'service' => $getService,
                    'current_time' => $currentTime
                ];
          
                Mail::to($email)->send(new EmailDemo($mailData));

            }
        }else if($request->status == 3){
                $numBookings =  NumberBooking::where('appointment_id',$appointment->id)->update(['status' => 3]);
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
        return response()->json($display, 200);

    }

    }

    public function updateStatus(Request $request, Appointment $appointment){
        $appointment->update([
            'status' => $request->status
        ]);
        return response()->json($appointment, 200);
    }

}
