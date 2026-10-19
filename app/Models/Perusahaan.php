<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'slug',
        'bidang_industri',
        'website',
        'email_hrd',
        'no_telp',
        'alamat',
        'kota',
        'deskripsi',
        'logo',
        'status_verifikasi',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan(): HasMany
    {
        return $this->hasMany(Lowongan::class);
    }

    public function lamaran(): HasManyThrough
    {
        return $this->hasManyThrough(Lamaran::class, Lowongan::class);
    }

    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'terverifikasi';
    }
}
