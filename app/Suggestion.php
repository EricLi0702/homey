<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'userId',
        'title',
        'content', 
        'upload_file',
        'view_cnt',
        'heart_cnt',
        'like_cnt',
        'dislike_cnt',
        'isDraft',
        'isRemoved',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }

    
}
