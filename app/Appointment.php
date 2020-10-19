<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    public $timestamps = false;
    protected $table = 'appointment';
    protected $fillable = [
        'doctor_id','patient_name', 'has_people','service_id','date_time','phone_number','email','address','message','status'
    ];
}
