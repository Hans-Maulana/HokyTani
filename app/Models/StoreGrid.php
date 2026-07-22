<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreGrid extends Model
{
    use HasFactory;

    protected $fillable = [
        'row_idx',
        'col_idx',
        'zone_type',
        'label',
        'color',
    ];
}
