<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookmarkLowongan extends Model
{
    use HasFactory;

    protected $table = 'bookmark_lowongan';

    protected $fillable = [
        'pelamar_id',
        'lowongan_id',
    ];

    /**
     * Get the applicant that bookmarked the job vacancy.
     */
    public function pelamar(): BelongsTo
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id');
    }

    /**
     * Get the job vacancy that was bookmarked.
     */
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }
}
