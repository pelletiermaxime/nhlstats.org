<?php

namespace Nhlstats\Http\Controllers;

use Auth;
use DB;
use Input;
use Nhlstats\Http\Models\PlayoffChoices;
use Nhlstats\Http\Models\PlayoffRounds;
use Nhlstats\Http\Models\PlayoffTeams;

class PoolController extends Controller
{
    public function __construct()
    {
        $this->rounds = PlayoffRounds::getForYear();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $choicesByUsers = PlayoffChoices::getChoicesByUsers();

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
        $playoffTeams = Input::get('WinningTeamId');
        $games = Input::get('NbGames');
        $round = Input::get('round');
        $currentYear = config('nhlstats.currentYear');
        foreach ($playoffTeams as $playoff_team_id => $winning_team_id) {
            $playoffChoices = PlayoffChoices::firstOrNew([
                'user_id'         => Auth::user()->id,
                'playoff_team_id' => $playoff_team_id,
            ]);
            $playoffChoices->winning_team_id = $winning_team_id;
            $playoffChoices->year = $currentYear;
            $playoffChoices->round = $round;
            $playoffChoices->games = $games[$playoff_team_id];
            $playoffChoices->save();
        }

        return redirect()->route('pool_me')->withSuccess('Pool choices saved');
    }

    /**
     * Show an user's pool choices.
     *
     * @param  int    $round   Round number
     *
     * @return View|bool Was there choices to show ?
     */
    public function show(int $user_id, int $round)
    {
        $query = DB::table('playoff_choices')
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
     * Edit/fill playoff pool choices.
     *
     * @return Response
     */
    public function edit()
    {
        $user_id = Auth::user()->id;
        $view = '';

        foreach ($this->rounds as $round) {
            $roundNumber = $round->round;

            $resultView = $this->show($user_id, $roundNumber);
            $view .= $resultView;

            // There's choices for this round, so don't show choice form
            if ($resultView !== false) {
                continue;
            }

            $gamesEast = PlayoffTeams::byConference('EAST', $roundNumber);
            $gamesWest = PlayoffTeams::byConference('WEST', $roundNumber);
            $playoffTeams = array_merge($gamesEast, $gamesWest);
            if (count($playoffTeams) > 0) {
                $view .= view('pool/me')
                    ->with('playoffTeams', $playoffTeams)
                    ->withRound($roundNumber)
                ;
            }
        }

        return view('pool/edit')->withView($view);
    }
}
