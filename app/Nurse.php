<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    //
    public $timestamps = false;
    protected $table = 'nurses';
    protected $fillable = [
        'first_name','last_name', 'birthday','phone','address','gender','address','email','avatar','short_bio','status','user_id'
    ];
}
