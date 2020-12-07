<?php

namespace App\Http\Controllers;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //

    public function index(){
        $roles = DB::table('roles')->get();
        return response()->json($roles);
    }

    public function store(Request $request){
        $roles = Role::create($request->all());
        return response()->json($roles, 201);
    }

    public function update(Request $request, Role $role){
        $role->update($request->all());
        return response()->json($role, 200);
    }

    public function destroy(Role $role){
        $role->delete();
        return response()->json(null, 204);
    }
    
}
