<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
// use Illuminate\Support\Facades\Queue;
// If you want to schedule the job, import it and pass a valid sanksi ID:
// use App\Jobs\ProcessSanksi;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// schedule a command every five seconds
Schedule::command('report:send-daily')->everyFiveSeconds();

// Example: schedule a job with a valid ID (uncomment and provide $sanksiId)
// Schedule::job(new ProcessSanksi($sanksiId))->everyFiveSeconds();