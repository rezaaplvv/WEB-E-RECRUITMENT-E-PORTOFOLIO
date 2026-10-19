<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortofolioProyek extends Model
{
    use HasFactory;

    protected $table = 'portofolio_proyek';

    protected $fillable = [
        'pelamar_id',
        'judul_proyek',
        'kategori',
        'tech_stack',
        'deskripsi',
        'link_github',
        'link_demo',
    ];

    public function pelamar(): BelongsTo
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id');
    }

    /**
     * Get array of tech stack items.
     */
    public function getTechStackArrayAttribute(): array
    {
        if (empty($this->tech_stack)) {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $this->tech_stack)));
    }
}
