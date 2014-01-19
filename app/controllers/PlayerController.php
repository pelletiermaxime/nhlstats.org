<?php

use Nhlstats\Repositories\TeamRepository as Team;

class PlayerController extends BaseController {

	public function __construct(Team $team)
	{
		$this->team = $team;
	}

	public function getListFiltered()
	{
		$data = Input::all();

		/* ----------- COUNTS ----------- */
		$all_counts = [
			'50'  => '50',
			'100' => '100',
			'500' => '500',
			'All' => 'All'
		];
		$data['all_counts'] = $all_counts;

		//Default to 50 if not a possible count
		if (!isset($data['count']) || !isset($all_counts[$data['count']]))
		{
			$data['count'] = head($all_counts);
		}

		/* ----------- TEAMS ----------- */
		$data['all_teams'] = $this->team->getWithShortNameAndCity();

		//Default to first team if invalid is passed
		if (!isset($data['team']) || !isset($data['all_teams'][$data['team']]))
		{
			$data['team'] = key($data['all_teams']);
		}

		/* ---------- POSITION ---------- */
		$positions = [
			'All' => 'All',
			'F'   => 'Forward',
			'L'   => 'Left',
			'C'   => 'Center',
			'R'   => 'Right',
			'D'   => 'Defense'
		];
		$data['all_positions'] = $positions;
		if (!isset($data['position']) || !isset($positions[$data['position']]))
		{
			$data['position'] = head($positions);
		}

		/* -------- PLAYER STATS -------- */
		$data['playersStatsYear'] = Cache::remember('playersStatsYear-'.$data['count'], 60, function() use ($data)
		{
			return DB::table('players_stats_years')
				->join('players'  , 'players.id'  , '=', 'players_stats_years.player_id')
				->join('teams'    , 'teams.id'    , '=', 'players.team_id')
				->join('divisions', 'divisions.id', '=', 'teams.division_id')
				->take($data['count'])
				->select('players_stats_years.*', 'divisions.conference', 'teams.name as team_name',
					'players.*', 'teams.short_name')
				->orderBy('points', 'desc')
				->orderBy('goals' , 'desc')
				->orderBy('games' , 'asc')
				->orderBy('plusminus', 'desc')
				->orderBy('players.name', 'asc')
				->get();
		});

		return View::make('players', $data);
	}
}