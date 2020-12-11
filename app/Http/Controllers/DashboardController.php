<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\NumberBooking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index(){
        $doctors = count(Doctor::all());
        $users = count(User::all());
        $numberBookings = count(NumberBooking::all());

        return response()->json([
            'countDoctor' => $doctors,
            'countUser' => $users,
            'countNumberBooking' => $numberBookings,
        ], 200);
    }

    public function getBookingCurrentByDoctor(){
        $users = Auth::user();
        $user_id = $users->id;

        $checkLogin = DB::table('doctors')
        ->join('users','users.id','=','doctors.user_id')
        ->select('doctors.id as doctor_id')
        ->where('users.id','=',$user_id)
        ->get();

        $startDate = CarBon::now()->toDateString();
        $endDate = CarBon::now()->addDay()->toDateString();

        $getListBookingToDay = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_bookings.status','=',1)
        ->where('doctors.id','=',$checkLogin[0]->doctor_id)
        ->where('appointments.date_time','>=',$startDate)
        ->where('appointments.date_time','<',$endDate)
        ->orderBy('number_bookings.id','DESC')
        ->get();
        return response()->json($getListBookingToDay, 200);
    }

    public function getBookingCurrentByDoctor(){
        $users = Auth::user();
        $user_id = $users->id;

        $checkLogin = DB::table('doctors')
        ->join('users','users.id','=','doctors.user_id')
        ->select('doctors.id as doctor_id')
        ->where('users.id','=',$user_id)
        ->get();

        $startDate = CarBon::now()->toDateString();
        $endDate = CarBon::now()->addDay()->toDateString();

        $getListBookingToDay = DB::table('number_bookings')
        ->join('appointments','appointments.id','=','number_bookings.appointment_id')
        ->join('doctors','doctors.id','=','appointments.doctor_id')
        ->select('number_bookings.*','appointments.patient_name','appointments.phone_number','appointments.date_time', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('number_bookings.status','=',2)
        ->where('doctors.id','=',$checkLogin[0]->doctor_id)
        ->where('appointments.date_time','>=',$startDate)
        ->where('appointments.date_time','<',$endDate)
        ->orderBy('number_bookings.id','DESC')
        ->get();
        return response()->json($getListBookingToDay, 200);
    }
}
