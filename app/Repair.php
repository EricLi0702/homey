<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'userId',
        'aptId',
        'title', 
        'desc',
        'type',
        'object',
        'upload_file',
        'isDraft',
        'isShowToProprietor',
        'status',
        'isSelectMode'
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function aptId(){
        return $this->belongsTo(Apartment::class, 'aptId');
    }

    public function repairId(){
        return $this->hasMany(ResponseRepair::class,'repairId');
    }
}
