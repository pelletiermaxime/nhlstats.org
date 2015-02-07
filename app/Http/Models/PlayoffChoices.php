<?php

class PlayoffChoices extends Eloquent
{
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

	public function getChoicesByUsers()
	{
		$query = DB::table('playoff_choices')
			->join('playoff_teams', 'playoff_teams.id', '=', 'playoff_choices.playoff_team_id')
			->join('teams', 'teams.id', '=', 'playoff_choices.winning_team_id')
			->join('users', 'users.id', '=', 'playoff_choices.user_id')
			->remember(60 * 60)
		;
		$playoffChoices = $query->get();
		foreach ($playoffChoices as $choice)
		{
			$userChoices[$choice->username][] = $choice;
		}
		// Debugbar::log($playoffChoices);
		// Debugbar::log($userChoices);
		return $userChoices;
	}
}
