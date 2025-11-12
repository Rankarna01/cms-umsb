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
        'tanggal',          // <-- DIUBAH (dari start_date, end_date, dll)
        'thumbnail',
        'active',
        'author_id',
        'document_id',
        // Kolom 'category_id', 'start_date', 'end_date', 'time_start',
        // 'time_end', 'location', 'contact_person', 'registration_url',
        // 'published_at' semuanya DIHAPUS dari $fillable
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'date', // <-- DIUBAH (dari start_date & end_date)
        'active' => 'boolean', // <-- Tambahan bagus untuk switch 'active'
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
     * Relasi ke kategori (DIHAPUS).
     * Kita hapus relasi ini karena kolom 'category_id' sudah dihapus.
     */
    // public function category(): BelongsTo ... (Fungsi ini dihapus)
}