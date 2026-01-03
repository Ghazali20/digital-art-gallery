<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan import ini
use Illuminate\Database\Eloquent\Relations\HasMany;  // Tambahkan import ini
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d

class Artwork extends Model
{
    use HasFactory;

<<<<<<< HEAD
    // Pastikan user_id dan category_id ada di sini
=======
    /**
     * Atribut yang dapat diisi (Mass Assignable)
     */
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'is_approved',
    ];

<<<<<<< HEAD
    public function user()
=======
    /**
     * Relasi Kebalikan: Satu Artwork dimiliki oleh satu User
     * Sangat penting agar UserProfileController bisa menarik data user
     */
    public function user(): BelongsTo
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    public function category()
=======
    /**
     * Relasi: Satu Artwork memiliki satu Kategori
     */
    public function category(): BelongsTo
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d
    {
        return $this->belongsTo(Category::class);
    }

<<<<<<< HEAD
    public function contestEntries()
=======
    /**
     * Relasi: Satu Artwork bisa didaftarkan ke banyak entri kontes
     */
    public function contestEntries(): HasMany
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d
    {
        return $this->hasMany(ContestEntry::class);
    }
}