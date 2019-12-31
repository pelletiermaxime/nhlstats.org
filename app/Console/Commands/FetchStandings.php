<?php

namespace Nhlstats\Console\Commands;

use DB;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Nhlstats\Http\Models;
use Nhlstats\Http\Repositories\PlayoffRepository;
use Symfony\Component\Console\Input\InputArgument;

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

    /** @var GuzzleClient */
    private $guzzleClient;

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->guzzleClient = new GuzzleClient();
        $teams = $this->getTeamsArray();
        $this->saveStandings($teams);
        $this->saveStandingsPositions();
        $this->generatePlayoffTeams();
    }

    private function saveStandings($teams)
    {
        Models\Standings::where('year', current_year())->delete();
        foreach ($teams as $team) {
            $teamID = Models\Team::whereName($team['Team'])->pluck('id')->last();

            Models\Standings::create([
                'team_id' => $teamID,
                'year'    => current_year(),
                'gp'      => $team['GP'],
                'w'       => $team['W'],
                'l'       => $team['L'],
                'otl'     => $team['OTL'],
                'pts'     => $team['PTS'],
                'row'     => $team['ROW'],
                'gf'      => $team['GF'],
                'ga'      => $team['GA'],
                'diff'    => $team['Diff'],
                'home'    => $team['HOME'],
                'away'    => $team['ROAD'],
                'l10'     => $team['L10'],
                'streak'  => $team['Streak'],
            ]);
        }
    }

    private function saveStandingsPositions()
    {
        $rowsStanding = [];
        // Get overall teams positions by ordering in SQL
        $query = DB::table('standings')
            ->select('standings.id')
            ->orderBy('PTS', 'DESC')
            ->orderBy('gp', 'ASC')
            ->orderBy('row', 'DESC')
            ->orderBy('w', 'DESC')
            ->where('standings.year', current_year())
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
            ->orderBy('w', 'DESC')
            ->where('standings.year', current_year())
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
            $standing->positionConference = $standing_row['positionConference'] ?? 0;
            $standing->save();
        }
    }

    private function getTeamsArray() : array
    {
        $currentSeason = $this->argument('season') . $this->argument('season') + 1;

        $standingURL = "https://statsapi.web.nhl.com/api/v1/standings?season=$currentSeason&expand=standings.record,standings.team";
        $res = $this->guzzleClient->get($standingURL);
        $standingsDivisions = collect(json_decode($res->getBody(), true)['records']);
        $standings = [];
        foreach ($standingsDivisions as $standingsDivision) {
            $standings[] = collect($standingsDivision['teamRecords'])->map(function ($standing) {
                $records = collect($standing['records']['overallRecords'])->mapWithKeys(function ($item) {
                    $record = "{$item['wins']}-{$item['losses']}";
                    if (isset($item['ot'])) {
                        $record .= '-' . $item['ot'];
                    }
                    return [$item['type'] => $record];
                });

                return [
                    'Team'   => $standing['team']['teamName'],
                    'GP'     => $standing['gamesPlayed'],
                    'W'      => $standing['leagueRecord']['wins'],
                    'L'      => $standing['leagueRecord']['losses'],
                    'ROW'    => $standing['row'],
                    'OTL'    => $standing['leagueRecord']['ot'],
                    'PTS'    => $standing['points'],
                    'GF'     => $standing['goalsScored'],
                    'GA'     => $standing['goalsAgainst'],
                    'Diff'   => $standing['goalsScored'] - $standing['goalsAgainst'],
                    'HOME'   => $records['home'],
                    'ROAD'   => $records['away'],
                    'L10'    => $records['lastTen'],
                    'Streak' => $standing['streak']['streakCode'],
                ];
            });
        }

        $standings = collect($standings)->collapse();

        return $standings->toArray();
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
        Models\PlayoffTeams::where('year', current_year())
            ->where('conference', $conference)
            ->delete();
        foreach ($games as $division) {
            foreach ($division as $game) {
                $team1 = $game['team1']->team_id;
                $team2 = $game['team2']->team_id;
                $round = 1;
                $playoffTeams = Models\PlayoffTeams::firstOrNew([
                    'team1_id'       => $team1,
                    'team1_position' => $game['team1']->positionConference,
                    'team2_id'       => $team2,
                    'team2_position' => $game['team2']->positionConference,
                    'conference'     => $conference,
                    'round'          => $round,
                    'year'           => current_year(),
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
        return [
            ['season', InputArgument::OPTIONAL, 'Season to fetch.', current_year()],
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
