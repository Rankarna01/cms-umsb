<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'image',
        'link_url',
        'button_text',
        'sort_order',
        'active',
    ];
}
