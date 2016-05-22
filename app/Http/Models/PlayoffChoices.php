<?php

namespace Nhlstats\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public static function getChoices() : Collection
    {
        $query = DB::table('playoff_choices')
            ->select(['username', 'short_name', 'city', 'teams.name', 'games', 'teams.id', 'playoff_choices.round'])
            ->join('playoff_teams', 'playoff_teams.id', '=', 'playoff_choices.playoff_team_id')
            ->join('teams', 'teams.id', '=', 'playoff_choices.winning_team_id')
            ->join('users', 'users.id', '=', 'playoff_choices.user_id')
        ;

        return collect($query->get());
    }

    public static function formatChoicesByRoundsAndUsername(Collection $choices) : Collection
    {
        return $choices->groupBy('round')->map(function ($roundChoices) {
            return $roundChoices->groupBy('username');
        });
    }

    public static function formatChoicesByUsernameAndRounds(Collection $choices, array $pointsForRoundsByUsers) : Collection
    {
        return $choices->groupBy('username')->map(
            function ($roundChoices, $username) use ($pointsForRoundsByUsers) {
                return $roundChoices->groupBy('round')->map(
                    function ($roundChoice, $noRound) use ($pointsForRoundsByUsers, $username) {
                        return [
                            'choices' => $roundChoice,
                            'points'  => $pointsForRoundsByUsers[$noRound][$username],
                        ];
                    }
                );
            }
        );
    }

    public static function getPointsByRoundsForUsers(Collection $choicesByUsers) : array
    {
        $userPoints = [];
        $choicesByUsers = self::formatChoicesByRoundsAndUsername($choicesByUsers);

        $rounds = PlayoffRounds::getForYear();

        foreach ($rounds as $round) {
            $winners = collect(PlayoffRounds::getWinners($round));
            $noRound = $round->round;
            $userPoints[$noRound] = $choicesByUsers[$noRound]->flatMap(
                function ($userChoice, $username) use ($winners) {
                    $choicesIDWithGames = $userChoice->pluck('games', 'id');
                    return [$username => self::getPointsForRightGameChoices($winners, $choicesIDWithGames)];
                }
            );
        }

        return $userPoints;
    }

    private static function getPointsForRightGameChoices(Collection $winners, Collection $choicesIDWithGames) : int
    {
        $points = $winners->map(function ($games, $winner) use ($choicesIDWithGames) {
            $points = 0;
            if ($choiceGames = $choicesIDWithGames->get($winner)) {
                $points += 5;
                if ($games == $choiceGames) {
                    $points += 3; //Right nb of games
                }
                if ($games + 1 == $choiceGames ||
                    $games - 1 == $choiceGames) {
                    $points += 1; //+- 1 game
                }
            }
            return $points;
        });
        return $points->sum();
    }
}
