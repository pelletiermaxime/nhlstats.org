<?php

namespace Nhlstats\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Nhlstats\Http\Models;
use Symfony\Component\Console\Input\InputArgument;

class FetchPlayers extends Command
{
    protected $name = 'nhl:fetch-players';

    protected $description = 'Fetch player stats from espn.';

    private $guzzleClient;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->guzzleClient = new GuzzleClient();
        $players = $this->getPlayers();
        $this->savePlayers($players);
    }

    private function getPlayers()
    {
        $currentSeason = $this->argument('season') . $this->argument('season') + 1;
        $playersURL = "http://www.nhl.com/stats/rest/skaters?reportType=basic&reportName=skatersummary";
        $playersURL .= "&cayenneExp=seasonId=$currentSeason and gameTypeId=2";

        $res = $this->guzzleClient->get($playersURL);
        $playersArray = collect(json_decode($res->getBody(), true)['data']);

        $playersArray->transform(function ($player) {
            return [
                "+/-"    => $player['plusMinus'],
                "A"      => $player['assists'],
                "G"      => $player['goals'],
                "GP"     => $player['gamesPlayed'],
                "P"      => $player['points'],
                "PIM"    => $player['penaltyMinutes'],
                "Player" => $player['playerName'],
                "Pos"    => $player['playerPositionCode'],
                "Team"   => $player['playerTeamsPlayedFor'],
            ];
        });

        return $playersArray;
    }

    private function savePlayers($players)
    {
        echo "Enregistre les informations dans la bd mysql\n";
        $year = $this->argument('season');
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
            $replace = ['/\bLA\b/', '/\bSJ\b/', '/\bTB\b/', '/\bNJ\b/'];
            $replace_to = ['LAK', 'SJS', 'TBL', 'NJD'];
            $newPlayerTeam = preg_replace($replace, $replace_to, $newPlayerTeam);
            $playerTeamID = Models\Team::whereShortName($newPlayerTeam)->where('year', $year)->pluck('id')->last();

            $playerDB = Models\Player::firstOrNew([
                'full_name' => $fullName,
                'team_id'   => $playerTeamID,
                'year'      => $year,
            ]);
            $playerDB->first_name = $firstName;
            $playerDB->name = $name;
            $playerDB->position = $position;
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
            $player_stats->pim = $player['PIM'];
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

    protected function getArguments() : array
    {
        return [
            ['season', InputArgument::OPTIONAL, 'Season to fetch.', current_year()],
        ];
    }

    protected function getOptions() : array
    {
        return [];
    }
}
