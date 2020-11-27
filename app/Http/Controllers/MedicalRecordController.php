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
        $medicalRecords = MedicalRecord::all();
        return response()->json($medicalRecords, 200);
    }
}
