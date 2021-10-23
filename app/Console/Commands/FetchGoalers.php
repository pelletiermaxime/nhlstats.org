<?php

namespace Nhlstats\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Nhlstats\Http\Models;
use Symfony\Component\Console\Input\InputArgument;

class FetchGoalers extends Command
{
    protected $name = 'nhl:fetch-goalers';

    protected $description = 'Fetch goalers stats from espn.';

    private $guzzleClient;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->guzzleClient = new GuzzleClient();
        $goalers = $this->getGoalers();
        $this->savePlayers($goalers);
    }

    private function getGoalers()
    {
        $currentSeason = $this->argument('season') . ($this->argument('season') + 1);

        $goalersURL = "https://api.nhle.com/stats/rest/en/goalie/summary?isAggregate=false&start=0&limit=-1";
        $goalersURL .= "&cayenneExp=gameTypeId=2 and seasonId=$currentSeason";

        $res = $this->guzzleClient->get($goalersURL);
        $goalersArray = collect(json_decode($res->getBody(), true)['data']);

        $goalersArray->transform(function ($goaler) {
            return [
                "Player" => $goaler['goalieFullName'],
                "Team"   => $goaler['teamAbbrevs'],
                "GP"     => $goaler['gamesPlayed'],
                "W"      => $goaler['wins'],
                "L"      => $goaler['losses'],
                "OTL"    => $goaler['otLosses'],
                "GAA"    => $goaler['goalsAgainstAverage'],
                "GA"     => $goaler['goalsAgainst'],
                "SA"     => $goaler['shotsAgainst'],
                "Sv"     => $goaler['saves'],
                "Sv%"    => $goaler['savePct'],
                "SO"     => $goaler['shutouts'],
                "G"      => $goaler['goals'],
                "A"      => $goaler['assists'],
                "PIM"    => $goaler['penaltyMinutes'],
            ];
        });

        return $goalersArray;
    }

    private function savePlayers($goalers)
    {
        $year = $this->argument('season');
        echo "Enregistre les informations dans la bd mysql\n";
        foreach ($goalers as $goaler) {
            if (empty($goaler['Player'])) {
                continue;
            }
            $fullName = $goaler['Player'];
            $arrayFullName = explode(' ', $fullName);
            $firstName = $arrayFullName[0];
            $name = $arrayFullName[1];
            $tabTeam = explode('/', $goaler['Team']);
            $newPlayerTeam = $tabTeam[0];
            $replace = ['/\bLA\b/', '/\bSJ\b/', '/\bTB\b/', '/\bNJ\b/'];
            $replace_to = ['LAK', 'SJS', 'TBL', 'NJD'];
            $newPlayerTeam = preg_replace($replace, $replace_to, $newPlayerTeam);
            $goalerTeamID = Models\Team::whereShortName($newPlayerTeam)->where('year', $year)->pluck('id')->last();

            $goalerDB = Models\Player::firstOrNew([
                'full_name' => $fullName,
                'team_id'   => $goalerTeamID,
                'year'      => $year,
            ]);
            $goalerDB->first_name = $firstName;
            $goalerDB->name = $name;
            $goalerDB->position = 'G';
            $goalerDB->year = $this->argument('season');
            $goalerDB->save();

            $goaler_stats = Models\GoalersStatsYear::firstOrNew([
                'player_id' => $goalerDB->id,
            ]);
            $goaler_stats->games = $goaler['GP'];
            $goaler_stats->win = $goaler['W'];
            $goaler_stats->lose = $goaler['L'];
            $goaler_stats->saves = $goaler['Sv'];
            $goaler_stats->saves_pourcent = str_replace('.', '', $goaler['Sv%']);
            $goaler_stats->goals   = $goaler['G'];
            $goaler_stats->assists = $goaler['A'];
            $goaler_stats->pim     = $goaler['PIM'];
            $goaler_stats->goals_against_average = $goaler['GAA'];
            $goaler_stats->shots_against = $goaler['SA'];
            $goaler_stats->goals_against = $goaler['GA'];
            $goaler_stats->shootouts = $goaler['SO'];
            $goaler_stats->save();
        }
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
