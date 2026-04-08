<?php

namespace App\Jobs;
use App\Models\Departemen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Divisi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $departemenId;

    /**
     * Create a new job instance.
     */
    public function __construct($departemenId)
    {
        $this->departemenId = $departemenId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $departemen = Departemen::find($this->departemenId);

        if (!$departemen) {
            Log::warning("Departemen dengan ID {$this->departemenId} tidak ditemukan.");
            return;
        }

        // Contoh proses: update status atau kirim notifikasi
        Log::info("Departemen ID {$this->departemenId} sedang diproses.");
    }
}