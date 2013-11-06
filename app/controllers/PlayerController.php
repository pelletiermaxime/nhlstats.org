<?php

class PlayerController extends BaseController
{
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
		$all_teams = Team::orderBy('city', 'ASC')->get();
		foreach ($all_teams as $team)
		{
			$team_list[$team->short_name] = $team->city;
		}
		$data['all_teams'] = $team_list;

		//Default to first team if invalid is passed
		if (!isset($team_list[$data['team']]))
		{
			$data['team'] = key($team_list);
		}

		return View::make('players',  $data);
	}
}