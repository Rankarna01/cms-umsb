<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\MenuItem;


class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'location'];

    public function items(): HasMany
    {
        // Ambil hanya item utama (yang tidak punya parent)
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('sort_order');
    }
}
