<?php

namespace app\Console\Commands;

use App\Http\Models;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
     * @var Client Goutte client
     */
    private $client;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->client = new Client();
        $toi = $this->option('TOI');
        if ($toi === true) {
            $players = $this->getPlayersOnIceArray();
        } else {
            $players = $this->getPlayersArray();
        }
        $this->savePlayers($players);
    }

    private function getPlayersArray()
    {
        $startingPage = $this->argument('startingPage');
        $endingPage = $this->argument('endingPage');
        $currentPage = $startingPage;

        $params = ['Rank', 'Player', 'Team', 'GP', 'G', 'A', 'P', '+/-', 'PIM', '1', '2', '3', '4', '5', '6', '7', '8'];
        $paramCount = count($params);
        $player = [];
        $noPlayer = 1;

        while ($currentPage <= $endingPage) {
            $fetchCount = ($currentPage - 1) * 40 + 1;
            $regularSeasonUrl = 'http://espn.go.com/nhl/statistics/player/_/stat/points/sort/points/seasontype/2/count/';
            $crawler = $this->client->request('GET', $regularSeasonUrl.$fetchCount);
            $cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(['_text']);

            $noParametre = 0;
            if (count($cells) == 0) {
                break;
            }
            foreach ($cells as $cell) {
                $curParam = $params[$noParametre];
                $player[$noPlayer][$curParam] = trim($cell);
                if ($curParam == 'Player') {
                    $tabPlayerName = explode(',', $cell);
                    $player[$noPlayer]['Player'] = $tabPlayerName[0];
                    $player[$noPlayer]['Pos'] = trim($tabPlayerName[1]);
                }
                ++$noParametre;
                if ($noParametre >= $paramCount) {
                    //Next row of table, so increment player

                    $noParametre = 0;
                    ++$noPlayer;
                }
            }
            echo "Page #$currentPage fetched\n";
            sleep(2.5);
            ++$currentPage;
        }
        // var_dump($player);
        return $player;
    }

    private function getPlayersOnIceArray()
    {
        $startingPage = $this->argument('startingPage');
        $endingPage = $this->argument('endingPage');
        $currentPage = $startingPage;

        $params = ['Rank', 'Player', 'Team', 'GP', 'G', 'A', 'P', '+/-', 'TOI/G', 'Shifts', '1', '2'];
        $paramCount = count($params);
        $player = [];
        $noPlayer = 1;

        echo "Fetching Players by time on ice by pages $startingPage-$endingPage\n";
        while ($currentPage <= $endingPage) {
            $fetchCount = ($currentPage - 1) * 40 + 1;
            $regularSeasonUrl = 'http://espn.go.com/nhl/statistics/player/_/stat/timeonice/sort/avgTimeOnIce/count/';
            $crawler = $this->client->request('GET', $regularSeasonUrl.$fetchCount);
            $cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(['_text']);

            $noParametre = 0;
            if (count($cells) == 0) {
                break;
            }
            foreach ($cells as $cell) {
                $curParam = $params[$noParametre];
                $player[$noPlayer][$curParam] = trim($cell);
                if ($curParam == 'Player') {
                    $tabPlayerName = explode(',', $cell);
                    $player[$noPlayer]['Player'] = $tabPlayerName[0];
                    $player[$noPlayer]['Pos'] = trim($tabPlayerName[1]);
                }
                ++$noParametre;
                if ($noParametre >= $paramCount) {
                    //Next row of table, so increment player

                    $noParametre = 0;
                    ++$noPlayer;
                }
            }
            echo "Page #$currentPage fetched\n";
            sleep(2.5);
            ++$currentPage;
        }
        // var_dump($player);
        return $player;
    }

    private function savePlayers($players)
    {
        echo "Enregistre les informations dans la bd mysql\n";
        $currentYear = \Config::get('nhlstats.currentYear');
        foreach ($players as $player) {
            if (empty($player['Player'])) {
                continue;
            }
            $fullName = $player['Player'];
            $arrayFullName = explode(' ', $fullName);
            $firstName = $arrayFullName[0];
            $name = $arrayFullName[1];
            $position = $player['Pos'];
            $tabTeam = explode('/', $player['Team']);
            $newPlayerTeam = $tabTeam[0];
            $replace = ['LA', 'SJ', 'TB', 'NJ'];
            $replace_to = ['LAK', 'SJS', 'TBL', 'NJD'];
            if ($newPlayerTeam != 'FLA') {
                $newPlayerTeam = str_replace($replace, $replace_to, $newPlayerTeam);
            }
            $playerTeamID = Models\Team::whereShortName($newPlayerTeam)->pluck('id');

            $playerDB = Models\Player::firstOrNew([
                'full_name' => $fullName,
                'team_id'   => $playerTeamID,
            ]);
            $playerDB->first_name = $firstName;
            $playerDB->name = $name;
            $playerDB->position = $position;
            $playerDB->year = $currentYear;
            $playerDB->save();

            $player_stats = Models\PlayersStatsYear::firstOrNew([
                'player_id' => $playerDB->id,
            ]);

            //Don't update needlessly if the player hasn't played a new game
            if ($player_stats->exists() && $player_stats->games == $player['GP']) {
                continue;
            }

            $this->savePlayerStatsDay($playerDB, $player_stats, $player);

            $player_stats->games = $player['GP'];
            $player_stats->goals = $player['G'];
            $player_stats->assists = $player['A'];
            $player_stats->points = $player['P'];
            $player_stats->plusminus = $player['+/-'];
            $player_stats->save();
        }
    }

    public function savePlayerStatsDay($playerDB, $player_stats, $player)
    {
        $player_stats_day = Models\PlayersStatsDays::firstOrNew([
            'player_id' => $playerDB->id,
            'day'       => Carbon::today(),
        ]);

        $player_stats_day->goals = $player['G'] - $player_stats->goals;
        $player_stats_day->assists = $player['A'] - $player_stats->assists;
        $player_stats_day->points = $player['P'] - $player_stats->points;
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
        return [
            ['startingPage', InputArgument::OPTIONAL, 'Stating page number to fetch.', 1],
            ['endingPage', InputArgument::OPTIONAL, 'Ending page number to fetch.', 20],
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
            ['TOI', null, InputOption::VALUE_NONE, 'Fetch by time on ice, to get all players.', null],
        ];
    }
}
