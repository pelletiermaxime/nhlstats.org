<?hh

use Nhlstats\Repositories\TeamRepository as Team;
use Carbon\Carbon;

class PlayerController extends BaseController {

	public function __construct(
		private Team $team,
		private PlayersStatsYear $players_stats_year,
		private PlayersStatsDays $players_stats_day,
	) {}

	public function getListFiltered()
	{
		/* ----------- COUNTS ----------- */
		$all_counts = [
			'50'  => '50',
			'100' => '100',
			'500' => '500',
			'All' => 'All'
		];
		$count = Input::get('count', head($all_counts));
		//Default to 50 if not a possible count
		if (!isset($all_counts[$count]))
		{
			$count = head($all_counts);
		}

		/* ----------- TEAMS ----------- */
		$all_teams = ['all' => '---------------'] + $this->team->getWithShortNameAndCity();

		$team = Input::get('team', 'all');
		//Default to first team if invalid is passed
		if (!isset($all_teams[$team]))
		{
			$team = 'all';
		}

		/* ---------- POSITION ---------- */
		$all_positions = [
			'All' => 'All',
			'F'   => 'Forward',
			'L'   => 'Left',
			'C'   => 'Center',
			'R'   => 'Right',
			'D'   => 'Defense'
		];

		$position = Input::get('position', head($all_positions));
		if (!isset($all_positions[$position]))
		{
			$position = head($all_positions);
		}

		/* -------- PLAYER STATS -------- */
		$filter['teams.short_name'] = ['=', $team];
		$filter['players.year'] = ['=', Config::get('nhlstats.currentYear')];
		$playersStatsYear = Cache::remember(
			"playersStatsYear-{$count}-{$team}",
			60,
			function() use ($count, $filter) {
				return $this->players_stats_year->topPlayersByPoints($count, $filter);
			}
		);

		$filter['day'] = ['=', Carbon::today()];
		$playersStatsDay = $this->playersStatsDay($count, $filter);

		return View::make('players')
			->with('playersStatsDay', $playersStatsDay)
			->with('playersStatsYear', $playersStatsYear)
			->with('all_teams', $all_teams)
			->with('team', $team)
			->with('all_positions', $all_positions)
			->with('position', $position)
			->with('all_counts', $all_counts)
			->with('count', $count)
			->with('asset_path', asset(''))
		;
	}

	private function playersStatsDay($count, $filter)
	{
		$filter_string = implode('', array_flatten($filter));
		return Cache::remember(
			"playersStatsDay-{$filter_string}",
			60,
			function() use ($count, $filter) {
				return $this->players_stats_day->topPlayersByPoints($count, $filter);
			}
		);
	}
}
