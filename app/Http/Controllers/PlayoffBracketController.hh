<?hh namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;

class PlayoffBracketController extends Controller
{
	public function index()
	{
		$round = 1;
		$gamesEast = $game = $gamesWest = [];
		$gamesEast = \Cache::remember("gamesEast_{$round}", 60,
			() ==> {
				$gamesEast = Models\PlayoffTeams::byConference('EAST', $round);
				foreach ($gamesEast as &$game) {
					$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
						$game['team1']['id'], $game['team2']['id']
					);
				}
				return $gamesEast;
			}
		);

		$gamesWest = \Cache::remember("gamesWest_{$round}", 60,
			() ==> {
				$gamesWest = Models\PlayoffTeams::byConference('WEST', $round);

				foreach ($gamesWest as &$game) {
					$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
						$game['team1']['id'], $game['team2']['id']
					);
				}
				return $gamesWest;
			}
		);

		return view('playoffBracket')
			->withGamesEast($gamesEast)
			->withGamesWest($gamesWest)
		;
	}
}
