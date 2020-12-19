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
        'aptId',
        'comment_cnt',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }

    protected $casts = [
        'view_cnt' => 'array',
        'heart_cnt' => 'array',
        'like_cnt' => 'array',
        'dislike_cnt' => 'array',
        'comment_cnt' => 'array',
    ];
}
