<?php

class Player extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function team()
	{
		return $this->belongsTo('Team');
	}
}
