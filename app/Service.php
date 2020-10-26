<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{       
        public $timestamps = false;
        protected $table = 'service';
        protected $fillable = [
            'name', 'status'
        ];
        
}
