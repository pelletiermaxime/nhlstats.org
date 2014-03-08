<?php

use Carbon\Carbon;

class ScoresController extends BaseController {

	public function index()
	{
		$today = Carbon::now()->format('Y-m-d');
		$scores = GameScores::whereDateGame($today)->with(['team1', 'team2'])->get();
		return View::make('scores')
			->withScores($scores)
		;
	}
}