<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = [
    'name', 
    'position', 
    'photo', 
    'sort_order',
    'social_facebook', // <-- Tambahan
    'social_instagram',// <-- Tambahan
    'social_linkedin', // <-- Tambahan
    'social_x',        // <-- Tambahan
];
}
