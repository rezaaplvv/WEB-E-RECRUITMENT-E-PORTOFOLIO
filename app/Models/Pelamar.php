<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelamar extends Model
{
    use HasFactory;

    protected $table = 'pelamar';

    protected $fillable = [
        'user_id',
        'nim',
        'angkatan',
        'ipk',
        'no_telp',
        'alamat',
        'headline',
        'ringkasan_profil',
        'keahlian',
        'link_github',
        'link_linkedin',
        'link_portofolio_web',
        'file_cv',
    ];

    protected function casts(): array
    {
        return [
            'ipk' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portofolio(): HasMany
    {
        return $this->hasMany(PortofolioProyek::class, 'pelamar_id');
    }

    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'pelamar_id');
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookmarkLowongan::class, 'pelamar_id');
    }

    public function hasBookmarked(int $lowonganId): bool
    {
        return $this->bookmarks()->where('lowongan_id', $lowonganId)->exists();
    }

    /**
     * Get array of skills from comma-separated or text keahlian.
     */
    public function getSkillsArrayAttribute(): array
    {
        if (empty($this->keahlian)) {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $this->keahlian)));
    }
}
