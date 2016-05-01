<?php

namespace Nhlstats\Http\Models;

use DB;
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

    public static function getChoicesByUsers() : array
    {
        $userChoices = [];
        $query = DB::table('playoff_choices')
            ->select(['username', 'short_name', 'city', 'teams.name', 'games', 'teams.id'])
            ->join('playoff_teams', 'playoff_teams.id', '=', 'playoff_choices.playoff_team_id')
            ->join('teams', 'teams.id', '=', 'playoff_choices.winning_team_id')
            ->join('users', 'users.id', '=', 'playoff_choices.user_id')
        ;
        $playoffChoices = $query->get();
        foreach ($playoffChoices as $choice) {
            $userChoices[$choice->username][] = $choice;
        }

        return $userChoices;
    }

    public static function getPointsByUsers(array $choicesByUsers) : array
    {
        $userPoints = [];

        $rounds = PlayoffRounds::getForYear();

        $winners = [];
        foreach ($rounds as $round) {
            $noRound = $round->round;
            $winners = PlayoffRounds::getWinners($round);

            foreach ($choicesByUsers as $username => $userChoices) {
                if (!isset($userPoints[$username])) {
                    $userPoints[$username]  = 0;
                }
                foreach ($userChoices as $userChoice) {
                    if (isset($winners[$userChoice->id])) {
                        $userPoints[$username] += 5; // Right team

                        $winInGames = $winners[$userChoice->id];
                        if ($winInGames == $userChoice->games) {
                            $userPoints[$username] += 3; //Right nb of games
                        }
                        if ($winInGames + 1 == $userChoice->games ||
                            $winInGames - 1 == $userChoice->games) {
                            $userPoints[$username] += 1; //Right nb of games
                        }
                    }
                }
            }
        }

        return $userPoints;
    }
}
