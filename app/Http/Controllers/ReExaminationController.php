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
        $checkStatus = DB::table('re_examination')
        ->where('number_booking_id', '=', $request->number_booking_id)
        ->where('status','=', 2)
        ->get(); 

        if(count($checkStatus) > 0){
            $reExamination = ReExamination::create($request->all());
            return response()->json($reExamination, 201);
        }else{
            return "Vui lòng hoàn thành lịch tái khám trước";
        }
    }

    public function update(Request $request, ReExamination $reExamination){
        $reExamination->update($request->all());
        return response()->json($reExamination, 200);
    }

    public function destroy(ReExamination $reExamination){
        $reExamination->delete();
        return response()->json(null, 204);
    }
}
