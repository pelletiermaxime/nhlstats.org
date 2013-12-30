<?php namespace Nhlstats\Repositories;

use Team;

class TeamRepository {

	public function getWithShortNameAndCity()
	{
		$all_teams = Team::orderBy('city', 'ASC')->get();
		foreach ($all_teams as $team)
		{
			$team_list[$team->short_name] = $team->city;
		}
		return $team_list;
	}

}