<?hh namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function __construct(
        private Models\Team $team,
        private Models\PlayersStatsYear $players_stats_year,
        private Models\PlayersStatsDays $players_stats_day,
        private Models\GoalersStatsYear $goalers_stats_year,
    ) {}

    public function index()
    {
        $teamsByDivision = $this->team->byDivision();

        return view('team.index')
            ->withTeamsByDivision($teamsByDivision)
            ;
    }

    public function show($team)
    {
        $count  = 'All';
        $filter = [];

        /* -------- PLAYER STATS -------- */
        $position = \Input::get('position', 'all');
        $filter['teams.short_name'] = ['=', $team];
        $filter['players.year'] = ['=', \Config::get('nhlstats.currentYear')];
        $playersStatsYear = \Cache::remember(
            "playersStatsYear-{$count}-{$team}",
            60,
            () ==> {
                return $this->players_stats_year->topPlayersByPoints($count, $filter);
            }
        );

        $pointsByPosition = $this->players_stats_year->pointsByPosition($filter);

        $goalersStatsYear = $this->goalers_stats_year->topGoalersByGAA($filter);

        $filter['day'] = ['=', Carbon::today()];
        $playersStatsDay = $this->players_stats_day->topPlayersByPoints($count, $filter);

        return view('team.show')
            ->with('playersStatsDay', $playersStatsDay)
            ->with('playersStatsYear', $playersStatsYear)
            ->with('pointsByPosition', $pointsByPosition)
            ->with('goalersStatsYear', $goalersStatsYear)
            ->with('team', $team)
            ->with('count', $count)
            ->with('position', $position)
            ->with('asset_path', asset(''))
        ;
    }
}
