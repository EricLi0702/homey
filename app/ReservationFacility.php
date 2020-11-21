<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationFacility extends Model
{
    protected $fillable = [
        'userId',
        'facilityId',
        'aptId', 
        'title',
        'purpose',
        'max',
        'periodFrom',
        'periodTo',
        'status'
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function facilityId(){
        return $this->belongsTo(Facility::class, 'facilityId');
    }

    public function aptId(){
        return $this->belongsTo(Apartment::class, 'aptId');
    }

}
