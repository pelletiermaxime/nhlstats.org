<?php

class StandingsController extends BaseController
{
	public function index()
	{
		$divisions = Division::all();
		$standings = Standings::all();
		$data['divisions'] = $divisions;
		$data['standings'] = $standings;
		return View::make('standings', $data);
	}
}
