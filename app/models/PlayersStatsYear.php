<?php

class PlayersStatsYear extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public function player()
	{
		return $this->belongsTo('Player');
	}
}
