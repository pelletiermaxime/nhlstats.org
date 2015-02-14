<?hh

use Carbon\Carbon;

class PlayerPageController extends \Controller
{
	/**
	 * Show info and daily stats for a player
	 * @param  int    $id   player_id
	 * @param  string $name player's full_name
	 * @return View
	 */
	public function index(mixed $id, string $name)
	{
		$playerStatsDays = PlayersStatsDays::wherePlayerId($id)
			->where('day' , '>', '2014-10-18')
			->orderBy('day', 'DESC')
			->get()
			;

		$playerStatsYear = PlayersStatsYear::wherePlayerId($id)
			->first()
			;

		$player = Player::find($id);

		$games = GameScores::whereRaw("team1_id = {$player->team->id} OR team2_id = {$player->team->id}")
			->with(['team1', 'team2'])
			->get()
			;

		foreach ($games as $id => $game) {
			if ($game->team1_id == $player->team->id) {
				$enemyTeam = $game->team2;
			} else {
				$enemyTeam = $game->team1;
			}
			$enemies[$game['date_game']] = $enemyTeam;
		}

		return View::make('players.page')
			->withStatsDays($playerStatsDays)
			->withStatsYear($playerStatsYear)
			->withPlayer($player)
			->withEnemies($enemies)
			;
	}
}
