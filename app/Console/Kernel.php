<?php

namespace App\Console;

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
        // Shared hosting queue worker: processes pending background jobs and stops when empty
        $schedule->command('queue:work --stop-when-empty --tries=3 --timeout=60')->everyMinute()->withoutOverlapping();

        // SEO Sitemap daily generation
        $schedule->command('sitemap:generate')->dailyAt('02:00');

        // Prune old telemetry every Sunday to maintain lean database size
        $schedule->command('visitors:prune --days=60')->weeklyOn(0, '03:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
