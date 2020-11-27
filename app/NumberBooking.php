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

    public function re_examination()
    {
        return $this->hasMany(ReExamination::class,'number_booking_id');
    }
}
