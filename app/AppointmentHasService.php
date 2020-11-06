<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentHasService extends Model
{
    //
    public $timestamps = false;
    protected $table = 'appointment_has_service';
    protected $fillable = [
        'appointment_id','service_id'
    ];
    
    public function hasService()
    {
    return $this->belongsTo(Service::class);
    }
}
