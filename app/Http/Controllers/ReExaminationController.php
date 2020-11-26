<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReExamination;
use Illuminate\Support\Facades\DB;
use App\Appointment;
use App\NumberBooking;

class ReExaminationController extends Controller
{
    //
    public function index(){
        $reExamination = ReExamination::all();
        return response()->json($reExamination, 200);
    }

    public function store(Request $request){
        $checkReExam = ReExamination::where('number_booking_id', $request->number_booking_id)->get();
        if(count($checkReExam) > 0){
        }else{
            $reExamination = ReExamination::create($request->all());
            $numberBooking = NumberBooking::where('id',$reExamination->number_booking_id)->update(['status' => 3]);
            return response()->json($reExamination, 201);
        }
    }


}
