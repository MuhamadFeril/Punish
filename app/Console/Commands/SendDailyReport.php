<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendDailyReport extends Command
{
    protected $signature = 'report:send-daily';
    protected $description = 'Kirim laporan harian ke admin';

    public function handle(): void
    {
        // Logika laporan di sini
        $this->info('Laporan berhasil dikirim!');
    }
    
}