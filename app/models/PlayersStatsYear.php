<?php

class PlayersStatsYear extends Eloquent
{
	protected $guarded = array();

	public static $rules = array();

	public function player()
	{
		return $this->belongsTo('Player');
	}

	public function topPlayersByPoints($count, $filters = [])
	{
		$query = DB::table('players_stats_years')
				->join('players'  , 'players.id'  , '=', 'players_stats_years.player_id')
				->join('teams'    , 'teams.id'    , '=', 'players.team_id')
				->join('divisions', 'divisions.id', '=', 'teams.division_id')
				->take($count)
				->select('players_stats_years.*', 'divisions.conference', 'teams.name as team_name',
					'players.*', 'teams.short_name', 'teams.city')
				->orderBy('points', 'desc')
				->orderBy('goals' , 'desc')
				->orderBy('games' , 'asc')
				->orderBy('plusminus', 'desc')
				->orderBy('players.name', 'asc');

		$this->buildtopPlayersByPointsFilter($query, $filters);

		return $query->get();
	}

	public function buildtopPlayersByPointsFilter(&$query, $filters)
	{
		Debugbar::log($filters);
		foreach ($filters as $field => $condition)
		{
			list($operator, $value) = $condition;
			if ($field === 'players.position' && $value === 'F') {
				$operator = '!=';
				$value    = 'D';
			}
			if ($value != 'all')
			{
				$query = $query->where($field, $operator, $value);
			}
		}
	}

	public function pointsByPosition($filters = [])
	{
		$query = DB::table('players_stats_years')
				->join('players'  , 'players.id'  , '=', 'players_stats_years.player_id')
				->join('teams'    , 'teams.id'    , '=', 'players.team_id')
				->select(DB::raw('SUM(players_stats_years.points) AS points'), 'players.position')
				// ->orderBy('players.name', 'asc');
				->groupBy('players.position');
		foreach ($filters as $condition => $value)
		{
			$query = $query->where($condition, $value[0], $value[1]);
		}

		return $query->get();
	}
}
