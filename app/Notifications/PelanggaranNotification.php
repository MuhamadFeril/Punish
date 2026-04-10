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
        return [
            'title' => 'Pelanggaran Baru',
            'message' => "Pelanggaran baru telah dilaporkan oleh {$this->pelanggaran->karyawan->nama_karyawan}",
            'pelanggaran_id' => $this->pelanggaran->id,
            'karyawan_id' => $this->pelanggaran->karyawan_id,
            'link' => route('pelanggaran.show.web', $this->pelanggaran->id),
        ];
    }
}
