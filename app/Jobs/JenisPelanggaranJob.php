<?php
namespace App\Jobs;
use App\Models\Jenispelanggaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class JenisPelanggaranJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jenisPelanggaranId;

    /**
     * Create a new job instance.
     */
    public function __construct($jenisPelanggaranId)
    {
        $this->jenisPelanggaranId = $jenisPelanggaranId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $jenisPelanggaran = Jenispelanggaran::find($this->jenisPelanggaranId);

        if (!$jenisPelanggaran) {
            Log::warning("Jenis Pelanggaran dengan ID {$this->jenisPelanggaranId} tidak ditemukan.");
            return;
        }

        // Contoh proses: update status atau kirim notifikasi
        Log::info("Jenis Pelanggaran ID {$this->jenisPelanggaranId} sedang diproses.");
    }
}