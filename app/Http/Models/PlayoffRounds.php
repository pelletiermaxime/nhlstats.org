<?php

namespace Nhlstats\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlayoffRounds extends Model
{
    protected $casts = [
        'id'    => 'int',
        'round' => 'int',
    ];

    public static function getForYear($year = null)
    {
        if ($year == null) {
            $year = config('nhlstats.currentYear');
        }

        return self::where('year', $year)->get();
    }
}
