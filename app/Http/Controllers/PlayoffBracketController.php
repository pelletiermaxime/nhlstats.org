<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;

class PlayoffBracketController extends Controller
{
	public function index()
	{
		$gamesEast = Models\PlayoffTeams::byConference('EAST', $round = 1);
		$gamesWest = Models\PlayoffTeams::byConference('WEST', $round = 1);

		foreach ($gamesEast as &$game) {
			$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
				$game['team1']['id'], $game['team2']['id']
			);
		}
		foreach ($gamesWest as &$game) {
			$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
				$game['team1']['id'], $game['team2']['id']
			);
		}

		return view('playoffBracket')
			->withGamesEast($gamesEast)
			->withGamesWest($gamesWest)
		;
	}
}
