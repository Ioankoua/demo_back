<?php

namespace Modules\BouquetBuilder\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BouquetBuilder extends Model
{
    use HasFactory;

    protected $table = 'bouquet_builder';

    protected $fillable = [
        'description',
        'compound',
        'phone',
        'social',
    ];
    
    protected static function newFactory()
    {
        return \Modules\BouquetBuilder\Database\factories\OrderFactory::new();
    }

    public function saveImg()
    {
        return $this->hasMany(BouquetBuilderImages::class, 'bouquet_builder_id');
    }

    public function images()
    {
        return $this->hasMany(BouquetBuilderImages::class);
    }

}
