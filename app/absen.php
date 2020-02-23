<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absen extends Model
{
    protected $table = 'absen';
    protected $fillable = [
        'user_id'
    ];
}
