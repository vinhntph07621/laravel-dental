<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReExamination;

class MedicalRecord extends Model
{
    //
    protected $table = 'medical_records';
    protected $fillable = [
        'number_booking_id','end_time', 'advice', 'status'
    ];

}
