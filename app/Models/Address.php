<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'phone', 'address_line_1', 'address_line_2',
        'city', 'state', 'postal_code', 'country', 'is_default'
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, {$this->city}, {$this->state} - {$this->pincode}";
    }

    public function setAsDefault(): void
    {
        $this->user->addresses()->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}
