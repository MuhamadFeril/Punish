<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SanksiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sanksi;

    public function __construct($sanksi)
    {
        $this->sanksi = $sanksi;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Sanksi Baru',
            'message' => "Sanksi '{$this->sanksi->jenis_sanksi}' telah diterbitkan untuk pelanggaran Anda.",
            'sanksi_id' => $this->sanksi->id,
            'pelanggaran_id' => $this->sanksi->pelanggaran_id,
            'link' => route('sanksi.show', $this->sanksi->id),
        ];
    }
}
