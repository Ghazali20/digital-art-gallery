<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    // Pastikan user_id dan category_id ada di sini
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contestEntries()
    {
        return $this->hasMany(ContestEntry::class);
    }
}