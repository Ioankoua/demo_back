<?php

namespace Modules\CustomerTracker\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductClick extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'client_id'];
    
    protected static function newFactory()
    {
        return \Modules\CustomerTracker\Database\factories\ProductClickFactory::new();
    }
}
