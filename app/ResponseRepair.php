<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseRepair extends Model
{
    protected $fillable = [
        'managerId',
        'userId',
        'repairId',
        'replyToClient', 
        'replyFromClient',
        'star',
    ];

    public function managerId(){
        return $this->belongsTo(User::class, 'managerId');
    }

    public function userId(){
        return $this->belongsTo(User::class, 'userId');
    }

    public function repairId(){
        return $this->belongsTo(Repair::class, 'repairId');
    }

}
