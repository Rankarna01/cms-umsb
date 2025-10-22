<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'url',
        'sort_order',
    ];
}
