<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'userId',
        'title',
        'type', 
        'status',
        'period',
        'periodFrom',
        'periodTo',
        'content',
        'isDraft',
        'isDowngrade',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }
}
