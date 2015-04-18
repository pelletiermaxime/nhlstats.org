<?hh namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class GameScores extends Model
{
	protected $guarded = [];

	public static $rules = [];

	public function team1()
	{
		return $this->belongsTo('App\Http\Models\Team');
	}

	public function team2()
	{
		return $this->belongsTo('App\Http\Models\Team');
	}

	public function betweenTeams($team1_id, $team2_id, $dateCondition = '')
	{
		$gamesScores = GameScores::whereRaw(
				'((team1_id = ? AND team2_id = ?) OR (team1_id = ? AND team2_id = ?))',
				[$team1_id, $team2_id, $team2_id, $team1_id]
			)
			->where('year', '=', \Config::get('nhlstats.currentYear'))
			->orderBy('date_game')
			->with(['team1', 'team2'])
		;
		if ($dateCondition !== '') {
			$gamesScores->whereRaw("date_game $dateCondition");
		}
		return $gamesScores->get();
	}
}
