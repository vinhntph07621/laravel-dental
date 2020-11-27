<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\NumberBooking;
use App\MedicalRecord;

class MedicalRecordController extends Controller
{
    //
    public function index(){
        $medicalRecords = NumberBooking::with('re_examination')
        ->join('medical_record','medical_record.number_booking_id','=','number_booking_id')
        ->join('appointment','appointment.id','=','number_booking.appointment_id')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('medical_record.*','appointment.patient_name','appointment.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"), 'appointment.date_time')
        ->get();
        return response()->json($medicalRecords, 200);
    }
}
