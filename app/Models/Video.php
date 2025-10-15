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

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)(.{11})/', $this->video_url, $matches)) {
                    return "https://img.youtube.com/vi/{$matches[3]}/mqdefault.jpg";
                }
                return 'https://via.placeholder.com/480x360?text=Video';
            }
        );
    }

    /**
     * Accessor BARU untuk membuat URL embed secara otomatis.
     */
    protected function embedUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $videoId = null;
                if (preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)(.{11})/', $this->video_url, $matches)) {
                    $videoId = $matches[3];
                }

                if ($videoId) {
                    return "https://www.youtube.com/embed/{$videoId}?autoplay=1";
                }
                return $this->video_url; // Fallback jika bukan link YouTube
            }
        );
    }
}