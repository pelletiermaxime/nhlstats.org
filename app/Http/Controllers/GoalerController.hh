<?hh namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;

class GoalerController extends Controller
{
	public function __construct(
		private Models\Team $team,
		private Models\GoalersStatsYear $goalers_stats_year,
	){}

	public function getListFiltered()
	{
		$filter = [];
		/* ----------- TEAMS ----------- */
		$all_teams = ['all' => '---------------'] + $this->team->getWithShortNameAndCity();

		$team = \Input::get('team', 'all');
		//Default to first team if invalid is passed
		if (!isset($all_teams[$team]))
		{
			$team = 'all';
		}

		/* -------- GOALER STATS -------- */
		// Get the top played games by a goaler
		$topGames = \DB::table('goalers_stats_years AS goaler')
			->where('players.year', '=', \Config::get('nhlstats.currentYear'))
			->join('players'  , 'players.id'  , '=', 'goaler.player_id')
			->max('games');
		// Set a filter to a quarter of that
		$minGames       = $topGames / 4;
		$filterMinGames = \Input::get('show_all', 0);
		if ($filterMinGames === 0) {
			$filter['goaler.games'] = ['>=', $minGames];
		}

		$filter['teams.short_name'] = ['=', $team];
		$filter['players.year'] = ['=', \Config::get('nhlstats.currentYear')];
		$goalersStatsYear = $this->goalers_stats_year->topGoalersByGAA($filter);

		return view('goalers/goalers')
			->with('goalersStatsYear', $goalersStatsYear)
			->with('all_teams', $all_teams)
			->with('filterMinGames', $filterMinGames)
			->with('team', $team)
		;
	}
}
