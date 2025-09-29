<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'video_url',
        'author_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Accessor untuk mendapatkan URL thumbnail YouTube secara otomatis.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $videoId = null;
                if (preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)(.{11})/', $this->video_url, $matches)) {
                    $videoId = $matches[3];
                }

                if ($videoId) {
                    return "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg";
                }

                // Gambar placeholder jika bukan link YouTube
                return 'https://via.placeholder.com/480x360?text=Video';
            }
        );
    }
}
