<?php

use Nhlstats\Repositories\TeamRepository as Team;

class GoalerController extends BaseController {

	public function __construct(Team $team)
	{
		$this->team = $team;
	}

	public function getListFiltered()
	{
		$data = Input::all();

		/* ----------- TEAMS ----------- */
		$data['all_teams'] = $this->team->getWithShortNameAndCity();

		//Default to first team if invalid is passed
		if (!isset($data['team']) || !isset($data['all_teams'][$data['team']]))
		{
			$data['team'] = key($data['all_teams']);
		}

		/* -------- GOALER STATS -------- */
		// $topGames = DB::table('goalers_stats_years')->max('games');
		// $minGames = $topGames / 4;

		$data['goalersStatsYear'] = Cache::remember('goalersStatsYear', 60, function() use ($data)
		{
			return DB::table('goalers_stats_years AS goaler')
				->join('players'  , 'players.id'  , '=', 'goaler.player_id')
				->join('teams'    , 'teams.id'    , '=', 'players.team_id')
				->join('divisions', 'divisions.id', '=', 'teams.division_id')
				->select('goaler.*', 'divisions.conference', 'teams.name as team_name',
					'players.*', 'teams.short_name')
				->orderBy('goals_against_average', 'asc')
				->where('position', '=' , 'G')
				// ->where('games'   , '>', $minGames)
				->get();
		});

		return View::make('goalers', $data);
	}
}