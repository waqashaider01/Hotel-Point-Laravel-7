<?php

namespace App\Console;
use App\Jobs\FullSync;
use App\Jobs\AutoNoShow;
use App\Jobs\GeneratePciKey;
use App\Jobs\GetBookings;
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
         $fullsync=new FullSync;
         $generatePciKey=new GeneratePciKey;
         $autoNoShow=new AutoNoShow;
        
        $schedule->call($autoNoShow->__invoke())->dailyAt('23:57')->runInBackground();
        $schedule->call($fullsync->run())->dailyAt('00:00')->runInBackground();

        $schedule->call($generatePciKey->__invoke())->quarterly('01:10');
        // $schedule->call(new GetBookings)->name('get-bookings')->withoutOverlapping()->everyTwoMinutes()->runInBackground();
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
