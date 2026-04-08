<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class KirimNotifikasi implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        KirimNotifikasi::dispatch()->delay(now()->addSeconds(5));
        Log::info("Job jalan bro 🔥");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
