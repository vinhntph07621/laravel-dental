<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public $timestamps = false;
    protected $table = "permissions";
    protected $fillable = [
        'name'
    ];
    
}
