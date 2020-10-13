<?php

namespace App\Http\Controllers;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    //
    public function list(){
        $listService = Service::all();
        return response()->json($listService);
    }
    
    public function create(Request $request){
        $createService = Service::create($request->all());
        return response()->json($createService, 201);
    }

    public function update(Request $request, Service $service){
        $service->update($request->all());
        return response()->json($service, 200);
    }

    public function delete(Service $service){
        $service->delete();
        return response()->json(null, 204);
    }
    
    
}
