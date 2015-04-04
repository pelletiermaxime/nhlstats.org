<?hh namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class PlayoffTeams extends Model
{
	protected $guarded = [];
	public static $rules = array();

	public function team1()
	{
		return $this->belongsTo('App\Http\Models\Team');
	}

	public function team2()
	{
		return $this->belongsTo('App\Http\Models\Team');
	}

	/**
	 * Return all playoff games for a conference and a round
	 * @param  string  $conference EAST|WEST
	 * @param  integer $round
	 * @return array   Games including teams
	 */
	public function byConference(string $conference, int $round = 1): array
	{
		return \Cache::remember("playoffGames_".$conference, 60*60, () ==> {
			return Models\PlayoffTeams::whereConference($conference)
				->where('year', '=', \Config::get('nhlstats.currentYear'))
				->with('Team1')
				->with('Team2')
				->get()
				->toArray();
		});
	}
}
