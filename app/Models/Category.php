<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tambahkan properti $fillable agar data bisa diisi (store/update)
    protected $fillable = [
        'name',
        'slug',
    ];

    // Relasi: Satu Kategori memiliki banyak Karya Seni
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }
}