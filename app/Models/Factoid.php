<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factoid extends Model
{
 protected $fillable = ['label', 'value', 'icon', 'sort_order'];   //
}
