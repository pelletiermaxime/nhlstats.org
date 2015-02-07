<?php

class PoolController extends \Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$choicesByUsers = PlayoffChoices::getChoicesByUsers();
		// var_dump($playoffChoices);
		// die;
		return View::make('pool/list')
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
		$games        = Input::get('NbGames');
		foreach ($playoffTeams as $playoff_team_id => $winning_team_id)
		{
			$playoffChoices = PlayoffChoices::firstOrNew([
				'user_id'         => Confide::user()->id,
				'playoff_team_id' => $playoff_team_id,
			]);
			$playoffChoices->winning_team_id = $winning_team_id;
			$playoffChoices->games = $games[$playoff_team_id];
			$playoffChoices->save();
		}
		return Redirect::route('pool_me')->withSuccess('Pool choices saved');
	}

	/**
	 * Show an user's pool choices
	 * @param integer $round
	 * @return bool Was there choices to show ?
	 */
	public function show($user_id, $round)
	{
		$query = DB::table('playoff_choices')
			->join('playoff_teams', 'playoff_teams.id', '=', 'playoff_choices.playoff_team_id')
			->join('teams', 'teams.id', '=', 'playoff_choices.winning_team_id')
			->whereUserId($user_id)
			->whereRound($round)
			->remember(60 * 60)
		;
		$playoffChoices = $query->get();
		if (count($playoffChoices))
		{
			return View::make('pool/show')
				->with('playoffChoices', $playoffChoices)
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
		$user_id = Confide::user()->id;
		$view = '';

		for ($round = 1; $round <= 4; $round++)
		{
			$resultView = $this->show($user_id, $round);
			$view .= $resultView;
			if ($resultView !== false)
			{
				continue;
			}

			$playoffTeams = PlayoffTeams::with('Team1')
				->with('Team2')
				->whereRound($round)
				->remember(60 * 60)
				->get()
				->toArray();
			// Debugbar::log($playoffTeams);
			if (count($playoffTeams) > 0)
			{
				$view .= View::make('pool/me')
					->with('playoffTeams', $playoffTeams)
				;
			}
		}
		return View::make('pool/edit')
				->with('view', $view)
			;
	}
}
