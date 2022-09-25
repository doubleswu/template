<?php

namespace App\Console;

use App\Console\Commands\InitDb;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $suffix = date('Y-m-d');
        $schedule->command('doubleswu:doubleswu')->dailyAt('12:00')
            ->appendOutputTo('storage/logs/doubleswu/' . $suffix . '.log');
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

//        require base_path('routes/console.php');
    }
}
