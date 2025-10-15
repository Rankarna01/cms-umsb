<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'album_id',
        'caption',
        'image_path',
        'title', // <-- TAMBAHKAN BARIS INI
    ];

    /**
     * Get the album (category) that owns the photo.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}