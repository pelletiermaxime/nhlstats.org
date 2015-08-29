<?php

namespace app\Http\Models;

use Illuminate\Database\Eloquent\Model;

class GoalersStatsYear extends Model
{
    protected $guarded = [];

    public static $rules = [];

    public function player()
    {
        return $this->belongsTo('Player');
    }

    public function topGoalersByGAA($filters)
    {
        $filter_string = implode('', array_flatten($filters));

        return \Cache::remember("goalersStatsYear-{$filter_string}", 60, function () use ($filters) {
            $query = \DB::table('goalers_stats_years AS goaler')
                ->join('players', 'players.id', '=', 'goaler.player_id')
                ->join('teams', 'teams.id', '=', 'players.team_id')
                ->join('divisions', 'divisions.id', '=', 'teams.division_id')
                ->select('goaler.*', 'divisions.conference', 'teams.name as team_name',
                    'players.*', 'teams.short_name', 'teams.city')
                ->orderBy('goals_against_average', 'asc')
                ->where('position', '=', 'G');
                // ->where('games'   , '>', $minGames)

            foreach ($filters as $condition => $value) {
                if ($value[1] != 'all') {
                    $query = $query->where($condition, $value[0], $value[1]);
                }
            }

            return $query->get();
        });
    }
}
