<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'slug',
    'content',
    'header_image',     // <-- Tambahan
    'published_date',   // <-- Tambahan
    'summary',          // <-- Tambahan
    'active',
];
}
