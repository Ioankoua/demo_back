<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    public $timestamps = false;

    protected $fillable = [
        'name', 
    ];
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\CategoryFactory::new();
    }
}
