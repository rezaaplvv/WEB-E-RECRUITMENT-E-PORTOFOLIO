<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * User's Perusahaan profile if role is perusahaan.
     */
    public function perusahaan(): HasOne
    {
        return $this->hasOne(Perusahaan::class);
    }

    /**
     * User's Pelamar profile if role is pelamar.
     */
    public function pelamar(): HasOne
    {
        return $this->hasOne(Pelamar::class);
    }

    /**
     * User's in-app notifications.
     */
    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class)->latest();
    }

    public function unreadNotifikasiCount(): int
    {
        return $this->hasMany(Notifikasi::class)->where('is_read', false)->count();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPerusahaan(): bool
    {
        return $this->role === 'perusahaan';
    }

    public function isPelamar(): bool
    {
        return $this->role === 'pelamar';
    }
}
