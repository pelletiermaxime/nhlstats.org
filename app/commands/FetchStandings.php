<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FetchStandings extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nhl:fetch-standings';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch the nhl standing info from espn.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$teams = $this->getTeamsArray();
		Standings::whereYear('1314')->delete();
		foreach($teams as $team)
		{
			if (strpos($team['Team'], 'NY') !== false)
			{
				$teamNY = str_replace('NY ', '', $team['Team']);
				$team_id = Team::whereName($teamNY)->pluck('id');
			}
			else
			{
				$tabTeam = explode('-', $team['Team']);
				if (isset($tabTeam[1])) {
					$teamName = trim($tabTeam[1]);
				} else {
					$teamName = $team['Team'];
				}
				$team_id = Team::whereCity($teamName)->pluck('id');
			}
			Standings::create([
				'team_id' => $team_id,
				'year'    => '1314',
				'gp'      => $team['GP'],
				'w'       => $team['W'],
				'l'       => $team['L'],
				'otl'     => $team['OTL'],
				'pts'     => $team['PTS'],
				'gf'      => $team['GF'],
				'ga'      => $team['GA'],
				'diff'    => $team['Diff'],
				'ppg'     => $team['PPG'],
				'ppo'     => $team['PPO'],
				'ppp'     => $team['PPP'],
				'ppga'    => $team['PPGA'],
				'ppoa'    => $team['PPOA'],
				'pkp'     => $team['PKP'],
				'home'    => $team['HOME'],
				'away'    => $team['ROAD'],
				'l10'     => $team['L10'],
				'streak'  => $team['Streak'],
			]);
		}

		// var_dump($teams);
	}

	private function getTeamsArray()
	{
		$client = Goutte::getNewClient();

		$params = ['Team', 'GP', 'W', 'L', 'OTL', 'PTS', 'ROW', 'SOW', 'SOL', 'HOME', 'ROAD', 'GF', 'GA', 'Diff', 'L10', 'Streak'];
		$paramCount = count($params);

		$crawler = $client->request('GET', 'http://espn.go.com/nhl/standings');
		$cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(array('_text'));

		$noParametre = 0;
		$noTeam = 1;
		foreach($cells as $cell) {
			$team[$noTeam][$params[$noParametre]] = trim($cell);
			$noParametre++;
			if ($noParametre >= $paramCount) //Next row of table, so increment team
			{
				$noParametre = 0;
				$noTeam++;
			}
		}

		$params = ['Team', 'GP', 'W', 'L', 'OTL', 'PTS', 'PPG', 'PPO', 'PPP', 'PPGA', 'PPOA', 'PKP'];
		$paramCount = count($params);

		$crawler = $client->request('GET', 'http://espn.go.com/nhl/standings/_/type/expanded');
		$cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(array('_text'));

		$noParametre = 0;
		$noTeam = 1;
		foreach($cells as $cell)
		{
			$team[$noTeam][$params[$noParametre]] = trim($cell);
			$noParametre++;
			if ($noParametre >= $paramCount) //Next row of table, so increment team
			{
				$noParametre = 0;
				$noTeam++;
			}
		}

		return $team;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
}