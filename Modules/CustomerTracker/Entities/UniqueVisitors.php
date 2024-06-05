<?php

namespace Modules\CustomerTracker\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniqueVisitors extends Model
{
    use HasFactory;

    protected $fillable = ['count', 'date'];
    
    protected static function newFactory()
    {
        return \Modules\CustomerTracker\Database\factories\UniqueVisitorsFactory::new();
    }
}
