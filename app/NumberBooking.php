<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberBooking extends Model
{
    //
    protected $table = "number_booking";
    protected $fillable = [
        'appointment_id','status'
    ];
}
