<?php

namespace Nhlstats\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlayoffChoices extends Model
{
    protected $guarded = [];
    public static $rules = [];

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
        $userChoices = [];
        $query = \DB::table('playoff_choices')
            ->join('playoff_teams', 'playoff_teams.id', '=', 'playoff_choices.playoff_team_id')
            ->join('teams', 'teams.id', '=', 'playoff_choices.winning_team_id')
            ->join('users', 'users.id', '=', 'playoff_choices.user_id')
        ;
        $playoffChoices = $query->get();
        foreach ($playoffChoices as $choice) {
            $userChoices[$choice->username][] = $choice;
        }
        // Debugbar::log($playoffChoices);
        // Debugbar::log($userChoices);
        return $userChoices;
    }
}
