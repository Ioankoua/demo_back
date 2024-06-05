<?php

namespace Modules\BouquetBuilder\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BouquetBuilderImages extends Model
{
    use HasFactory;

    protected $table = 'bouquet_builder_images';

    public $timestamps = false;

    protected $fillable = [
        'bouquet_builder_id',
        'image_path',
    ];
    
    protected static function newFactory()
    {
        return \Modules\BouquetBuilder\Database\factories\OrderFactory::new();
    }

    public function bouquetBuilder()
    {
        return $this->belongsTo(BouquetBuilder::class);
    }
}
