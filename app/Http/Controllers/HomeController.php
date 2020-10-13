<?php

namespace App\Http\Controllers;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function getService(){
        $listService = Service::all();
        return response()->json($listService);
    }
    
    public function createService(Request $request){
        $createService = Service::create($request->all());
        return response()->json($createService, 201);
    }

    
}
