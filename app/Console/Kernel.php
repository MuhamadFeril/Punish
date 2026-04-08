<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\TestFileQueueJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // register custom commands here if any
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Example: dispatch a test job every minute (adjust as needed)
      $schedule->call(function () {
            Cache::flush();
            Log::info("Sistem: Cache telah dibersihkan otomatis.");
        })->everyFiveSeconds();

     
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
