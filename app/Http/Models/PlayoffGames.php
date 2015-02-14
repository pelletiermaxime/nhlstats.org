<?php

class PlayoffGames extends Eloquent
{
	/**
	 * Return all playoff games for a conference and a round
	 * @param  string  $conference EAST|WEST
	 * @param  integer $round
	 * @return [type]              [description]
	 */
	public function byConference($conference, $round = 1)
	{
		$gamesEast = Cache::remember("playoffGames_".$conference, 60, function() {
		return PlayoffTeams::whereConference($conference)
			->with('Team1')
			->with('Team2')
			->get()
			->toArray();
		});
	}
}
