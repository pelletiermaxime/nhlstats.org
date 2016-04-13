<?php

namespace Nhlstats\Http\Controllers;

use Cache;
use Carbon\Carbon;
use Input;
use Nhlstats\Http\Models;

class PlayerController extends Controller
{
    private $team;
    private $players_stats_year;
    private $players_stats_day;

    public function __construct(
        Models\Team $team,
        Models\PlayersStatsYear $players_stats_year,
        Models\PlayersStatsDays $players_stats_day
    ) {
        $this->team = $team;
        $this->players_stats_year = $players_stats_year;
        $this->players_stats_day = $players_stats_day;
    }

    public function getListFiltered()
    {
        $filter = [];
        /* ----------- COUNTS ----------- */
        $all_counts = [
            '50'  => '50',
            '100' => '100',
            '500' => '500',
            'all' => 'All',
        ];
        $count = Input::get('count', head($all_counts));
        //Default to 50 if not a possible count
        if (!isset($all_counts[$count])) {
            $count = head($all_counts);
        }

        /* ----------- TEAMS ----------- */
        $all_teams = ['all' => 'All'] + $this->team->getWithShortNameAndCity();

        $team = Input::get('team', 'all');
        //Default to first team if invalid is passed
        if (!isset($all_teams[$team])) {
            $team = 'all';
        }

        /* ---------- POSITION ---------- */
        $all_positions = [
            'all'  => 'All',
            'F'    => 'Forward',
            'LW'   => 'Left',
            'C'    => 'Center',
            'RW'   => 'Right',
            'D'    => 'Defense',
        ];

        $position = Input::get('position', 'all');
        if (!isset($all_positions[$position])) {
            $position = 'all';
        }

        $filtersRaw = [];
        $name = \Input::get('name', 'all');
        if ($name !== '' && $name !== 'all') {
            $filtersRaw = ["MATCH(full_name) AGAINST('*{$name}*' IN BOOLEAN MODE)"];
        }

        /* -------- PLAYER STATS -------- */
        $filter['teams.short_name'] = ['=', $team];
        $filter['players.position'] = ['=', $position];
        $filter['players.year'] = ['=', \Config::get('nhlstats.currentYear')];
        $filter_string = implode('', array_flatten($filter)) . "=$name=$count";
        $playersStatsYear = Cache::remember(
            "playersStatsYear-{$filter_string}",
            60,
            function () use ($count, $filter, $filtersRaw) {
                return $this->players_stats_year->topPlayersByPoints($count, $filter, $filtersRaw);
            }
        );

        $filter['day'] = ['=', Carbon::today()];
        $playersStatsDay = $this->playersStatsDay($count, $filter);

        return view('players.index')
            ->with('playersStatsDay', $playersStatsDay)
            ->with('playersStatsYear', $playersStatsYear)
            ->with('all_teams', $all_teams)
            ->with('team', $team)
            ->with('all_positions', $all_positions)
            ->with('position', $position)
            ->with('all_counts', $all_counts)
            ->with('count', $count)
            ->with('asset_path', asset(''))
        ;
    }

    private function playersStatsDay($count, $filter)
    {
        $filter_string = implode('', array_flatten($filter));

        return Cache::remember(
            "playersStatsDay-{$filter_string}",
            60,
            function () use ($count, $filter) {
                return $this->players_stats_day->topPlayersByPoints($count, $filter);
            }
        );
    }
}
