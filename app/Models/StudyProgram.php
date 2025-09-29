<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'faculty_id',
        'active',
    ];

    /**
     * Get the faculty that owns the study program.
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
