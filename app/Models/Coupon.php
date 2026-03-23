<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount',
        'expiry_date', 'usage_limit', 'used_count', 'is_active'
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'expiry_date' => 'date',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
            'used_count' => 'integer',
            'usage_limit' => 'integer',
        ];
    }

    public function getExpiryDateAttribute()
    {
        return $this->expires_at;
    }

    public const TYPE_FIXED = 'fixed';
    public const TYPE_PERCENTAGE = 'percentage';

    public function isValid(float $orderAmount): bool
    {
        if (!$this->is_active) return false;
        if ($this->expiry_date && Carbon::parse($this->expiry_date)->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($this->min_order_amount && $orderAmount < (float) $this->min_order_amount) return false;
        return true;
    }

    public function calculateDiscount(float $orderAmount): float
    {
        if ($this->type === self::TYPE_PERCENTAGE) {
            return ($orderAmount * $this->value) / 100;
        }
        return min((float) $this->value, $orderAmount);
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            });
    }
}
