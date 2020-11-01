<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'userId',
        'aptId',
        'title',
        'type', 
        'status',
        'period',
        'periodFrom',
        'periodTo',
        'content',
        'isDraft',
        'isDowngrade',
        'upload_file',
        'view_cnt',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }
}
