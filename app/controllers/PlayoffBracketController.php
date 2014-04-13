<?php


class PlayoffBracketController extends BaseController {

	public function index()
	{
		$gamesEast = Cache::remember("gamesEast", 60, function() {
			return PlayoffTeams::whereConference('EAST')
				->with('Team1')
				->with('Team2')
				->get()
				->toArray();
		});
		$gamesWest = Cache::remember("gamesWest", 60, function() {
			return PlayoffTeams::whereConference('WEST')
				->with('Team1')
				->with('Team2')
				->get()
				->toArray();
		});
		// $scores = GameScores::with(['team1', 'team2'])->get();
		// Debugbar::info($gamesEast);
		// Debugbar::info($gamesWest2);
		return View::make('playoffBracket')
			->withGamesEast($gamesEast)
			->withGamesWest($gamesWest)
		;
	}
}