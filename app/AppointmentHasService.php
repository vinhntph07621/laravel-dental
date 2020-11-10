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
    return $this->belongsTo(Service::class);
    }

    public function appointment()
    {
    return $this->belongsTo(Appointment::class);
    }
}
