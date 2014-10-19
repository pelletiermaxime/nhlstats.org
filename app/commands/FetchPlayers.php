<?php

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class FetchPlayers extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nhl:fetch-players';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch player stats from espn.';

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
		$players = $this->getPlayersArray();
		$this->savePlayers($players);
	}

	private function getPlayersArray()
	{
		$client = Goutte::getNewClient();
		$startingPage = $this->argument('startingPage');
		$endingPage   = $this->argument('endingPage');
		$currentPage  = $startingPage;

		$params = ['Rank', 'Player', 'Team', 'GP', 'G', 'A', 'P', '+/-', 'PIM', '1', '2', '3', '4', '5', '6', '7', '8'];
		$paramCount = count($params);
		$player = [];
		$noPlayer = 1;

		while ($currentPage <= $endingPage)
		{
			$fetchCount = ($currentPage-1) * 40 + 1;
			$regularSeasonUrl = "http://espn.go.com/nhl/statistics/player/_/stat/points/sort/points/seasontype/2/count/";
			$crawler = $client->request('GET', $regularSeasonUrl . $fetchCount);
			$cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(array('_text'));

			$noParametre = 0;
			foreach($cells as $cell)
			{
				$curParam = $params[$noParametre];
				$player[$noPlayer][$curParam] = trim($cell);
				if ($curParam == 'Player')
				{
					$tabPlayerName = explode(',', $cell);
					$player[$noPlayer]['Player'] = $tabPlayerName[0];
					$player[$noPlayer]['Pos']    = trim($tabPlayerName[1]);
				}
				$noParametre++;
				if ($noParametre >= $paramCount) //Next row of table, so increment player
				{
					$noParametre = 0;
					$noPlayer++;
				}
			}
			echo "Page #$currentPage fetched\n";
			sleep(2.5);
			$currentPage++;
		}
		// var_dump($player);
		return $player;
	}

	private function savePlayers($players)
	{
		echo "Enregistre les informations dans la bd mysql\n";
		foreach ($players as $player)
		{
			if (empty($player['Player'])) continue;
			$fullName   = $player['Player'];
			$arrayFullName   = explode(' ', $fullName);
			$firstName  = $arrayFullName[0];
			$name       = $arrayFullName[1];
			$position   = $player['Pos'];
			$tabTeam    = explode('/', $player['Team']);
			$newPlayerTeam = $tabTeam[0];
			$replace    = ['LA', 'SJ', 'TB', 'NJ'];
			$replace_to = ['LAK', 'SJS', 'TBL', 'NJD'];
			$newPlayerTeam = str_replace($replace, $replace_to, $newPlayerTeam);
			#echo $newPlayerTeam;
			$playerTeamID = Team::whereShortName($newPlayerTeam)->pluck('id');

			$playerDB = Player::firstOrNew([
				'full_name' => $fullName,
				'team_id'   => $playerTeamID,
			]);
			$playerDB->first_name = $firstName;
			$playerDB->name       = $name;
			$playerDB->position   = $position;
			$playerDB->year       = Config::get('nhlstats.currentYear');
			$playerDB->save();

			$player_stats = PlayersStatsYear::firstOrNew([
				'player_id' => $playerDB->id
			]);

			//Don't update needlessly if the player hasn't played a new game
			if ($player_stats->exists() && $player_stats->games == $player['GP'])
			{
				continue;
			}

			$this->savePlayerStatsDay($playerDB, $player_stats, $player);

			$player_stats->games   = $player['GP'];
			$player_stats->goals   = $player['G'];
			$player_stats->assists = $player['A'];
			$player_stats->points  = $player['P'];
			$player_stats->plusminus = $player['+/-'];
			$player_stats->save();
		}
	}

	public function savePlayerStatsDay($playerDB, $player_stats, $player)
	{
		$player_stats_day = PlayersStatsDays::firstOrNew([
			'player_id' => $playerDB->id,
			'day'       => Carbon::today(),
		]);

		$player_stats_day->goals   = $player['G'] - $player_stats->goals;
		$player_stats_day->assists = $player['A'] - $player_stats->assists;
		$player_stats_day->points  = $player['P'] - $player_stats->points;
		$player_stats_day->plusminus = $player['+/-'] - $player_stats->plusminus;
		$player_stats_day->save();
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
			array('endingPage', InputArgument::OPTIONAL, 'Fetch only a specific page.', 20),
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
