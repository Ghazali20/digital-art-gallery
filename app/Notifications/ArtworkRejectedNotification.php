<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ArtworkRejectedNotification extends Notification
{
    use Queueable;

    protected $artworkTitle;
    protected $reason;

    public function __construct($artworkTitle, $reason)
    {
        $this->artworkTitle = $artworkTitle;
        $this->reason = $reason;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Karya "' . $this->artworkTitle . '" ditolak. Alasan: ' . $this->reason,
            'url' => route('artworks.index'), // Arahkan user ke daftar karya mereka
        ];
    }
}