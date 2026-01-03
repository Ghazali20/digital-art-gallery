<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'is_active',
    ];

    // Accessor untuk menentukan status aktif asli (menggabungkan checkbox & timeline)
    public function getStatusAktifAttribute()
    {
        $now = now();
        // Aktif jika dicentang DAN waktu sekarang belum melewati end_date
        if ($this->is_active && $now->lt($this->end_date)) {
            return 'Aktif';
        }
        return 'Tidak Aktif';
    }

    public function entries()
    {
        return $this->hasMany(ContestEntry::class);
    }
}