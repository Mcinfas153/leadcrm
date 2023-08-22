<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => timeZoneChange(config('custom.LOCAL_TIMEZONE')),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => timeZoneChange(config('custom.LOCAL_TIMEZONE')),
        );
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
