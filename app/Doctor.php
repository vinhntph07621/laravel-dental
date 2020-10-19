<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    //
    public $timestamps = false;
    protected $table = 'doctors';
    protected $fillable = [
        'first_name','last_name', 'birthday','phone','address','gender','address','email','avatar','short_bio','status','user_id'
    ];
    public function getFullNameAttribute()
    {
       return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
}
