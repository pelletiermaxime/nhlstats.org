<?php

class StandingsController extends BaseController {

	public function index()
	{
		$standings = Standings::orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('w', 'DESC')
			->with('team.division')->remember(60)->get();
		$data['standings'] = $standings;
		return View::make('standings', $data);
	}
}
