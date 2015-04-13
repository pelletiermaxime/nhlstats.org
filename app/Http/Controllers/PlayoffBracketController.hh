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
					$wins[$game['team1_id']] = $wins[$game['team2_id']] = 0;
					$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
						$game['team1']['id'], $game['team2']['id']
					);
					foreach ($game['regularSeasonGames'] as $noGameScore => $gameScore) {
						if ($gameScore['score1_T'] > $gameScore['score2_T']) {
							$game['regularSeasonGames'][$noGameScore]['winner'] = 'team1';
							$wins[$gameScore['team1']['id']]++;
						} else {
							$game['regularSeasonGames'][$noGameScore]['winner'] = 'team2';
							$wins[$gameScore['team2']['id']]++;
						}
					}
					$game['wins'] = $wins;
				}
				return $gamesEast;
			}
		);
		// dd($gamesEast);

		$gamesWest = \Cache::remember("gamesWest_{$round}", 60,
			() ==> {
				$gamesWest = Models\PlayoffTeams::byConference('WEST', $round);

				foreach ($gamesWest as &$game) {
					$wins[$game['team1_id']] = $wins[$game['team2_id']] = 0;
					$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
						$game['team1']['id'], $game['team2']['id']
					);
					foreach ($game['regularSeasonGames'] as $noGameScore => $gameScore) {
						if ($gameScore['score1_T'] > $gameScore['score2_T']) {
							$game['regularSeasonGames'][$noGameScore]['winner'] = 'team1';
							$wins[$gameScore['team1']['id']]++;
						} else {
							$game['regularSeasonGames'][$noGameScore]['winner'] = 'team2';
							$wins[$gameScore['team2']['id']]++;
						}
					}
					$game['wins'] = $wins;
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
