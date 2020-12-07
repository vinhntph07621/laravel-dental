<?php

namespace App;

use App\Doctor;
use App\AppointmentHasService;
use App\ReExamination;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    public $timestamps = false;
    protected $table = 'appointments';
    protected $fillable = [
        'user_id','doctor_id','patient_name', 'has_people','service_id','date_time','phone_number','email','address','message','status'
    ];
    
    public function service()
    {
        return $this->hasMany(AppointmentHasService::class);
    }

    public function getId()
    {
        return $this->id;
    }

    public function re_examination()
    {
        return $this->hasMany(ReExamination::class);
    }
    
}
