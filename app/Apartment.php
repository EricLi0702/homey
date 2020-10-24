<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    //
    protected $fillable = ['aptName','address','repreName','phoneNumber','email'];

    public function building(){
        return $this->hasMany(Building::class,'buildingId');
    }
    public function superMng(){
        return $this->belongsTo(User::class,'aptId');
    }
}
