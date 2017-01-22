<?php

namespace Nhlstats\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Nhlstats\Http\Models;

class GoalerController extends Controller
{
    public function getListFiltered()
    {
        $filter = [];
        /* ----------- TEAMS ----------- */
        $all_teams = ['all' => '---------------'] + Models\Team::getWithShortNameAndCity();

        $team = Input::get('team', 'all');
        //Default to first team if invalid is passed
        if (!isset($all_teams[$team])) {
            $team = 'all';
        }

        /* -------- GOALER STATS -------- */
        $minGames = $this->getMinimumGamesPlayed();
        $filterMinGames = Input::get('show_all', 0);
        if ($filterMinGames === 0) {
            $filter['goaler.games'] = ['>=', $minGames];
        }

        $filter['teams.short_name'] = ['=', $team];
        $filter['players.year'] = ['=', current_year()];
        $goalersStatsYear = Models\GoalersStatsYear::topGoalersByGAA($filter);

        return view('goalers/goalers')
            ->with('goalersStatsYear', $goalersStatsYear)
            ->with('all_teams', $all_teams)
            ->with('filterMinGames', $filterMinGames)
            ->with('team', $team)
        ;
    }

    private function getMinimumGamesPlayed() : int
    {
        // Get the top played games by a goaler
        $topGames = DB::table('goalers_stats_years AS goaler')
            ->where('players.year', '=', current_year())
            ->join('players', 'players.id', '=', 'goaler.player_id')
            ->max('games');


        return $topGames / 4;
    }
}
