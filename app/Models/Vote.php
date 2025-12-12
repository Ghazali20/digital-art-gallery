<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'contest_entry_id',
        'user_id',
    ];

    /**
     * Relasi balik ke ContestEntry yang di-vote.
     * Didefinisikan secara eksplisit untuk menghindari pencarian 'contests_entry_id'.
     */
    public function contestEntry()
    {
        return $this->belongsTo(ContestEntry::class, 'contest_entry_id'); // <-- Perbaikan di sini
    }

    /**
     * Relasi balik ke User (pemberi suara).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}