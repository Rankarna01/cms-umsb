<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    use HasFactory;

    // pakai tabel default: gallery_photos
    protected $fillable = [
        'title',
        'image_path',
        'caption',
        'taken_at',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'taken_at'  => 'datetime',
    ];

    // supaya $photo->image_url otomatis tersedia di Blade
    protected $appends = ['image_url'];

    /** Scope untuk data yang ditampilkan di publik */
    public function scopePublished($query)
    {
        return $query
            ->where('is_active', true)
            ->orderBy('sort_order')       // urut manual
            ->orderByDesc('taken_at')     // lalu terbaru
            ->orderByDesc('id');
    }

    /** Accessor url gambar */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_path) return '';
        return \Illuminate\Support\Facades\Storage::url($this->image_path);
    }
}
