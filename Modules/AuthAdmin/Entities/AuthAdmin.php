<?php

namespace Modules\AuthAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthAdmin extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\AuthAdmin\Database\factories\AuthAdminFactory::new();
    }
}
