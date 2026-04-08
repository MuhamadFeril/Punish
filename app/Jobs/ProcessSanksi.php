<?php

namespace App\Jobs;

use App\Models\Sanksi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessSanksi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sanksiId;

    /**
     * Create a new job instance.
     */
    public function __construct($sanksiId)
    {
        $this->sanksiId = $sanksiId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $sanksi = Sanksi::find($this->sanksiId);

        if (!$sanksi) {
            Log::warning("Sanksi dengan ID {$this->sanksiId} tidak ditemukan.");
            return;
        }

        // Contoh proses: update status
        $sanksi->status = 'processed';
        $sanksi->save();

        Log::info("Sanksi ID {$this->sanksiId} berhasil diproses.");
    }
}