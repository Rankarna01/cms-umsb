<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'active',
        'published_at',
        'author_id',
        'thumbnail', // <-- Kolom baru
        'document_id', // <-- Kolom baru
        // 'attachment_ids' // (Kita ganti ini dengan document_id)
    ];

    /**
     * Relasi ke dokumen (lampiran).
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    
    /**
     * Relasi ke kategori (jika belum ada).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    /**
     * Relasi ke penulis (jika belum ada).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
