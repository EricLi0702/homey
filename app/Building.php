<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    //
    protected $guarded = [];

    public function apt(){
        return $this->belongsTo(Apartment::class,'aptId');
    }
}
