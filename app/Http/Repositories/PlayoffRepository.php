<?php namespace Nhlstats\Repositories;

class PlayoffRepository
{
	private $wildcard;
	private $standings;

	public function __construct(\Standings $standings)
	{
		$this->standings = $standings;
		$this->wildcard  = $this->standings->byWildcard();
	}

	public function getPlayoffGamesEast()
	{
		$wildcard = $this->wildcard;
		$wildcardEast = $wildcard['wildcard']['EAST'];

		//The strongest team plays against the 2nd wildcard
		if ($wildcard['conference']['ATLANTIC'][0]->pts >
			$wildcard['conference']['METROPOLITAN'][0]->pts)
		{
			$team2Atlantic     = $wildcardEast[1];
			$team2Metropolitan = $wildcardEast[0];
		}
		else
		{
			$team2Atlantic     = $wildcardEast[0];
			$team2Metropolitan = $wildcardEast[1];
		}

		$playoffGames['ATLANTIC'][] = [
			'team1' => $wildcard['conference']['ATLANTIC'][0],
			'team2' => $team2Atlantic,
		];
		$playoffGames['ATLANTIC'][] = [
			'team1' => $wildcard['conference']['ATLANTIC'][1],
			'team2' => $wildcard['conference']['ATLANTIC'][2],
		];
		$playoffGames['METROPOLITAN'][] = [
			'team1' => $wildcard['conference']['METROPOLITAN'][0],
			'team2' => $team2Metropolitan,
		];
		$playoffGames['METROPOLITAN'][] = [
			'team1' => $wildcard['conference']['METROPOLITAN'][1],
			'team2' => $wildcard['conference']['METROPOLITAN'][2],
		];

		return $playoffGames;
	}

	public function getPlayoffGamesWest()
	{
		$wildcard = $this->wildcard;
		$wildcardWest = $wildcard['wildcard']['WEST'];
		//The strongest team plays against the 2nd wildcard
		if ($wildcard['conference']['CENTRAL'][0]->pts >
			$wildcard['conference']['PACIFIC'][0]->pts)
		{
			$team2Central = $wildcardWest[1];
			$team2Pacific = $wildcardWest[0];
		}
		else
		{
			$team2Central = $wildcardWest[0];
			$team2Pacific = $wildcardWest[1];
		}

		$playoffGames['CENTRAL'][] = [
			'team1' => $wildcard['conference']['CENTRAL'][0],
			'team2' => $wildcard['wildcard']['WEST'][1],
		];
		$playoffGames['CENTRAL'][] = [
			'team1' => $wildcard['conference']['CENTRAL'][1],
			'team2' => $wildcard['conference']['CENTRAL'][2],
		];
		$playoffGames['PACIFIC'][] = [
			'team1' => $wildcard['conference']['PACIFIC'][0],
			'team2' => $wildcard['wildcard']['WEST'][0],
		];
		$playoffGames['PACIFIC'][] = [
			'team1' => $wildcard['conference']['PACIFIC'][1],
			'team2' => $wildcard['conference']['PACIFIC'][2],
		];

		return $playoffGames;
	}
}
