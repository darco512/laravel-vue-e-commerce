<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brand', 'color', 'category', 'type', 'description', 'price'
    ];

    public function photos()
    {
        return $this->hasMany(ProductsPhoto::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductsSize::class);
    }
}
