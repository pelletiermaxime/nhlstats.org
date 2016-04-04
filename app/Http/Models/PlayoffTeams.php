<?php

namespace Nhlstats\Http\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Nhlstats\Http\Models;

class PlayoffTeams extends Model
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

    /**
     * Return all playoff games for a conference and a round.
     *
     * @param string $conference EAST|WEST
     * @param int    $round
     *
     * @return array Games including teams
     */
    public static function byConference(string $conference, int $round = 1): array
    {
        return Cache::remember("playoffGames_{$conference}_{$round}", 60, function () use ($conference, $round) {
            return Models\PlayoffTeams::whereConference($conference)
                ->where('year', '=', config('nhlstats.currentYear'))
                ->whereRound($round)
                ->with('Team1')
                ->with('Team2')
                ->orderBy('team1_position')
                ->get()
                ->toArray();
        });
    }
}
