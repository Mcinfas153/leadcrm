<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::of($value)->title(),
            set: fn ($value) => strtolower($value),
        );
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class,'business_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'user_type');
    }

    public function role(): BelongsTo
    {
        return $this->BelongsTo(UserRole::class, 'user_role');
    }

    public function leads() :HasMany
    {
        return $this->hasMany(Lead::class, 'created_by');
    }

    public function assignLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assign_to');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'created_by');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(UserActivity::class, 'user_id');
    }

}