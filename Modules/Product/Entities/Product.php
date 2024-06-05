<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'part', 
        'priority', 
        'short_description', 
        'full_description', 
        'main_image', 
        'category_id',
        'for_type',
        'display',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategories::class, 'product_categories', 'product_id', 'cat_id');
    }

    public function secondaryImages()
    {
        return $this->hasMany(ProductSecondaryImage::class);
    }
}
