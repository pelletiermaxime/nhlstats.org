<?php

namespace Nhlstats\Http\Controllers;

use Carbon\Carbon;
use Nhlstats\Http\Models\GameScores;
use Nhlstats\Http\Models\PlayoffRounds;
use Nhlstats\Http\Models\PlayoffTeams;

class PlayoffBracketController extends Controller
{
    public function index()
    {
        $gamesEast = $gamesWest = [];
        $rounds = PlayoffRounds::getForYear();

        foreach ($rounds as $round) {
            $noRound = $round->round;
            $gamesEast[$noRound] = $this->getPlayoffBracket('EAST', $round);
            $gamesWest[$noRound] = $this->getPlayoffBracket('WEST', $round);
        }

        return view('playoffBracket.bracket')
            ->withGamesEast($gamesEast)
            ->withGamesWest($gamesWest)
        ;
    }

    private function getPlayoffBracket($conference, $round)
    {
        $games = $wins = [];

        $dateToday        = Carbon::today();
        $dateCurrentRound = $round->date_start;
        $dateNextRound    = $round->date_end;
        $noRound = $round->round;

        // Don't show scores for today
        if ($dateNextRound > $dateToday->format('Y-m-d')) {
            $dateNextRound = $dateToday->subDay();
        }

        $betweenDate = "BETWEEN '$dateCurrentRound' AND '$dateNextRound'";

        return \Cache::tags('playoffs')->remember(
            "games_{$conference}_{$noRound}",
            60,
            function () use ($conference, $noRound, $betweenDate) {
                $games = PlayoffTeams::byConference($conference, $noRound);
                foreach ($games as &$game) {
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
}
