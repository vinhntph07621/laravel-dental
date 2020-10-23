<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    public function isAdmin()
    {
    if($this->role_id === 1)
    { 
        return true; 
    } 
    else 
    { 
        return false; 
    }
    }

    public function getId()
    {
        return $this->id;
    }

    public function hasRole($role){
        return DB::table('users')
        ->join('user_role','user_role.user_id','=','users.id')
        ->join('role','role.id','=','user_role.role_id')
        ->select('users.*','role.name')
        ->where('role.name','=',$role)
        ->get();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
