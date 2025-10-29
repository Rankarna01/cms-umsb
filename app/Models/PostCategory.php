<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- TAMBAHKAN IMPORT INI
use App\Models\Post; // <-- TAMBAHKAN IMPORT INI

class PostCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // $fillable ini berdasarkan PostCategoryController Anda
    protected $fillable = [
        'name',
        'slug',
        'type',
        'active',
    ];

    /**
     * ==========================================================
     * INI ADALAH FUNGSI YANG DIPERLUKAN (PERBAIKAN)
     * ==========================================================
     *
     * Mendefinisikan bahwa satu Kategori (PostCategory) 
     * bisa memiliki BANYAK Post (HasMany).
     */
    public function posts(): HasMany
    {
        // Ini akan menghubungkan PostCategory ke Post
        // melalui foreign key 'category_id' di tabel posts
        return $this->hasMany(Post::class, 'category_id');
    }
}