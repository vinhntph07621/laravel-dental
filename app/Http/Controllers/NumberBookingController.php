<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\NumberBooking;
use App\MedicalRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NumberBookingController extends Controller
{
    //
    public function index(){
        $numberBookings = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('status','=',1)
        ->orderBy('id','DESC')
        ->get();
        return response()->json($numberBookings, 200);
    }

    public function getListPendingAdmin(){
        $numberBookings = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_bookings.status','=',1)
        ->orderBy('id','DESC')
        ->get();
        return response()->json($numberBookings, 200);
    }

    public function getListComplete(){
        $numberBookings = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_bookings.status','=',2)
        ->orderBy('id','DESC')
        ->get();
        return response()->json($numberBookings, 200);
    }

    public function getDetail($id){
       
        
        $numberBookings = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->where('number_bookings.id','=',$id)
        ->select('number_bookings.appointmen_id','appointments.patient_name','appointments.phone_number','appointments.date_time')
        ->get();

        return response()->json($numberBookings, 200);
    }
    
    public function confirm(Request $request, NumberBooking $numberBooking){

        $numberBooking->update([
            'status' => $request->status
        ]);

        $medicalRecords = DB::table('medical_record')
        ->where('number_booking_id','=', $numberBooking->id)
        ->get();

        if($numberBooking->status == 2){
            $medicalRecord = MedicalRecord::create([
                'number_booking_id' => $numberBooking->id,
                'advice' => $request->advice,
                'end_time' => $request->end_time,
                'status' => 1
            ]);
            return response()->json($medicalRecord, 200);
        }
    }
    
    public function getListByDoctor(){
        $users = Auth::user();
        $user_id = $users->id;

        $checkLogin = DB::table('doctors')
        ->join('users','users.id','=','doctors.user_id')
        ->select('doctors.id as doctor_id')
        ->where('users.id','=',$user_id)
        ->get();

        $getListByDoctorId = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_bookings.status','!=',3)
        ->where('doctors.id','=',$checkLogin[0]->doctor_id)
        ->orderBy('id','DESC')
        ->get();

        return response()->json($getListByDoctorId, 200);
    }

    public function getListPending(){
        $users = Auth::user();
        $user_id = $users->id;

        $checkLogin = DB::table('doctors')
        ->join('users','users.id','=','doctors.user_id')
        ->select('doctors.id as doctor_id')
        ->where('users.id','=',$user_id)
        ->get();

        $getListByDoctorId = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_bookings.status','=',1)
        ->where('doctors.id','=',$checkLogin[0]->doctor_id)
        ->orderBy('id','DESC')
        ->get();

        return response()->json($getListByDoctorId, 200);
    }

}
