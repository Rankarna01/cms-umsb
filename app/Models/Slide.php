<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'layout',
        'link_url',
        'button_text',
        'sort_order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function images(): HasMany
    {
        // Urutkan konsisten
        return $this->hasMany(SlideImage::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
