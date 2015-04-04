<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;

class PlayoffBracketController extends Controller
{
	public function index()
	{
		$gamesEast = Models\PlayoffTeams::byConference('EAST', $round = 1);
		$gamesWest = Models\PlayoffTeams::byConference('WEST', $round = 1);
		// $scores = GameScores::with(['team1', 'team2'])->get();
		// \Debugbar::info($gamesEast);
		// \Debugbar::info($gamesWest);
		return view('playoffBracket')
			->withGamesEast($gamesEast)
			->withGamesWest($gamesWest)
		;
	}
}
