<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            //get: fn ($value) => '',
            set: fn ($value) => timeZoneChange('UTC'),
        );
    }
}
