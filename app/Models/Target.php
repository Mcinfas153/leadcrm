<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'starting_date', 'ending_date', 'total_amount', 'achieved_amount', 'business_id', 'created_by', 'is_active'];

    public function agent():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
