<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategories extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'cat_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductCategoriesFactory::new();
    }
}
