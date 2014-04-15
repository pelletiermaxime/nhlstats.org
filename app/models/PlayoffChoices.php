<?php

class PlayoffChoices extends Eloquent {
	protected $guarded = [];
	public static $rules = array();

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function playoffTeam()
	{
		return $this->belongsTo('PlayoffTeams');
	}

	public function winningTeam()
	{
		return $this->belongsTo('Team');
	}
}