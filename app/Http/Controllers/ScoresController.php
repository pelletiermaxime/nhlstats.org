<?php

namespace Nhlstats\Http\Controllers;

use Nhlstats\Http\Models\DateHelper;
use Nhlstats\Http\Models\GameScores;
use Nhlstats\Http\Controllers\Controller;

class ScoresController extends Controller
{
    public function index($date = null)
    {
        $dates = DateHelper::getDates($date);

        $scores = GameScores::whereDateGame($dates['today'])
            ->with(['team1', 'team2'])
            ->get()
        ;

        return view('scores')
            ->withScores($scores)
            ->withDates($dates)
        ;
    }
}
