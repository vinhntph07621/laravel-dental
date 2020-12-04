<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receptionist extends Model
{
    //
    public $timestamps = false;
    protected $table = 'receptionist';
    protected $fillable = [
        'first_name','last_name', 'birthday','phone','address','gender','address','email','avatar','short_bio','status','user_id'
    ];
}
