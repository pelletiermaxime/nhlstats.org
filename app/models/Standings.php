<?php

class Standings extends Eloquent
{
	protected $guarded = array();

	public static $rules = array();

	public function team()
	{
		return $this->belongsTo('Team');
	}
}
