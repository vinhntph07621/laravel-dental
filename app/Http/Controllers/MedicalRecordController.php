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
        ->select('medical_record.*')
        ->get();
        return response()->json($medicalRecords, 200);
    }
}
