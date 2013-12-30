<?php

use Nhlstats\Repositories\TeamRepository as Team;

class PlayerController extends BaseController {

	public function __construct(Team $team)
	{
		$this->team = $team;
	}

	public function getListFiltered()
	{
		$data = [
			'name'     => Input::get('name'),
			'team'     => Input::get('team'),
			'position' => Input::get('position'),
			'count'    => Input::get('count'),
		];

		/* ----------- COUNTS ----------- */
		$all_counts = [
			'50'  => '50',
			'100' => '100',
			'500' => '500',
			'All' => 'All'
		];
		$data['all_counts'] = $all_counts;

		//Default to 50 if not a possible count
		if (!isset($all_counts[$data['count']]))
		{
			$data['count'] = '50';
		}

		/* ----------- TEAMS ----------- */
		$data['all_teams'] = $this->team->getWithShortNameAndCity();

		//Default to first team if invalid is passed
		if (!isset($data['all_teams'][$data['team']]))
		{
			$data['team'] = key($data['all_teams']);
		}

		return View::make('players', $data);
	}
}