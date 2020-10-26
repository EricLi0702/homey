<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdress extends Model
{
    //
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'userId');
    }

    public function apt(){
        return $this->belongsTo(Apartment::class,'aptId');
    }

    public function building(){
        return $this->belongsTo(Building::class,'buildingId');
    }
}
