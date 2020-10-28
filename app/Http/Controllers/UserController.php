<?php

namespace App\Http\Controllers;
use App\User;
use App\Permission;
use App\Role;
use App\UserRole;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
       $users = DB::table('user_role')
       ->join('users','users.id','=','user_role.user_id')
       ->join('role','role.id','=','user_role.role_id')
       ->select('users.*','role.name as role_name')
       ->get();
        return response()->json($users);
    }   

    public function signup(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user_role = UserRole::create([
            'role_id' => 4,
            'user_id' => $user->id
        ]);
        $user->save();
        $user_role->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    

}
