<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'path'
    ];

    protected $table = 'products_photos'; // Explicitly set the table name

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
