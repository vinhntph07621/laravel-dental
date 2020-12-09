<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\NumberBooking;
use Illuminate\Support\Facades\Auth;
use App\MedicalRecord;

class MedicalRecordController extends Controller
{
    //
    public function index(){
        $medicalRecords = DB::table('medical_records')
        ->join('number_bookings','number_bookings.id','=','medical_records.number_booking_id')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('medical_records.*','appointments.patient_name', 'appointments.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"), 'appointments.date_time')
        ->get();
        return response()->json($medicalRecords, 200);
    }

    public function getListByUser(){
        $users = Auth::user();
        $user_id = $users->id;

        $medicalRecords = DB::table('medical_records')
        ->join('number_bookings','number_bookings.id','=','medical_records.number_booking_id')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('medical_records.*','appointments.patient_name', 'appointments.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"), 'appointments.date_time')
        ->where('appointments.user_id','=',$user_id)
        ->get();

        return response()->json($medicalRecords, 200);
    }

    public function getListByDoctor(){
        $users = Auth::user();
        $user_id = $users->id;

        $checkLogin = DB::table('doctors')
        ->join('users','users.id','=','doctors.user_id')
        ->select('doctors.id as doctor_id')
        ->where('users.id','=',$user_id)
        ->get();

        $medicalRecords = DB::table('medical_records')
        ->join('number_bookings','number_bookings.id','=','medical_records.number_booking_id')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('medical_records.*','appointments.patient_name', 'number_bookings.appointment_id', 'appointments.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"), 'appointments.date_time')
        ->where('doctors.id','=',$checkLogin[0]->doctor_id)
        ->orderBy('id','DESC')
        ->get();
        return response()->json($medicalRecords, 200);        
    }

    public function getDetail($id){
        $medicalRecords = DB::table('medical_records')
        ->join('number_bookings','number_bookings.id','=','medical_records.number_booking_id')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->where('medical_records.id','=',$id)
        ->select('medical_records.*','appointments.patient_name', 'appointments.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"), 'appointments.date_time','number_bookings.appointment_id')
        ->get();
        return response()->json($medicalRecords, 200);
    }
}
