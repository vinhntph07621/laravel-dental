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
        $hashed = Hash::make('password', [
            'rounds' => 10,
        ]);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $hashed
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

    public function update(Request $request, User $user){
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);
        return response()->json($user, 200);
    }

    public function delete(Request $request, User $user){
        
    }
    

}
