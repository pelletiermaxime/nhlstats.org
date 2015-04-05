<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Standings extends Model
{
	protected $guarded = array();

	public static $rules = array();

	public function team()
	{
		return $this->belongsTo('Team');
	}

	public function byOverall()
	{
		$query = \DB::table('standings')
			->join('teams'    , 'teams.id'    , '=', 'standings.team_id')
			->join('divisions', 'divisions.id', '=', 'teams.division_id')
			->orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('row', 'DESC')
			->where('standings.year', \Config::get('nhlstats.currentYear'))
		;
		$standings = $query->get();
		return $standings;
	}

	public function byDivision()
	{
		$query = \DB::table('standings')
			->join('teams'    , 'teams.id'    , '=', 'standings.team_id')
			->join('divisions', 'divisions.id', '=', 'teams.division_id')
			->orderBy('conference', 'ASC')
			->orderBy('division', 'ASC')
			->orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('row', 'DESC')
			->where('standings.year', \Config::get('nhlstats.currentYear'))
		;
		$standings = $query->get();
		return $standings;
	}

	public function byConference()
	{
		$query = \DB::table('standings')
			->join('teams'    , 'teams.id'    , '=', 'standings.team_id')
			->join('divisions', 'divisions.id', '=', 'teams.division_id')
			->orderBy('conference', 'ASC')
			->orderBy('PTS', 'DESC')
			->orderBy('gp', 'ASC')
			->orderBy('row', 'DESC')
			->where('standings.year', \Config::get('nhlstats.currentYear'))
		;
		$standings = $query->get();
		return $standings;
	}

	public function byWildcard()
	{
		$byDivision   = $this->byDivision();
		$byConference = $this->byConference();
		//Get the standings by division
		foreach($byDivision as $standing)
		{
			$wildCard[$standing->division][] = $standing;
		}
		//Get the first three of each division
		foreach($wildCard as $division => &$standingDivision)
		{
			$standingDivision = array_splice($standingDivision, 0, 3);
		}

		//Get a list of team_id of those 6 top teams
		$wildCardList = array_flatten($wildCard);
		$wildCardList = array_map(function($array) {return $array->team_id; }, $wildCardList);

		foreach ($byConference as $standing)
		{
			if (!in_array($standing->team_id, $wildCardList))
			{
				// if (empty($wildCardConference[$standing->conference]) ||
				// 	count($wildCardConference[$standing->conference]) < 2)
				// {
					$wildCardConference[$standing->conference][] = $standing;
				// }
			}
		}
		$standings['conference'] = $wildCard;
		$standings['wildcard']   = $wildCardConference;
		return $standings;
	}
}
