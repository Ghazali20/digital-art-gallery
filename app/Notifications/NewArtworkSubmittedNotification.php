<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewArtworkSubmittedNotification extends Notification
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
     * Data yang akan disimpan di database untuk dilihat oleh Admin.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Karya baru diunggah: "' . $this->artwork->title . '" oleh ' . $this->artwork->user->name,
            'artwork_id' => $this->artwork->id,
            'url' => route('admin.moderation.index'), // Mengarahkan Admin ke halaman moderasi
        ];
    }
}