<?php

namespace App\Console;

use App\Models\Dormitory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('create:invoice')
        //     ->everyMinute()	
        //     ->timezone('Asia/Bangkok');

        $dormitory = Dormitory::first();

            if ($dormitory) {
                $schedule->command('create:invoice')
                    ->monthlyOn($dormitory->bill_date, '16:00')
                    ->timezone('Asia/Bangkok');
                $schedule->command('publish:invoice')
                    ->monthlyOn($dormitory->bill_date, '20:00')
                    ->timezone('Asia/Bangkok');
                $schedule->command('check:invoice')
                    ->monthlyOn($dormitory->payment_due_date, '19:00')
                    ->timezone('Asia/Bangkok');
            }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
