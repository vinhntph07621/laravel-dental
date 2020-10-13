<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    //
    public $timestamps = false;
        protected $table = 'price_list';
        protected $fillable = [
            'name', 'status'
        ];
}
