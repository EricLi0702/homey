<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentOfCommunity extends Model
{
    protected $fillable = [
        'userId',
        'coId',
        'content',
        'seq',
        'lvl', 
        'isRemoved',
        'parentId',
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }
    public function coId(){
        return $this->belongsTo(Community::class, 'coId');
    }
}
