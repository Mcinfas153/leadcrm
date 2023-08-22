<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LeadActivity extends Model
{
    use HasFactory;

    protected $table = "lead_activities";

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
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
