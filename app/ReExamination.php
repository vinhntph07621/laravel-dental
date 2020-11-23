<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Appointment;

class ReExamination extends Model
{
    //
    protected $table = 're_examination';
    protected $fillable = [
        'number_booking_id', 'date_of_examination', 'recommend', 'status'
    ];

}
