<?php

class PlayoffTeams extends Eloquent {
	protected $guarded = [];
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