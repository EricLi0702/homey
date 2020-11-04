<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
        'userId',
        'aptId',
        'title',
        'content',
        'upload_file', 
        'status',
        'period',
        'periodFrom',
        'periodTo',
        'comment_cnt',
        'view_cnt',
        'isRemoved',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }
}
