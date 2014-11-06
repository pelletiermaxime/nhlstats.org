<?hh

use Nhlstats\Repositories\TeamRepository as Team;

class GoalerController extends BaseController {

	public function __construct(
		private Team $team,
		private GoalersStatsYear $goalers_stats_year,
	){}

	public function getListFiltered()
	{
		/* ----------- TEAMS ----------- */
		$all_teams = ['all' => '---------------'] + $this->team->getWithShortNameAndCity();

		$team = Input::get('team', 'all');
		//Default to first team if invalid is passed
		if (!isset($all_teams[$team]))
		{
			$team = 'all';
		}

		/* -------- GOALER STATS -------- */
		// $topGames = DB::table('goalers_stats_years')->max('games');
		// $minGames = $topGames / 4;

		$filter['teams.short_name'] = ['=', $team];
		$filter['players.year'] = ['=', Config::get('nhlstats.currentYear')];
		$goalersStatsYear = $this->goalers_stats_year->topGoalersByGAA($filter);

		Debugbar::log($goalersStatsYear);

		return View::make('goalers')
			->with('goalersStatsYear', $goalersStatsYear)
			->with('all_teams', $all_teams)
			->with('team', $team)
		;
	}
}
