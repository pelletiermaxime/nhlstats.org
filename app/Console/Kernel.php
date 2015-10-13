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
        $schedule->command('inspire')
                 ->hourly();
    }
}
