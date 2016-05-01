<?php

namespace Nhlstats\Http\Models;

use Illuminate\Database\Eloquent\Model;

class GameScores extends Model
{
    protected $guarded = [];

    public static $rules = [];

    public function team1()
    {
        return $this->belongsTo('Nhlstats\Http\Models\Team');
    }

    public function team2()
    {
        return $this->belongsTo('Nhlstats\Http\Models\Team');
    }

    public static function betweenTeams($team1_id, $team2_id, $dateCondition = '')
    {
        $gamesScores = self::whereRaw(
            '((team1_id = ? AND team2_id = ?) OR (team1_id = ? AND team2_id = ?))',
            [$team1_id, $team2_id, $team2_id, $team1_id]
        )
            ->where('year', '=', config('nhlstats.currentYear'))
            ->orderBy('date_game')
            ->with(['team1', 'team2'])
        ;
        if ($dateCondition !== '') {
            $gamesScores->whereRaw("(date_game $dateCondition)");
        }

        return $gamesScores->get();
    }
}
