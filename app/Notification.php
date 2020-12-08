<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = 'notifications';
    protected $fillable = [
        'data','notifiable_id', 'read_at'
    ];
}
