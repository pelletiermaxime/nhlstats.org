<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlayoffRounds extends Model
{
    protected $casts = [
        'id' => 'int',
        'round' => 'int',
    ];
}
