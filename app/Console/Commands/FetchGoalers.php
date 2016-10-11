<?php

namespace Nhlstats\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Nhlstats\Http\Models;
use Symfony\Component\Console\Input\InputArgument;

class FetchGoalers extends Command
{
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
        $currentSeason = $this->argument('season') . $this->argument('season') + 1;
        $goalersURL = "http://www.nhl.com/stats/rest/grouped/goalies/season/goaliesummary";
        $goalersURL .= "?cayenneExp=seasonId=$currentSeason and gameTypeId=2 and playerPositionCode=\"G\"";

        $res = $this->guzzleClient->get($goalersURL);
        $goalersArray = collect(json_decode($res->getBody(), true)['data']);

        $goalersArray->transform(function ($goaler) {
            return [
                "Player" => $goaler['playerName'],
                "Team"   => $goaler['playerTeamsPlayedFor'],
                "GP"     => $goaler['gamesPlayed'],
                "W"      => $goaler['wins'],
                "L"      => $goaler['losses'],
                "OTL"    => $goaler['otLosses'],
                "GAA"    => $goaler['goalsAgainstAverage'],
                "GA"     => $goaler['goalsAgainst'],
                "SA"     => $goaler['shotsAgainst'],
                "Sv"     => $goaler['saves'],
                "Sv%"    => $goaler['savePctg'],
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
            $goalerTeamID = Models\Team::whereShortName($newPlayerTeam)->pluck('id')->last();

            $goalerDB = Models\Player::firstOrNew([
                'full_name' => $fullName,
                'team_id'   => $goalerTeamID,
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

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['season', InputArgument::OPTIONAL, 'Season to fetch.', config('nhlstats.currentYear')],
        ];
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
