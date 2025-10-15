<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nidn', 'position', 'email', 'photo', 'faculty_id', 
        'study_program_id', 'expertise', 'active',
        // --- FIELD BARU DARI GAMBAR ---
        'nik', 'nbm', 'functional_position',
        'link_pddikti', 'link_sinta', 'link_scholar',
    ];

    public function faculty(): BelongsTo { return $this->belongsTo(Faculty::class); }
    public function studyProgram(): BelongsTo { return $this->belongsTo(StudyProgram::class); }

}
