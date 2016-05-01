<?php

namespace Nhlstats\Http\Controllers;

use Nhlstats\Http\Models\PlayoffRounds;

class PlayoffBracketController extends Controller
{
    public function index()
    {
        $gamesEast = $gamesWest = [];
        $rounds = PlayoffRounds::getForYear();

        foreach ($rounds as $round) {
            $noRound = $round->round;
            $gamesEast[$noRound] = PlayoffRounds::getPlayoffBracket('EAST', $round);
            $gamesWest[$noRound] = PlayoffRounds::getPlayoffBracket('WEST', $round);
        }

        return view('playoffBracket.bracket')
            ->withGamesEast($gamesEast)
            ->withGamesWest($gamesWest)
        ;
    }
}
