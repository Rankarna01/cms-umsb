<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
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
        'description',
        'category_id',
        'start_date',
        'end_date',
        'time_start',
        'time_end',
        'location',
        'thumbnail', // <-- Diperbarui dari 'poster'
        'contact_person',
        'registration_url',
        'active',
        'published_at',
        'author_id',
        'document_id', // <-- Tambahan baru
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relasi ke dokumen (lampiran).
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    
    /**
     * Relasi ke penulis (author).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    /**
     * Relasi ke kategori (jika ada).
     */
    public function category(): BelongsTo
    {
        // Asumsi Anda menggunakan PostCategory juga untuk agenda
        return $this->belongsTo(PostCategory::class, 'category_id');
    }
}

