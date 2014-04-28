<?php

class PlayoffBracketController extends BaseController {

	public function index()
	{
		$gamesEast = PlayoffTeams::byConference('EAST', $round = 1);
		$gamesWest = PlayoffTeams::byConference('WEST', $round = 1);
		// $scores = GameScores::with(['team1', 'team2'])->get();
		// Debugbar::info($gamesEast);
		// Debugbar::info($gamesWest2);
		return View::make('playoffBracket')
			->withGamesEast($gamesEast)
			->withGamesWest($gamesWest)
		;
	}
}