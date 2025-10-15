<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;
    protected $fillable = ['menu_id', 'label', 'url', 'target', 'parent_id', 'sort_order', 'active'];

    /**
     * Relasi ke "wadah" menu utamanya.
     */
    public function menu(): BelongsTo // <-- FUNGSI BARU YANG DITAMBAHKAN
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Relasi ke sub-item nya sendiri.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Relasi ke parent item-nya.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
}
