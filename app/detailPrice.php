<?php

namespace App;

use App\PriceList;
use Illuminate\Database\Eloquent\Model;

class detailPrice extends Model
{
    public $timestamps = false ;
    protected $table ="detail_price_list";
    protected $fillable = [
         'price_list_id','unit','price','status','name'
    ];
}
