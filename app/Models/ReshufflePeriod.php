<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReshufflePeriod extends Model
{
    use HasFactory;

    protected $table = "reshuffle_periods";

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class, 'lead_reshuffle_period', 'id');
    }
}
