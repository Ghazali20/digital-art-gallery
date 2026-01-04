<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ArtworkApprovedNotification extends Notification
{
    use Queueable;

    protected $artwork;

    /**
     * Membuat instance notifikasi baru dan menerima data karya.
     */
    public function __construct($artwork)
    {
        $this->artwork = $artwork;
    }

    /**
     * Menentukan channel pengiriman. Kita menggunakan 'database'.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data yang akan disimpan di kolom 'data' pada tabel notifications.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Selamat! Karya Anda "' . $this->artwork->title . '" telah disetujui oleh Admin.',
            'artwork_id' => $this->artwork->id,
            'image_path' => $this->artwork->image_path,
            'url' => route('artworks.show', $this->artwork->id),
        ];
    }
}