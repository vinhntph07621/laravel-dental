<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //
    public function signup(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
            
        $email = $request->email;
        $password = $request->password;


        if (!Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1]))
        return response()->json(['message' => 'Unauthorized'], 401);

        $user = $request->user();

        $roles = DB::table('users')
        ->join('user_role','user_role.user_id','=','users.id')
        ->where('users.id','=',$user->id)
        ->get();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $user = DB::table('users')
        ->where('email', '=', $request->email)
        ->select('users.name','users.email')
        ->get();
        
        if ($request->remember_me)
        $token->expries_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'user' => $request->user(),
            'role_id' => $roles[0]->role_id,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString() 
        ]);
    }

    public function loginAdmin(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
            
        $email = $request->email;
        $password = $request->password;

        if ( Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])){
            $userId = Auth::User()->id;
            $role = DB::table('users')
            ->join('user_role','user_role.user_id','=','users.id')
            ->where('users.id','=',$userId)
            ->get();
            if($role[0]->role_id == 4){
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        $user = $request->user();
        
        $roles = DB::table('users')
        ->join('user_role','user_role.user_id','=','users.id')
        ->where('users.id','=',$user->id)
        ->get();

        if ($user){
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $user = DB::table('users')
            ->where('email', '=', $request->email)
            ->select('users.name','users.email')
            ->get();
            
            if ($request->remember_me)
            $token->expries_at = Carbon::now()->addWeeks(1);
            $token->save();
            return response()->json([
                'user' => $request->user(),
                'role_id' => $roles[0]->role_id,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString() 
            ]);
        }else{
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    

    public function user()
    {
        $users = Auth::user();
        $user_id = $users->id;
        $currentUser = DB::table('users')
        ->join('user_role','user_role.user_id','=','users.id')
        ->where('users.id','=',$user_id)
        ->select('users.name','users.email','users.phone','users.password','user_role.role_id')
        ->get();
        return response()->json($currentUser, 200);
    }

}
