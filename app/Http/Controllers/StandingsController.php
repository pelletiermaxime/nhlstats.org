<?php

namespace Nhlstats\Http\Controllers;

use Nhlstats\Http\Models\Standings;

class StandingsController extends Controller
{
    private $standings;

    public function __construct(Standings $standings)
    {
        $this->standings = $standings;
    }

    public function overall()
    {
        $standings = $this->standings->byOverall();

        return view('standings.overall')
            ->withStandings($standings)
        ;
    }

    public function division()
    {
        $standings = $this->standings->byDivision();

        return view('standings.division')
            ->withStandings($standings)
        ;
    }

    public function wildcard()
    {
        $standings = $this->standings->byWildcard();

        return view('standings.wildcard')
            ->withStandings($standings)
        ;
    }
}
