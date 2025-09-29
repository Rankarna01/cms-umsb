<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category_id',
        'thumbnail',
        'headline',
        'active',
        'hits',
        'published_at',
        'author_id',
        'status',
    ];

    // Relasi ke tabel kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class);
    }

    // Relasi ke tabel user (author)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}