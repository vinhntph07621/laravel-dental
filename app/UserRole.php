<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //
    public $timestamps = false;
    protected $table = 'user_role';
    protected $fillable = [
        'role_id', 'user_id'
    ];
}
