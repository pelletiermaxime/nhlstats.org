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

        foreach ($rounds as $round) {
            $winners = PlayoffRounds::getWinners($round);

            foreach ($choicesByUsers as $username => $userChoices) {
                if (!isset($userPoints[$username])) {
                    $userPoints[$username]  = 0;
                }
                foreach ($userChoices as $userChoice) {
                    $userPoints[$username] += self::getPointsForRightGameChoices($winners, $userChoice);
                }
            }
        }

        return $userPoints;
    }

    private static function getPointsForRightGameChoices(array $winners, \stdClass $userChoice) : int
    {
        $points = 0;
        if (isset($winners[$userChoice->id])) {
            $points += 5; // Right team

            $resultNbGames = $winners[$userChoice->id];
            if ($resultNbGames == $userChoice->games) {
                $points += 3; //Right nb of games
            }
            if ($resultNbGames + 1 == $userChoice->games ||
                $resultNbGames - 1 == $userChoice->games) {
                $points += 1; //+- 1 game
            }
        }
        return $points;
    }
}
