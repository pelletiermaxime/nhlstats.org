<?hh namespace App\Http\Repositories;

use App\Http\Models;

class PlayoffRepository
{
	public function __construct(private Models\Standings $standings)
	{
		$this->wildcard   = $this->standings->byWildcard();
		$this->conference = $this->standings->byConference();
	}

	public function getPlayoffGamesEast()
	{
		$wildcard = $this->wildcard;
		$wildcardEast = $wildcard['wildcard']['EAST'];

		//The strongest team plays against the 2nd wildcard
		if ($wildcard['conference']['ATLANTIC'][0]->pts >
			$wildcard['conference']['METROPOLITAN'][0]->pts)
		{
			$wildcardAtlantic     = $wildcardEast[1];
			$wildcardMetropolitan = $wildcardEast[0];
		}
		else
		{
			$wildcardAtlantic     = $wildcardEast[0];
			$wildcardMetropolitan = $wildcardEast[1];
		}

		$playoffGames['ATLANTIC'][] = [
			'team1' => $wildcard['conference']['ATLANTIC'][0],
			'team2' => $wildcardAtlantic,
		];
		$playoffGames['ATLANTIC'][] = [
			'team1' => $wildcard['conference']['ATLANTIC'][1],
			'team2' => $wildcard['conference']['ATLANTIC'][2],
		];
		$playoffGames['METROPOLITAN'][] = [
			'team1' => $wildcard['conference']['METROPOLITAN'][0],
			'team2' => $wildcardMetropolitan,
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
			'team2' => $team2Central,
		];
		$playoffGames['CENTRAL'][] = [
			'team1' => $wildcard['conference']['CENTRAL'][1],
			'team2' => $wildcard['conference']['CENTRAL'][2],
		];
		$playoffGames['PACIFIC'][] = [
			'team1' => $wildcard['conference']['PACIFIC'][0],
			'team2' => $team2Pacific,
		];
		$playoffGames['PACIFIC'][] = [
			'team1' => $wildcard['conference']['PACIFIC'][1],
			'team2' => $wildcard['conference']['PACIFIC'][2],
		];

		return $playoffGames;
	}
}
