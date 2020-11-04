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
        
        $credentials = request(['email','password']);

        if ( !Auth::attempt($credentials))
        return response()->json(['message' => 'Unauthorized'], 401);

        $user = $request->user();
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
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString() 
        ]);
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
        ->where('id','=',$user_id)
        ->select('users.name','users.email','users.phone','users.password')
        ->get();
        return response()->json($currentUser, 200);
    }
    
    public function show(Request $request){
        $showUser = DB::table('users')
        ->where('email', '=', $request->email)
        ->get();
        return response()->json($showUser, 200);
    }

}
