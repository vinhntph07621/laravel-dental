<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Permission;

class PermissionController extends Controller
{
    //
    public function index(){
        $pers = DB::table('permissions')->get();
        return response()->json($pers, 200);
    }

    public function store(Request $request){
        $pers = Permission::create($request->all());
        return response()->json($pers, 201); 
    }

    public function update(Request $request, Permission $per){
        $per->update($request->all());
        return response()->json($per, 200);
    }

    public function destroy(Permission $per){
        $per->delete();
        return response()->json(null, 204);
    }
}
