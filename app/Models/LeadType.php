<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LeadType extends Model
{
    use HasFactory;

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::of($value)->title(),
            set: fn ($value) => strtolower($value),
        );
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'type');
    }
}
