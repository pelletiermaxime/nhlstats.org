<?php namespace Nhlstats\Repositories;

use Team;

class TeamRepository
{
	public function getWithShortNameAndCity()
	{
		return Team::orderBy('city', 'ASC')->remember(60)->lists('city', 'short_name');
	}
}
