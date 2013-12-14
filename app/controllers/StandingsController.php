<?php

class StandingsController extends BaseController
{
	public function index()
	{
		$divisions = Division::remember(60)->get();
		$standings = Standings::orderBy('PTS', 'DESC')->with('team')->get();
		$data['divisions'] = $divisions;
		$data['standings'] = $standings;
		return View::make('standings', $data);
	}
}
