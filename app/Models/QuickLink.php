<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    protected $fillable = ['title', 'url', 'icon', 'sort_order'];
}
