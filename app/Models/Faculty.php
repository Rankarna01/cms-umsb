<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'active',
    ];

    /**
     * Mendefinisikan bahwa satu Fakultas memiliki banyak Dosen.
     */
    public function lecturers(): HasMany
    {
        return $this->hasMany(Lecturer::class);
    }

    /**
     * Mendefinisikan bahwa satu Fakultas memiliki banyak Program Studi.
     */
    public function studyPrograms(): HasMany // <-- TAMBAHKAN FUNGSI INI
    {
        return $this->hasMany(StudyProgram::class);
    }
}
