<?php

namespace Nhlstats\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Nhlstats\Http\Models;

class TeamController extends Controller
{
    public function index()
    {
        $teamsByDivision = Models\Team::byDivision(config('nhlstats.currentYear'));

        return view('team.index')
            ->withTeamsByDivision($teamsByDivision)
            ;
    }

    public function show($team)
    {
        $count = 'All';
        $filter = [];

        /* -------- PLAYER STATS -------- */
        $position = Input::get('position', 'all');
        $filter['teams.short_name'] = ['=', $team];
        $filter['players.year'] = ['=', config('nhlstats.currentYear')];
        $playersStatsYear = Cache::remember(
            "playersStatsYear-{$count}-{$team}",
            60,
            function () use ($count, $filter) {
                return Models\PlayersStatsYear::topPlayersByPoints($count, $filter);
            }
        );

        $pointsByPosition = Models\PlayersStatsYear::pointsByPosition($filter);

        $goalersStatsYear = Models\GoalersStatsYear::topGoalersByGAA($filter);

        $filter['day'] = ['=', Carbon::today()];
        $playersStatsDay = Models\PlayersStatsDays::topPlayersByPoints($count, $filter);

        return view('team.show')
            ->with('playersStatsDay', $playersStatsDay)
            ->with('playersStatsYear', $playersStatsYear)
            ->with('pointsByPosition', $pointsByPosition)
            ->with('goalersStatsYear', $goalersStatsYear)
            ->with('team', $team)
            ->with('count', $count)
            ->with('position', $position)
            ->with('asset_path', asset(''))
        ;
    }
}
