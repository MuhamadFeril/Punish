<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PelanggaranNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pelanggaran;

    public function __construct($pelanggaran)
    {
        $this->pelanggaran = $pelanggaran;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $reportedBy = $this->pelanggaran->reportedBy->name ?? 'Sistem';
        $employeeName = $this->pelanggaran->karyawan->nama_karyawan ?? 'karyawan';
        $jenisPelanggaran = $this->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'pelanggaran';

        return [
            'title' => 'Pelanggaran Baru',
            'message' => "{$employeeName} dilaporkan untuk {$jenisPelanggaran} oleh {$reportedBy}.",
            'pelanggaran_id' => $this->pelanggaran->id,
            'karyawan_id' => $this->pelanggaran->karyawan_id,
            'reported_by' => $reportedBy,
            'link' => route('pelanggaran.show.web', $this->pelanggaran->id),
        ];
    }
}
