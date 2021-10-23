<?php

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Nhlstats\Http\Models\Division;
use Nhlstats\Http\Models\Standings;
use Nhlstats\Http\Models\Team;

class DivisionsTableSeeder extends Seeder
{
    public function run()
    {
        $this->client = new Client();

        $standingsURL = "https://statsapi.web.nhl.com/api/v1/standings";
        $standingsURL .= "?expand=standings.team,standings.division,standings.conference&season=%s";

        // $years = range(2010, 2016);
        $years = [config('nhlstats.currentYear')];
        foreach ($years as $year) {
            $divisions = [];
            $yearAndNext = $year . $year + 1;
            $standingsYearURL = sprintf($standingsURL, $yearAndNext);
            $conferences = ['Eastern' => 'EAST', 'Western' => 'WEST'];

            $res = $this->client->get($standingsYearURL);
            $standings = json_decode($res->getBody(), true);
            foreach ($standings['records'] as $record) {
                $divisions[] = [
                    strtoupper($record['division']['name']),
                    $conferences[$record['division']['conference']['name']],
                ];
            }

            $this->insert($divisions, $year);
        }
    }

    private function insert($divisions, $year)
    {
        Standings::where('year', $year)->delete();
        Team::where('year', $year)->delete();
        Division::where('year', $year)->delete();

        $division = new Division();
        $timestamp = $division->freshTimestamp();

        foreach ($divisions as $division) {
            $divisionInsert[] = [
                'division' => $division[0],
                'conference' => $division[1],
                'year' => $year,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        DB::table('divisions')->insert($divisionInsert);
    }
}
