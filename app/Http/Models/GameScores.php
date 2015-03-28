<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class GameScores extends Model
{
	protected $guarded = array();

	public static $rules = array();

	public function team1()
	{
		return $this->belongsTo('Team');
	}

	public function team2()
	{
		return $this->belongsTo('Team');
	}
}
