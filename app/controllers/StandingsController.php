<?php

class StandingsController extends BaseController
{
	private $standings;

	public function __construct(Standings $standings)
	{
		$this->standings = $standings;
	}

	public function overall()
	{
		$standings = $this->standings->byOverall();
		return View::make('standings.overall')
			->withStandings($standings)
		;
	}

	public function division()
	{
		$standings = $this->standings->byDivision();
		return View::make('standings.division')
			->withStandings($standings)
		;
	}

	public function wildcard()
	{
		$standings = $this->standings->byWildcard();
		return View::make('standings.wildcard')
			->withStandings($standings)
		;
	}
}
