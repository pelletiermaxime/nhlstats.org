<?php

class PlayersStatsYear extends Eloquent {
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
					'players.*', 'teams.short_name')
				->orderBy('points', 'desc')
				->orderBy('goals' , 'desc')
				->orderBy('games' , 'asc')
				->orderBy('plusminus', 'desc')
				->orderBy('players.name', 'asc');
		foreach ($filters as $condition => $value)
		{
			if ($value[1] != 'all')
			{
				$query = $query->where($condition, $value[0], $value[1]);
			}
		}

		return $query->get();
	}
}
