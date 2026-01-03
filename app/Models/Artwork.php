<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan import ini
use Illuminate\Database\Eloquent\Relations\HasMany;  // Tambahkan import ini

class Artwork extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi (Mass Assignable)
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'is_approved',
    ];

    /**
     * Relasi Kebalikan: Satu Artwork dimiliki oleh satu User
     * Sangat penting agar UserProfileController bisa menarik data user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Artwork memiliki satu Kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Satu Artwork bisa didaftarkan ke banyak entri kontes
     */
    public function contestEntries(): HasMany
    {
        return $this->hasMany(ContestEntry::class);
    }
}