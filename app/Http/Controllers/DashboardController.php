<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\User;
use App\NumberBooking;

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
}
