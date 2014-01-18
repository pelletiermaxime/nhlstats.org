<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FetchGoalers extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nhl:fetch-goalers';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch goalers stats from espn.';

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
	 * @return mixed
	 */
	public function fire()
	{
		$goalers = $this->getGoalersArray();
		$this->savePlayers($goalers);
	}

	private function getGoalersArray()
	{
		$client = Goutte::getNewClient();
		$startingPage = $this->argument('startingPage');
		$endingPage   = $this->argument('endingPage');
		$currentPage  = $startingPage;

		$params = ['Rank', 'Player', 'Team', 'GP', 'W', 'L', 'OTL', 'GAA', 'GA', 'SA', 'Sv', 'Sv%', 'SO', 'SASO', 'SVSO', 'Sv%SO'];
		$paramCount = count($params);
		$goaler = [];
		$noGoaler = 1;

		while ($currentPage <= $endingPage)
		{
			$fetchCount = ($currentPage-1) * 40 + 1;
			$regularSeasonUrl = "http://espn.go.com/nhl/statistics/player/_/stat/goaltending/qualified/false/count/$fetchCount";
			$crawler = $client->request('GET', $regularSeasonUrl);
			$cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(array('_text'));

			$noParametre = 0;
			foreach($cells as $cell)
			{
				$curParam = $params[$noParametre];
				$goaler[$noGoaler][$curParam] = trim($cell);
				if ($curParam == 'Player')
				{
					$tabPlayerName = explode(',', $cell);
					$goaler[$noGoaler]['Player'] = $tabPlayerName[0];
				}
				$noParametre++;
				if ($noParametre >= $paramCount) //Next row of table, so increment player
				{
					$noParametre = 0;
					$noGoaler++;
				}
			}
			echo "Page #$currentPage fetched\n";
			sleep(2.5);
			$currentPage++;
		}
		// var_dump($goaler);
		return $goaler;
	}

	private function savePlayers($goalers)
	{
		echo "Enregistre les informations dans la bd mysql\n";
		foreach ($goalers as $goaler)
		{
			if (empty($goaler['Player'])) continue;
			$fullName   = $goaler['Player'];
			$arrayFullName   = explode(' ', $fullName);
			$firstName  = $arrayFullName[0];
			$name       = $arrayFullName[1];
			$tabTeam    = explode('/', $goaler['Team']);
			$newPlayerTeam = $tabTeam[0];
			$replace    = ['LA', 'SJ', 'TB', 'NJ'];
			$replace_to = ['LAK', 'SJS', 'TBL', 'NJD'];
			$newPlayerTeam = str_replace($replace, $replace_to, $newPlayerTeam);
			#echo $newPlayerTeam;
			$goalerTeamID = Team::whereShortName($newPlayerTeam)->pluck('id');

			$goalerDB = Player::firstOrNew([
				'full_name' => $fullName,
				'team_id'   => $goalerTeamID,
			]);
			$goalerDB->first_name = $firstName;
			$goalerDB->name       = $name;
			$goalerDB->position   = 'G';
			$goalerDB->year       = '1314';
			$goalerDB->save();

			$goaler_stats = GoalersStatsYear::firstOrNew([
				'player_id' => $goalerDB->id
			]);
			$goaler_stats->games   = $goaler['GP'];
			$goaler_stats->win     = $goaler['W'];
			$goaler_stats->lose    = $goaler['L'];
			$goaler_stats->saves   = $goaler['Sv'];
			$goaler_stats->saves_pourcent = str_replace('.', '', $goaler['Sv%']);
			// $goaler_stats->goals   = $goaler['L'];
			// $goaler_stats->assists = $goaler['L'];
			// $goaler_stats->pim     = $goaler['L'];
			$goaler_stats->goals_against_average = $goaler['GAA'];
			$goaler_stats->shots_against = $goaler['SA'];
			$goaler_stats->goals_against = $goaler['GA'];
			$goaler_stats->shootouts     = $goaler['SO'];
			$goaler_stats->save();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('startingPage', InputArgument::OPTIONAL, 'Fetch only a specific page.', 1),
			array('endingPage', InputArgument::OPTIONAL, 'Fetch only a specific page.', 3),
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
