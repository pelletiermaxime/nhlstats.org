<?php

namespace Nhlstats\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'Nhlstats\Console\Commands\FetchStandings',
        'Nhlstats\Console\Commands\FetchPlayers',
        'Nhlstats\Console\Commands\FetchGoalers',
        'Nhlstats\Console\Commands\FetchGameScores',
        'Nhlstats\Console\Commands\FetchPlayersInfo',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        /********* Fetch scores *********/
        $schedule->command('nhl:fetch-scores')->cron('*/5 18-24 * * *');

        // Late games in the west
        $schedule->command('nhl:fetch-scores --yesterday')->cron('*/5 0-1 * * *');

        // Weekend games
        $schedule->command('nhl:fetch-scores')->cron('*/5 13-17 * * 6-7');

        // Futur games
        $schedule->command('nhl:fetch-scores')->dailyAt('5:00');

        /********* Fetch standings *********/
        //After weekend games
        $schedule->command('nhl:fetch-standings')->cron('0 17 * * 6-7');

        $schedule->command('nhl:fetch-standings')->dailyAt('5:30');
        $schedule->command('nhl:fetch-standings')->dailyAt('6:30');
        $schedule->command('nhl:fetch-standings')->dailyAt('22:00');
        $schedule->command('nhl:fetch-standings')->dailyAt('23:00');

        /********* Fetch player stats *********/
        $schedule->command('nhl:fetch-players')->dailyAt('6:13');
        $schedule->command('nhl:fetch-players --TOI')->dailyAt('6:23');

        $schedule->command('nhl:fetch-players')->dailyAt('9:01');
        $schedule->command('nhl:fetch-players --TOI')->dailyAt('9:12');

        /********* Fetch goaler stats *********/
        $schedule->command('nhl:fetch-goalers')->dailyAt('6:40');
    }
}
