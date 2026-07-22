<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'nama',
        'deskripsi',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSub($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
