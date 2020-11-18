<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairType extends Model
{
    protected $fillable = [
        'userId',
        'aptId',
        'lang',
        'repair_type',
    ];
}
