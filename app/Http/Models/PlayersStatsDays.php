<?php

namespace Nhlstats\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Nhlstats\Http\Models;

class PlayersStatsDays extends Model
{
    protected $guarded = [];

    public static function topPlayersByPoints($count, $filters = [])
    {
        $query = DB::table('players_stats_days')
                ->join('players', 'players.id', '=', 'players_stats_days.player_id')
                ->join('teams', 'teams.id', '=', 'players.team_id')
                ->take($count)
                ->select('players_stats_days.*', 'teams.name as team_name',
                    'players.*', 'teams.short_name', 'teams.city')
                ->orderBy('points', 'desc')
                ->orderBy('goals', 'desc')
                ->orderBy('plusminus', 'desc')
                ->orderBy('players.name', 'asc');

        $playersStatsYear = new Models\PlayersStatsYear();
        $playersStatsYear->buildtopPlayersByPointsFilter($query, $filters);

        return $query->get();
    }

    public function player()
    {
        return $this->belongsTo('Nhlstats\Http\Models\Player');
    }
}
