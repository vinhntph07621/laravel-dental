<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReExamination;
use App\Appointment;

class ReExaminationController extends Controller
{
    //
    public function store(Request $request){
        $reExamination = ReExamination::create($request->all());
        return response()->json($reExamination, 200);
    }

}
