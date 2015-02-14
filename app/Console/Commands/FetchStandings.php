<?php namespace App\Console\Commands;

use Goutte\Client;
use Illuminate\Console\Command;

class FetchStandings extends Command
{
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
	 * @var Client $client Goutte client
	 */
	private $client;

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->client = new Client();
		$teams = $this->getTeamsArray();
		$this->saveStandings($teams);
		$this->generatePlayoffTeams();
	}

	private function saveStandings($teams)
	{
		\Standings::where('year', \Config::get('nhlstats.currentYear'))->delete();
		foreach($teams as $team)
		{
			$tabTeam = explode('-', $team['Team']);
			if (isset($tabTeam[1])) {
				$teamName = trim($tabTeam[1]);
			} else {
				$teamName = $team['Team'];
			}
			if (strpos($team['Team'], 'NY') !== false)
			{
				$teamNY = str_replace('NY ', '', $teamName);
				$team_id = \Team::whereName($teamNY)->pluck('id');
			}
			else
			{
				$team_id = \Team::whereCity($teamName)->pluck('id');
			}
			\Standings::create([
				'team_id' => $team_id,
				'year'    => \Config::get('nhlstats.currentYear'),
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
	}

	private function getTeamsArray()
	{
		$params = ['Team', 'GP', 'W', 'L', 'OTL', 'PTS', 'ROW', 'SOW', 'SOL', 'HOME',
			'ROAD', 'GF', 'GA', 'Diff', 'L10', 'Streak'];
		$paramCount = count($params);

		$crawler = $this->client->request('GET', 'http://espn.go.com/nhl/standings');
		$cells   = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(array('_text'));

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

		$params     = ['Team', 'GP', 'W', 'L', 'OTL', 'PTS', 'PPG', 'PPO', 'PPP', 'PPGA', 'PPOA', 'PKP'];
		$paramCount = count($params);

		$crawler = $this->client->request('GET', 'http://espn.go.com/nhl/standings/_/type/expanded');
		$cells   = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(array('_text'));

		$noParametre = 0;
		$noTeam      = 1;
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

	private function generatePlayoffTeams()
	{
		$playoff = \App::make('Nhlstats\Repositories\PlayoffRepository');
		$gamesEast = $playoff->getPlayoffGamesEast();
		$this->savePlayoffTeams($gamesEast, 'EAST');
		$gamesWest = $playoff->getPlayoffGamesWest();
		$this->savePlayoffTeams($gamesWest, 'WEST');
	}

	/**
	 * @param string $conference
	 */
	private function savePlayoffTeams($games, $conference)
	{
		foreach ($games as $division)
		{
			foreach ($division as $game)
			{
				$team1 = $game['team1']->team_id;
				$team2 = $game['team2']->team_id;
				$conference = $conference;
				$round = 1;
				$playoffTeams = \PlayoffTeams::firstOrNew([
					'team1_id'   => $team1,
					'team2_id'   => $team2,
					'conference' => $conference,
					'round'      => $round,
				]);
				$playoffTeams->save();
			}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}
}
