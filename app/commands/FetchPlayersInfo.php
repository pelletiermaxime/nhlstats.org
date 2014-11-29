<?php

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class FetchPlayersInfo extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nhl:fetch-players-info';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fetch player info from espn.';

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
		$playersInfo = $this->getPlayersInfo();
		$this->savePlayers($playersInfo);
	}

	private function getPlayersInfo()
	{
		$client = Goutte::getNewClient();

		$params = ['number', 'name', 'age', 'height', 'weight', 'shoots', 'birthplace', 'birthdate'];
		$paramCount = count($params);
		$player = [];
		$noPlayer = 1;

		$teamsPage = 'http://espn.go.com/nhl/players';
		$crawler = $client->request('GET', $teamsPage);
		$teamsLinks = $crawler->filter('ul.small-logos li div a')->extract(['href']);

		foreach ($teamsLinks as $teamLink)
		{
			$teamPage = "http://espn.go.com$teamLink";
			$crawler = $client->request('GET', $teamPage);
			$cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(['_text']);

			$noParametre = 0;
			if (count($cells) == 0) {
				break;
			}
			foreach($cells as $cell)
			{
				$curParam = $params[$noParametre];
				$player[$noPlayer][$curParam] = trim($cell);
				$noParametre++;
				if ($noParametre >= $paramCount) //Next row of table, so increment player
				{
					$noParametre = 0;
					$noPlayer++;
				}
			}
			echo "Page $teamLink fetched\n";
			sleep(2.5);
		}
		return $player;
	}

	private function savePlayers($players)
	{
		$currentYear = Config::get('nhlstats.currentYear');
		echo "Enregistre les informations dans la bd mysql\n";
		foreach ($players as $player)
		{
			if (empty($player['name'])) continue;
			$fullName   = $player['name'];

			$birthdate = Carbon::createFromFormat('m/d/y', $player['birthdate']);
			$birthdate = $birthdate->format('Y-m-d');

			list($city, $country) = explode(', ', $player['birthplace']);

			$playerDB = Player::firstOrNew([
				'full_name' => $fullName,
				'year'      => $currentYear,
			]);
			$playerDB->number    = $player['number'];
			$playerDB->birthdate = $birthdate;
			$playerDB->city      = $city;
			$playerDB->country   = $country;
			$playerDB->weight    = $player['weight'];
			$playerDB->height    = $player['height'];
			$playerDB->shoots    = $player['shoots'];
			$playerDB->save();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}
}
