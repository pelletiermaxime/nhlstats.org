<?php

class Standings extends Eloquent
{
	protected $guarded = array();

	public static $rules = array();

	public function team()
	{
		return $this->belongsTo('Team');
	}

	public function byOverall()
	{
		$query = DB::table('standings')
			->join('teams'    , 'teams.id'    , '=', 'standings.team_id')
			->join('divisions', 'divisions.id', '=', 'teams.division_id')
			->orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('w', 'DESC')
			// ->remember(60)
		;
		$standings = $query->get();
		return $standings;
	}

	public function byDivision()
	{
		$query = DB::table('standings')
			->join('teams'    , 'teams.id'    , '=', 'standings.team_id')
			->join('divisions', 'divisions.id', '=', 'teams.division_id')
			->orderBy('conference', 'ASC')
			->orderBy('division', 'DESC')
			->orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('w', 'DESC')
			// ->remember(60)
		;
		$standings = $query->get();
		// var_dump($standings->toArray());
		return $standings;
	}
}
