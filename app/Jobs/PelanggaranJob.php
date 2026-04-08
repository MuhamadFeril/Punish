<?php
namespace App\Jobs;

use App\Models\Pelanggaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PelanggaranJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pelanggaranId;

    /**
     * Create a new job instance.
     */
    public function __construct($pelanggaranId)
    {
        $this->pelanggaranId = $pelanggaranId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pelanggaran = Pelanggaran::find($this->pelanggaranId);

        if (!$pelanggaran) {
            Log::warning("Pelanggaran dengan ID {$this->pelanggaranId} tidak ditemukan.");
            return;
        }

        // Contoh proses: update status atau kirim notifikasi
        Log::info("Pelanggaran ID {$this->pelanggaranId} sedang diproses.");
    }
}