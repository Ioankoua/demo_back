<?php

namespace Modules\CustomerTracker\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductClickCount extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'click_count'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\CustomerTracker\Database\factories\ProductClickCountFactory::new();
    }
}
