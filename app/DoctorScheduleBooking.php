<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorScheduleBooking extends Model
{
    //
    public $timestamps = false;
    protected $dates = ['end_time','start_time'];
    protected $table = 'doctor_schedule_booking';
    protected $fillable = [
        'appointment_id','status','start_time','end_time'
    ];
}
