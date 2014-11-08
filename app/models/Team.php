<?php

class Team extends Eloquent
{
	public function division()
	{
		return $this->belongsTo('Division');
	}

	public function byDivision()
	{
		$query = DB::table('teams')
			->join('divisions', 'divisions.id', '=', 'teams.division_id')
			->orderBy('conference', 'ASC')
			->orderBy('division', 'ASC')
			->remember(60)
		;
		$teams = $query->get();
		return $teams;
	}

	public function getWithShortNameAndCity()
	{
		return Team::orderBy('city', 'ASC')->remember(60)->lists('city', 'short_name');
	}
}
