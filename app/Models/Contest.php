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

    /**
     * Relasi ke ContestEntry: Satu Kontes memiliki banyak Entri.
     */
    public function entries()
    {
        return $this->hasMany(ContestEntry::class);
    }
}