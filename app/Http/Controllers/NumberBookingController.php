<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\NumberBooking;
use App\MedicalRecord;
use Carbon\Carbon;

class NumberBookingController extends Controller
{
    //
    public function index(){
        $numberBookings = DB::table('number_booking')
        ->join('appointment','appointment.id','=','number_booking.appointment_id')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('number_booking.*','appointment.patient_name','appointment.phone_number','appointment.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_booking.status','!=',3)
        ->orderBy('id','DESC')
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
                'end_time' => Carbon::now()->toDateString(),
                'status' => 1
            ]);
            return response()->json($medicalRecord, 200);
        }
    }
    


}
