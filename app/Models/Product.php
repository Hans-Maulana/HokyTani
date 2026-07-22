<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'rack_id',
        'barcode',
        'nama',
        'merk',
        'harga',
        'deskripsi',
        'bahan_aktif',
        'status',
        'foto',
        'lokasi_rak',
    ];

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'product_problem');
    }
}
