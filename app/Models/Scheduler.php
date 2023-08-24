<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheduler extends Model
{
    use HasFactory;

    protected $table = "schedulers";

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner');
    }

    public function reminderType() :BelongsTo
    {
        return $this->belongsTo(SchedulerType::class, 'type');
    }
}
