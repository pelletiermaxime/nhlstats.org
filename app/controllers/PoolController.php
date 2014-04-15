<?php

class PoolController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	 * @return type
	 */
	public function show()
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		$user_id = Confide::user()->id;

		$playoffChoices = PlayoffChoices::whereUserId($user_id)
			->get();
		if (count($playoffChoices) > 0)
		{
			$this->show();
		}

		$playoffTeams = PlayoffTeams::with('Team1')
			->with('Team2')
			->get()
			->toArray();
		Debugbar::log($playoffTeams);
		return View::make('pool/me')
			->with('playoffTeams', $playoffTeams)
		;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}