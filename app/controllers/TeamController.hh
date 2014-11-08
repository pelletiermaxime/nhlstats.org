<?hh

use Carbon\Carbon;

class TeamController extends BaseController
{
	public function __construct(
		private Team $team,
		private PlayersStatsYear $players_stats_year,
		private PlayersStatsDays $players_stats_day,
		private GoalersStatsYear $goalers_stats_year,
	) {}

	public function index()
	{
		$teamsByDivision = $this->team->byDivision();
		Debugbar::log($teamsByDivision);

		return View::make('team.index')
			->withTeams($teamsByDivision)
			;
	}

	public function show($team)
	{
		$count = 'All';

		/* -------- PLAYER STATS -------- */
		$filter['teams.short_name'] = ['=', $team];
		$filter['players.year'] = ['=', Config::get('nhlstats.currentYear')];
		$playersStatsYear = Cache::remember(
			"playersStatsYear-{$count}-{$team}",
			60,
			function () use ($count, $filter) {
				return $this->players_stats_year->topPlayersByPoints($count, $filter);
			}
		);

		$pointsByPosition = $this->players_stats_year->pointsByPosition($filter);

		Debugbar::log($pointsByPosition);
		Debugbar::log($playersStatsYear);

		$goalersStatsYear = $this->goalers_stats_year->topGoalersByGAA($filter);

		$filter['day'] = ['=', Carbon::today()];
		$playersStatsDay = $this->players_stats_day->topPlayersByPoints($count, $filter);

		return View::make('team.show')
			->with('playersStatsDay', $playersStatsDay)
			->with('playersStatsYear', $playersStatsYear)
			->with('pointsByPosition', $pointsByPosition)
			->with('goalersStatsYear', $goalersStatsYear)
			->with('team', $team)
			->with('count', $count)
			->with('asset_path', asset(''))
		;
	}
}
