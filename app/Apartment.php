<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    //
    protected $fillable = ['aptName','address','repreName','phoneNumber','email', 'code', 'isAutoReserve'];

    public function building(){
        return $this->hasMany(Building::class,'aptId');
    }
    public function superMng(){
        return $this->belongsTo(User::class,'aptId');
    }
}
