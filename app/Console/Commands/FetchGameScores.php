<?php

namespace Nhlstats\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Nhlstats\Http\Models;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class FetchGameScores extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nhl:fetch-scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch game scores from espn.';

    private $fetchDate = '';

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
        if ($this->option('yesterday') === true) {
            $this->fetchDate = Carbon::yesterday()->format('Y-m-d');
        } else {
            $this->fetchDate = $this->argument('date');
        }

        $games = $this->getScoresArray();
        $this->saveGameScores($games);
    }

    private function getScoresArray()
    {
        $date = Carbon::parse($this->fetchDate)->format('Y-m-d');

        // $gameDayURL = "http://scores.espn.go.com/nhl/scoreboard?date=$dateESPN";
        $gameDayURL = "https://statsapi.web.nhl.com/api/v1/schedule?startDate=$date&endDate=$date";
        $gameDayURL .= "&expand=schedule.teams,schedule.linescore,schedule.decisions,schedule.scoringplays";

        $res = $this->client->get($gameDayURL);
        $gamesToday = json_decode($res->getBody());
        $gamesToday = $gamesToday->dates[0]->games;

        foreach ($gamesToday as $g) {
            $game = [];
            $score = $g->linescore;

            $game['team1'] = $score->teams->home->team->name;
            $game['team2'] = $score->teams->away->team->name;

            for ($period=0; $period <= 3; $period++) {
                $realPeriod = $period + 1;

                if ($period == 3) {
                    $realPeriod = 'OT';
                }

                $game["score1_$realPeriod"] = $game["score2_$realPeriod"] = -1;

                if (isset($score->periods[$period])) {
                    $periodScore = $score->periods[$period];


                    $game["score1_$realPeriod"] = $periodScore->home->goals;
                    $game["score2_$realPeriod"] = $periodScore->away->goals;
                }
            }

            $game['score1_T'] = $g->teams->home->score;
            $game['score2_T'] = $g->teams->away->score;

            $games[] = $game;
        }

        return $games;
    }

    private function saveGameScores($games)
    {
        $dateFetched = $this->fetchDate;

        foreach ($games as $game) {
            $team1_id = Models\Team::whereRaw("CONCAT(city, ' ', name) = '{$game['team1']}'")->pluck('id');
            $team2_id = Models\Team::whereRaw("CONCAT(city, ' ', name) = '{$game['team2']}'")->pluck('id');

            $gameDB = Models\GameScores::firstOrNew([
                'date_game' => $dateFetched,
                'team1_id'  => $team1_id,
                'team2_id'  => $team2_id,
            ]);
            $gameDB->score1_1 = $game['score1_1'];
            $gameDB->score1_2 = $game['score1_2'];
            $gameDB->score1_3 = $game['score1_3'];
            $gameDB->score1_OT = $game['score1_OT'];
            // $gameDB->score1_SO = $game['score1_SO'];
            $gameDB->score1_T = $game['score1_T'];

            $gameDB->score2_1 = $game['score2_1'];
            $gameDB->score2_2 = $game['score2_2'];
            $gameDB->score2_3 = $game['score2_3'];
            $gameDB->score2_OT = $game['score2_OT'];
            // $gameDB->score2_SO = $game['score2_SO'];
            $gameDB->score2_T = $game['score2_T'];

            $gameDB->year = \Config::get('nhlstats.currentYear');
            $gameDB->save();
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
            ['date', InputArgument::OPTIONAL, 'Date to fetch scores in format Ymd.', Carbon::today()->format('Y-m-d')],
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
            ['yesterday', null, InputOption::VALUE_NONE, 'Fetch yesterday', null],
        ];
    }
}
