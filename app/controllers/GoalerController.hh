<?hh

use Nhlstats\Repositories\TeamRepository as Team;

class GoalerController extends BaseController {

	public function __construct(private Team $team){}

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
		$goalersStatsYear = $this->goalersStatsYear($filter);

		return View::make('goalers')
			->with('goalersStatsYear', $goalersStatsYear)
			->with('all_teams', $all_teams)
			->with('team', $team)
		;
	}

	private function goalersStatsYear($filters)
	{
		$filter_string = implode('', array_flatten($filters));
		return Cache::remember("goalersStatsYear-{$filter_string}", 60, function() use ($filters) {
			$query = DB::table('goalers_stats_years AS goaler')
				->join('players'  , 'players.id'  , '=', 'goaler.player_id')
				->join('teams'    , 'teams.id'    , '=', 'players.team_id')
				->join('divisions', 'divisions.id', '=', 'teams.division_id')
				->select('goaler.*', 'divisions.conference', 'teams.name as team_name',
					'players.*', 'teams.short_name')
				->orderBy('goals_against_average', 'asc')
				->where('position', '=' , 'G');
				// ->where('games'   , '>', $minGames)

			foreach ($filters as $condition => $value)
			{
				if ($value[1] != 'all')
				{
					$query = $query->where($condition, $value[0], $value[1]);
				}
			}

			return $query->get();
		});
	}
}