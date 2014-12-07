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
		$query = DB::table('teams')
			->select('city', 'short_name', 'name')
			->orderBy('city', 'ASC')
		;
		$teams = $query->get();
		foreach ($teams as $team) {
			$listTeam[$team->short_name] = "{$team->city} {$team->name}";
		}
		return $listTeam;
	}
}
