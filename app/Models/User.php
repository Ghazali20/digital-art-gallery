<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     * Pastikan field profil baru terdaftar di sini.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',    // Tambahan baru
        'bio',              // Tambahan baru
        'instagram_handle', // Tambahan baru
        'portfolio_link',    // Tambahan baru
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELASI: Satu User memiliki banyak Karya Seni (Artworks)
     */
    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }
}