<?php

use Carbon\Carbon;

class ScoresController extends BaseController
{
	public function index($date = null)
	{
		$dates = $this->getDates($date);

		$scores = GameScores::whereDateGame($dates['today'])
			->with(['team1', 'team2'])
			->remember(60)
			->get()
			;
		return View::make('scores')
			->withScores($scores)
			->withDates($dates)
		;
	}

	private function getDates($date)
	{
		if ($date !== null && $this->validateDate($date)) {
			$todayCarbon = Carbon::createFromFormat('Y-m-d', $date);
			$dates['today'] = $date;
		} else {
			$todayCarbon = Carbon::today();
			$dates['today'] = $todayCarbon->format('Y-m-d');
		}
		$dates['yesterday'] = $todayCarbon->copy()->subDay()->format('Y-m-d');
		$dates['tomorrow']  = $todayCarbon->copy()->addDay()->format('Y-m-d');
		return $dates;
	}

	public function validateDate($date, $format = 'Y-m-d')
	{
		$validDate = false;
		try {
			// Validation same date after formating.
			// Needed for '2014-05-32' to be invalid...
			// as the formated date would be '2014-06-01'
			$d = Carbon::createFromFormat($format, $date);
			if ($d->format($format) == $date) {
				$validDate = true;
			}
		} catch (Exception $e) {
		}
		return $validDate;
	}
}
