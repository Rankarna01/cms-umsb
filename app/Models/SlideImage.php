<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlideImage extends Model
{
    use HasFactory;

    protected $fillable = ['slide_id', 'image_path', 'sort_order'];

    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class);
    }
}
