<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';

    protected $fillable = [
        'kode_lamaran',
        'lowongan_id',
        'pelamar_id',
        'cv_snapshot',
        'github_snapshot',
        'surat_lamaran',
        'status_lamaran',
        'jadwal_interview',
        'metode_interview',
        'link_atau_lokasi_interview',
        'catatan_hrd',
    ];

    protected function casts(): array
    {
        return [
            'jadwal_interview' => 'datetime',
        ];
    }

    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    public function pelamar(): BelongsTo
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id');
    }

    /**
     * Generate unique application code REC-2026-XXXX.
     */
    public static function generateKodeLamaran(): string
    {
        do {
            $code = 'REC-2026-'.strtoupper(bin2hex(random_bytes(2)));
        } while (static::where('kode_lamaran', $code)->exists());

        return $code;
    }

    /**
     * Get human-friendly Indonesian label for status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_lamaran) {
            'dilamar' => 'Dilamar',
            'dilihat' => 'Dilihat HRD',
            'interview' => 'Tahap Interview',
            'diterima' => 'Diterima Bekerja',
            'ditolak' => 'Tidak Lolos',
            default => ucfirst($this->status_lamaran),
        };
    }

    /**
     * Get badge styling classes for status.
     */
    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status_lamaran) {
            'dilamar' => 'bg-slate-100 text-slate-700 border border-slate-200',
            'dilihat' => 'bg-blue-50 text-blue-700 border border-blue-200',
            'interview' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'diterima' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            'ditolak' => 'bg-rose-50 text-rose-700 border border-rose-200',
            default => 'bg-slate-100 text-slate-700 border border-slate-200',
        };
    }
}
