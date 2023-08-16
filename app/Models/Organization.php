<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "organizations";

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::of($value)->title(),
            set: fn ($value) => strtolower($value),
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'business_id');
    }

    public function leadReshufflePeriod(): BelongsTo
    {
        return $this->belongsTo(ReshufflePeriod::class, 'lead_reshuflle_period', 'id');
    }
}
