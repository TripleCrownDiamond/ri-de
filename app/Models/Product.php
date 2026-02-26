<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_de',
        'slug',
        'description',
        'description_de',
        'brand_id',
        'price_ht',
        'price_ttc',
        'ean',
        'poids_kg',
        'dimensions',
        'sku',
        'extra_attributes',
        'is_active',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'extra_attributes' => 'array',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class);
    }
}

