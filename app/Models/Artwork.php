<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        // 'contest_id' dihapus
        'title',
        'description',
        'image_path',
        'is_approved',
    ];

    // Relasi: Karya Seni dimiliki oleh satu User (Seniman)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Karya Seni termasuk dalam satu Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Satu Karya Seni dapat menjadi Entri di banyak kontes.
    public function contestEntries()
    {
        return $this->hasMany(ContestEntry::class);
    }

    // === RELASI PERBAIKAN UNTUK LIKE (DIHAPUS) ===
    // public function likers()
    // {
    //     return $this->belongsToMany(User::class, 'likes');
    // }

    // public function isLikedByUser()
    // {
    //     if (Auth::check()) {
    //         return $this->likers()->where('user_id', Auth::id())->exists();
    //     }
    //     return false;
    // }
    // =============================
}