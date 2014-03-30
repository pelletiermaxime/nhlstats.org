<?php

class PlayoffBracketController extends BaseController {

	public function index()
	{
		$teamsEast = $this->getTeamsBracket('East');
		$teamsWest = $this->getTeamsBracket('West');
		$scores = GameScores::with(['team1', 'team2'])->get();
		return View::make('playoffBracket', $data);
	}

	private function getTeamsBracket($conference)
	{
		$standings = Standings::orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('w', 'DESC')
			->with(['team', 'team.division'])
			->where('division.conference', '=', $conference)
		->remember(60)->get();

		return $standings;
	}
}