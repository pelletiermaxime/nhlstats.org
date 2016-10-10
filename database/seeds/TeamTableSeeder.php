<?php

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Nhlstats\Http\Models\Division;
use Nhlstats\Http\Models\Team;

class TeamTableSeeder extends Seeder
{
    public function run()
    {
        $this->client = new Client();

        $standingsURL = "https://statsapi.web.nhl.com/api/v1/standings";
        $standingsURL .= "?expand=standings.team&season=%s";

        $years = range(2010, 2016);
        foreach ($years as $year) {
            $divisions = Division::where('year', $year)->select(['id', 'division'])->get()->keyBy('division');
            $teams = [];
            $yearAndNext = $year . $year + 1;
            $standingsYearURL = sprintf($standingsURL, $yearAndNext);

            $res = $this->client->get($standingsYearURL);
            $standings = json_decode($res->getBody(), true);
            foreach ($standings['records'] as $record) {
                foreach ($record['teamRecords'] as $teamRecord) {
                    $team = $teamRecord['team'];
                    $teams[] = [
                        $team['abbreviation'],
                        $team['locationName'],
                        $team['teamName'],
                        $divisions[$record['division']['name']]['id'],
                    ];
                }
            }

            $this->insert($teams, $year);
        }
    }

    private function insert($teams, $year)
    {
        Team::where('year', $year)->delete();

        $team = new Team();
        $timestamp = $team->freshTimestamp();

        foreach ($teams as $team) {
            $teamsInsert[] = [
                'short_name'  => $team[0],
                'city'        => $team[1],
                'name'        => $team[2],
                'year'        => $year,
                'created_at'  => $timestamp,
                'updated_at'  => $timestamp,
                'division_id' => $team[3],
            ];
        }

        DB::table('teams')->insert($teamsInsert);
    }
}
