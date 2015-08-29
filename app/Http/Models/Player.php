<?php

namespace app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $guarded = [];

    public static $rules = [];

    public function team()
    {
        return $this->belongsTo('App\Http\Models\Team');
    }
}
