<?php

namespace Nhlstats\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PlayoffRounds extends Model
{
    protected $casts = [
        'id'    => 'int',
        'round' => 'int',
    ];

    public static function getForYear($year = null)
    {
        if ($year == null) {
            $year = current_year();
        }

        return self::where('year', $year)->get();
    }

    /**
     * @param  $conference EAST|WEST
     * @return array       $games
     */
    public static function getPlayoffBracket(string $conference, PlayoffRounds $round)
    {
        $games = $wins = [];
        $finalScoresToday = '';

        $dateToday        = Carbon::today();
        $dateCurrentRound = $round->date_start;
        $dateNextRound    = $round->date_end;
        $noRound = $round->round;

        // Don't show scores for today
        if ($dateNextRound > $dateToday->format('Y-m-d')) {
            $finalScoresToday = "OR (date_game = '$dateToday' AND status = 'Final')";
            $dateNextRound = $dateToday->subDay();
        }

        $betweenDate = "BETWEEN '$dateCurrentRound' AND '$dateNextRound' $finalScoresToday";

        return \Cache::tags('playoffs')->remember(
            "games_{$conference}_{$noRound}",
            60,
            function () use ($conference, $noRound, $betweenDate) {
                $games = PlayoffTeams::byConference($conference, $noRound);
                foreach ($games as &$game) {
                    $wins = [];
                    $wins[$game['team1_id']] = $wins[$game['team2_id']] = 0;
                    $game['regularSeasonGames'] = GameScores::betweenTeams(
                        $game['team1']['id'],
                        $game['team2']['id'],
                        $betweenDate
                    );
                    foreach ($game['regularSeasonGames'] as $noGameScore => $gameScore) {
                        if ($gameScore['score1_T'] > $gameScore['score2_T']) {
                            $game['regularSeasonGames'][$noGameScore]['winner'] = 'team1';
                            $wins[$gameScore['team1']['id']]++;
                        } else {
                            $game['regularSeasonGames'][$noGameScore]['winner'] = 'team2';
                            $wins[$gameScore['team2']['id']]++;
                        }
                    }
                    $game['wins'] = $wins;
                }

                return $games;
            }
        );
    }

    /**
     * @param  $noRound 1-4
     * @return Array of winning teams ID and number of games to win: [16 => 5, 18 => 7]
     */
    public static function getWinners(PlayoffRounds $round) : array
    {
        $winners = [];

        $gamesEast = self::getPlayoffBracket('EAST', $round);
        $gamesWest = self::getPlayoffBracket('WEST', $round);
        $games = array_merge($gamesEast, $gamesWest);

        foreach ($games as $playoffGame) {
            $winningTeamID = array_search(4, $playoffGame['wins']);
            if ($winningTeamID !== false) {
                $winners[$winningTeamID] = array_sum($playoffGame['wins']);
            }
        }

        return $winners;
    }
}
