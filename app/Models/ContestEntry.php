<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'contest_id',
        'artwork_id',
    ];

    /**
     * Relasi balik ke Kontes.
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    /**
     * Relasi balik ke Artwork.
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    /**
     * Relasi ke Votes: Setiap Entri memiliki banyak Votes.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}