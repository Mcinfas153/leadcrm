<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function agent() :BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function leadTypeName(): BelongsTo
    {
        return $this->belongsTo(LeadType::class, 'type');
    }

    public function priorityName(): BelongsTo
    {
        return $this->belongsTo(Priority::class, 'priority');
    }

    public function statusName(): BelongsTo
    {
        return $this->belongsTo(LeadStatus::class, 'status');
    }
}
