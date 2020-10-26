<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentOfSuggestion extends Model
{
    protected $fillable = [
        'userId',
        'suId',
        'content', 
    ];

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }
    public function suId(){
        return $this->belongsTo(Suggestion::class, 'suId');
    }
}
