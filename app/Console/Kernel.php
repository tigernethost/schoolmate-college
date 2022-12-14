<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\TurnstileLog;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\AutoApprovePayments'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:run')->daily()->at('23:59');
        $schedule->command('command:logoutturnstilelog')->dailyAt('19:00');
        $schedule->command('command:logoutallclass')->dailyAt('19:00');
        $schedule->command('command:refreshsmarttoken')->everyMinute();
        $schedule->command('autoapprovepayments:run')->everyTenMinutes();
        $schedule->command('mail:paymentReminder')->dailyAt('06:00');
        $schedule->command('mail:deleteNotEnrolledStudents')->dailyAt('06:00');
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
