<?php

namespace App\Http\Controllers;
use App\User;
use App\Permission;
use App\Role;
use App\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function store(Request $request){
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user_role = UserRole::create([
            'role_id' => $request->role_id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);
        return response()->json($user, 200);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required'
            ]);

        $user = User::find(auth()->user()->id);
        
        if(!Hash::check($request->old_password, $user->password)){
            return response()->json([
                'message' => 'Mật khẩu cũ không chính xác'
            ], 400);
        }else{
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
        return response()->json($user, 200);
         }
    }

    public function block(Request $request, $userId){
        $users = User::where('id',$userId)->update([
            'status' => $request->status
        ]);
        return response()->json("Complete", 200);
    }

}
