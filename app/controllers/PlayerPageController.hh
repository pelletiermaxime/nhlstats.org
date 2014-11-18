<?hh

class PlayerPageController extends BaseController
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
			->orderBy('day', 'DESC')
			->get()
		;
		$playerStatsYear = PlayersStatsYear::wherePlayerId($id)
			->first()
		;
		$player = Player::find($id)
		;
		Debugbar::log($player->toArray());
		Debugbar::log($playerStatsDays->toArray());
		Debugbar::log($playerStatsYear->toArray());

		return View::make('players.page')
			->withStatsDays($playerStatsDays)
			->withStatsYear($playerStatsYear)
			->withPlayer($player)
			;
	}
}
