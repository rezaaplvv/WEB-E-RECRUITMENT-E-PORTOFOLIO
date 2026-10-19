<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';

    protected $fillable = [
        'perusahaan_id',
        'judul_lowongan',
        'slug',
        'kategori_bidang',
        'tipe_pekerjaan',
        'sistem_kerja',
        'lokasi',
        'rentang_gaji',
        'deskripsi_pekerjaan',
        'kualifikasi',
        'batas_lamaran',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'batas_lamaran' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }

    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookmarkLowongan::class, 'lowongan_id');
    }

    public function isExpired(): bool
    {
        return $this->batas_lamaran->isPast();
    }
}
