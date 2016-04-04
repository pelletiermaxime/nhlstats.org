<?php

namespace Nhlstats\Console\Commands;

use DB;
use Goutte\Client;
use Illuminate\Console\Command;
use Nhlstats\Http\Models;
use Nhlstats\Http\Repositories\PlayoffRepository;

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
     * @var Client Goutte client
     */
    private $client;

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->client = new Client();
        $teams = $this->getTeamsArray();
        $this->saveStandings($teams);
        $this->saveStandingsPositions();
        $this->generatePlayoffTeams();
    }

    private function saveStandings($teams)
    {
        Models\Standings::where('year', config('nhlstats.currentYear'))->delete();
        foreach ($teams as $team) {
            $tabTeam = explode('-', $team['Team']);
            if (isset($tabTeam[1])) {
                $teamName = trim($tabTeam[1]);
            } else {
                $teamName = $team['Team'];
            }
            if (strpos($team['Team'], 'NY') !== false) {
                $teamNY = str_replace('NY ', '', $teamName);
                $team_id = Models\Team::whereName($teamNY)->pluck('id');
            } else {
                $team_id = Models\Team::whereCity($teamName)->pluck('id');
            }
            Models\Standings::create([
                'team_id' => $team_id,
                'year'    => config('nhlstats.currentYear'),
                'gp'      => $team['GP'],
                'w'       => $team['W'],
                'l'       => $team['L'],
                'otl'     => $team['OTL'],
                'pts'     => $team['PTS'],
                'row'     => $team['ROW'],
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

    private function saveStandingsPositions()
    {
        // Get overall teams positions by ordering in SQL
        $query = DB::table('standings')
            ->select('standings.id')
            ->orderBy('PTS', 'DESC')
            ->orderBy('gp', 'ASC')
            ->orderBy('row', 'DESC')
            ->where('standings.year', config('nhlstats.currentYear'))
        ;
        $standings = $query->get();

        foreach ($standings as $position => $row) {
            $rowsStanding[$row->id]['positionOverall'] = ++$position;
        }

        // Get conference teams positions by ordering in SQL
        $query = DB::table('standings')
            ->select(['standings.id', 'conference'])
            ->join('teams', 'teams.id', '=', 'standings.team_id')
            ->join('divisions', 'divisions.id', '=', 'teams.division_id')
            ->orderBy('conference', 'ASC')
            ->orderBy('PTS', 'DESC')
            ->orderBy('gp', 'ASC')
            ->orderBy('row', 'DESC')
            ->where('standings.year', config('nhlstats.currentYear'))
        ;
        $standings = $query->get();
        $previousConference = '';
        $position = 1;

        foreach ($standings as $row) {
            if ($row->conference != $previousConference) {
                $position = 1;
            }
            $rowsStanding[$row->id]['positionConference'] = $position;
            ++$position;
            $previousConference = $row->conference;
        }

        // Save in the DB so we don't have to do all that ordering ever again
        foreach ($rowsStanding as $standing_id => $standing_row) {
            $standing = Models\Standings::find($standing_id);
            $standing->positionOverall = $standing_row['positionOverall'];
            $standing->positionConference = $standing_row['positionConference'];
            $standing->save();
        }
    }

    private function getTeamsArray()
    {
        $params = ['Team', 'GP', 'W', 'L', 'OTL', 'PTS', 'ROW', 'SOW', 'SOL', 'HOME',
            'ROAD', 'GF', 'GA', 'Diff', 'L10', 'Streak', ];
        $paramCount = count($params);

        $crawler = $this->client->request('GET', 'http://espn.go.com/nhl/standings');
        $cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(['_text']);

        $noParametre = 0;
        $noTeam = 1;
        foreach ($cells as $cell) {
            $team[$noTeam][$params[$noParametre]] = trim($cell);
            ++$noParametre;
            if ($noParametre >= $paramCount) {
                //Next row of table, so increment team
                $noParametre = 0;
                ++$noTeam;
            }
        }

        $params = ['Team', 'GP', 'W', 'L', 'OTL', 'PTS', 'PPG', 'PPO', 'PPP', 'PPGA', 'PPOA', 'PKP'];
        $paramCount = count($params);

        $crawler = $this->client->request('GET', 'http://espn.go.com/nhl/standings/_/type/expanded');
        $cells = $crawler->filter('tr.evenrow td, tr.oddrow td')->extract(['_text']);

        $noParametre = 0;
        $noTeam = 1;
        foreach ($cells as $cell) {
            $team[$noTeam][$params[$noParametre]] = trim($cell);
            ++$noParametre;
            if ($noParametre >= $paramCount) {
                //Next row of table, so increment team

                $noParametre = 0;
                ++$noTeam;
            }
        }

        return $team;
    }

    private function generatePlayoffTeams()
    {
        $playoff = app(PlayoffRepository::class);

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
        Models\PlayoffTeams::where('year', config('nhlstats.currentYear'))
            ->where('conference', $conference)
            ->delete();
        foreach ($games as $division) {
            foreach ($division as $game) {
                $team1 = $game['team1']->team_id;
                $team2 = $game['team2']->team_id;
                $conference = $conference;
                $round = 1;
                $playoffTeams = Models\PlayoffTeams::firstOrNew([
                    'team1_id'       => $team1,
                    'team1_position' => $game['team1']->positionConference,
                    'team2_id'       => $team2,
                    'team2_position' => $game['team2']->positionConference,
                    'conference'     => $conference,
                    'round'          => $round,
                    'year'           => config('nhlstats.currentYear'),
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
