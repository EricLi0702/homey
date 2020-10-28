<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'userId',
        'aptId',
        'name', 
        'equipment',
        'nb',
        'outline',
        'max',
        'upload_file',
        'isUsing',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function aptId(){
        return $this->belongsTo(Apartment::class, 'aptId');
    }
}
