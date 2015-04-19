<?hh namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;
use Carbon\Carbon;

class PlayoffBracketController extends Controller
{
	public function index()
	{
		$round = 1;

		$gamesEast = $this->getPlayoffBracket('EAST', $round);
		$gamesWest = $this->getPlayoffBracket('WEST', $round);

		return view('playoffBracket')
			->withGamesEast($gamesEast)
			->withGamesWest($gamesWest)
		;
	}

	private function getPlayoffBracket($conference, $round)
	{
		$games = [];

		$nextRound = $round + 1;
		$dateToday        = Carbon::today();
		$dateCurrentRound = \Config::get("nhlstats.round{$round}Start");
		$dateNextRound    = \Config::get("nhlstats.round{$nextRound}Start");

		// Don't show scores for today
		if ($dateNextRound > $dateToday->format('Y-m-d')) {
			$dateNextRound = $dateToday->subDay();
		}

		$betweenDate = "BETWEEN '$dateCurrentRound' AND '$dateNextRound'";

		return \Cache::tags('playoffs')->remember("games_{$conference}_{$round}", 60,
			() ==> {
				$games = Models\PlayoffTeams::byConference($conference, $round);
				foreach ($games as &$game) {
					$wins[$game['team1_id']] = $wins[$game['team2_id']] = 0;
					$game['regularSeasonGames'] = Models\GameScores::betweenTeams(
						$game['team1']['id'], $game['team2']['id'], $betweenDate
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
				return $games;
			}
		);
	}
}
