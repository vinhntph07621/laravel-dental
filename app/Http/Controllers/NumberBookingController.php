<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\NumberBooking;

class NumberBookingController extends Controller
{
    //
    public function index(){
        $numberBookings = DB::table('number_booking')
        ->join('appointment','appointment.id','=','number_booking.appointment_id')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('number_booking.*','appointment.patient_name','appointment.phone_number','appointment.date_time', DB::raw('concat(doctors.first_name," ",doctors.last_name) as doctor_name'))
        ->get();
        return response()->json($numberBookings, 200);
    }

}
