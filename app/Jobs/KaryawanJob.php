<?php

namespace App\Jobs;

use App\Models\Karyawan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class KaryawanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $karyawanId;

    /**
     * Create a new job instance.
     */
    public function __construct($karyawanId)
    {
        $this->karyawanId = $karyawanId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $karyawan = Karyawan::find($this->karyawanId);

        if (!$karyawan) {
            Log::warning("Karyawan dengan ID {$this->karyawanId} tidak ditemukan.");
            return;
        }

        // Contoh proses: update status atau kirim notifikasi
        Log::info("Karyawan ID {$this->karyawanId} sedang diproses.");
    }
}   