<?php

class PlayersStatsDays extends Eloquent
{
	protected $guarded = [];
	// public static $rules = array();

	public function topPlayersByPoints($count, $filters = [])
	{
		$query = DB::table('players_stats_days')
				->join('players'  , 'players.id'  , '=', 'players_stats_days.player_id')
				->join('teams'    , 'teams.id'    , '=', 'players.team_id')
				->take($count)
				->select('players_stats_days.*', 'teams.name as team_name',
					'players.*', 'teams.short_name', 'teams.city')
				->orderBy('points', 'desc')
				->orderBy('goals' , 'desc')
				->orderBy('plusminus', 'desc')
				->orderBy('players.name', 'asc');

		$playersStatsYear = new PlayersStatsYear;
		$playersStatsYear->buildtopPlayersByPointsFilter($query, $filters);

		return $query->get();
	}

	public function player()
	{
		return $this->belongsTo('Player');
	}
}
