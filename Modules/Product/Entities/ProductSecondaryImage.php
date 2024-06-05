<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSecondaryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductSecondaryImageFactory::new();
    }
}
