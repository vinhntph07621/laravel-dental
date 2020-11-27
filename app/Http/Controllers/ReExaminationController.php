<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReExamination;
use Illuminate\Support\Facades\DB;
use App\Appointment;
use App\NumberBooking;
use Illuminate\Support\Facades\Auth;

class ReExaminationController extends Controller
{
    //
    public function index(){
        $reExamination = DB::table('re_examination')
        ->join('number_booking','number_booking.id','=','re_examination.number_booking_id')
        ->join('appointment','appointment.id','=','number_booking.appointment_id')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('re_examination.*','appointment.patient_name', 'appointment.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->get();
        return response()->json($reExamination, 200);
    }

    public function show($reExaminationId){
        $reExamination = ReExamination::where('id',$reExaminationId)->get();
        return response()->json($reExamination, 200);
    }

    public function getByUser(){
        $users = Auth::user();
        $user_id = $users->id;

        $reExaminationByUser = DB::table('re_examination')
        ->join('number_booking','number_booking.id','re_examination.number_booking_id')
        ->join('appointment','appointment.id','=','number_booking.appointment_id')
        ->select('re_examination.*')
        ->where('appointment.user_id','=',$user_id)
        ->get();
        
        return response()->json($reExaminationByUser, 200);
    }

    public function getDetail($id){
        $users = Auth::user();
        $user_id = $users->id;
        DB::enableQueryLog();

        $reExaminationByUser = DB::table('re_examination')
        ->join('number_booking','number_booking.id','=','re_examination.number_booking_id')
        ->join('appointment','appointment.id','=','number_booking.appointment_id')
        ->join('doctors','doctors.id','=','appointment.doctor_id')
        ->select('re_examination.*','appointment.patient_name', 'appointment.phone_number', DB::raw("concat(doctors.first_name,' ',doctors.last_name) as doctor_name"))
        ->where('re_examination.id','=',$id)
        ->where('appointment.user_id','=',$user_id)
        ->get();
        return response()->json($reExaminationByUser, 200);
    }

    public function store(Request $request){
        $checkStatus = DB::table('re_examination')
        ->where('number_booking_id', '=', $request->number_booking_id)
        ->where('status','=', 1)
        ->orderBy('id', 'ASC')
        ->limit(1)
        ->get(); 

        if(count($checkStatus) > 0){
            return response()->json(["message" => "Vui lòng hoàn thành lịch tái khám trước"], 400);
        }else{
            $reExamination = ReExamination::create($request->all());
            return response()->json($reExamination, 201);
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
