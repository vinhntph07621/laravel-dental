<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service;
use App\Appointment;

class AppointmentHasService extends Model
{
    //
    public $timestamps = false;
    protected $table = 'appointment_has_service';
    protected $fillable = [
        'appointment_id','service_id'
    ];
    
    public function service()
    {
    return $this->hasMany(Service::class);
    }

    public function appointment()
    {
    return $this->hasMany(Appointment::class);
    }
}
