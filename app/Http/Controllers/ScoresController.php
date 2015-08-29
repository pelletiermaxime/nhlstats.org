<?php

namespace App\Http\Controllers;

use App\Http\Models\DateHelper;
use App\Http\Models\GameScores;

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
