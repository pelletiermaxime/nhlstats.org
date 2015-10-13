<?php

namespace Nhlstats\Http\Controllers;

use Nhlstats\Http\Models;
use Nhlstats\Http\Controllers\Controller;

class PoolController extends Controller
{
    public function __construct()
    {
        $this->rounds = \Config::get('nhlstats.rounds');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $choicesByUsers = Models\PlayoffChoices::getChoicesByUsers();
        // var_dump($playoffChoices);
        // die;
        return view('pool/list')
            ->with('choicesByUsers', $choicesByUsers)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $playoffTeams = \Input::get('WinningTeamId');
        $games = \Input::get('NbGames');
        $round = \Input::get('round');
        $currentYear = \Config::get('nhlstats.currentYear');
        foreach ($playoffTeams as $playoff_team_id => $winning_team_id) {
            $playoffChoices = Models\PlayoffChoices::firstOrNew([
                'user_id'         => \Auth::user()->id,
                'playoff_team_id' => $playoff_team_id,
            ]);
            $playoffChoices->winning_team_id = $winning_team_id;
            $playoffChoices->year = $currentYear;
            $playoffChoices->round = $round;
            $playoffChoices->games = $games[$playoff_team_id];
            $playoffChoices->save();
        }

        return \Redirect::route('pool_me')->withSuccess('Pool choices saved');
    }

    /**
     * Show an user's pool choices.
     *
     * @param int $round
     *
     * @return bool Was there choices to show ?
     */
    public function show($user_id, $round)
    {
        $query = \DB::table('playoff_choices')
            ->join('playoff_teams', 'playoff_teams.id', '=', 'playoff_choices.playoff_team_id')
            ->join('teams', 'teams.id', '=', 'playoff_choices.winning_team_id')
            ->whereUserId($user_id)
            ->where('playoff_choices.round', $round)
        ;
        $playoffChoices = $query->get();
        if (count($playoffChoices)) {
            return view('pool/show')
                ->with('playoffChoices', $playoffChoices)
                ->withRound($round)
            ;
        }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $user_id = \Auth::user()->id;
        $view = '';

        foreach ($this->rounds as $round => $date) {
            $resultView = $this->show($user_id, $round);
            $view .= $resultView;

            // There's choices for this round, so don't show choice form
            if ($resultView !== false) {
                continue;
            }

            $gamesEast = Models\PlayoffTeams::byConference('EAST', $round);
            $gamesWest = Models\PlayoffTeams::byConference('WEST', $round);
            $playoffTeams = array_merge($gamesEast, $gamesWest);
            if (count($playoffTeams) > 0) {
                $view .= view('pool/me')
                    ->with('playoffTeams', $playoffTeams)
                    ->withRound($round)
                ;
            }
        }

        return view('pool/edit')
                ->with('view', $view)
            ;
    }
}
