<?php

class GameScores extends Eloquent {
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
