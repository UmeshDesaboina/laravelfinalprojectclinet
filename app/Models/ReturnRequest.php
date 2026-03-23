<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ReturnRequest extends Model
{
    protected $fillable = [
        'request_number', 'order_id', 'user_id', 'reason', 'reason_description',
        'resolution', 'refund_amount', 'status', 'admin_notes',
        'courier_name', 'tracking_id',
        'bank_account_number', 'bank_ifsc', 'bank_account_name',
        'processed_at', 'refunded_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($return) {
            if (empty($return->request_number)) {
                $return->request_number = 'RET' . strtoupper(Str::random(8));
            }
        });
    }

    protected function casts(): array
    {
        return [
            'refund_amount' => 'decimal:2',
            'processed_at' => 'datetime',
            'refunded_at' => 'datetime',
        ];
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_RECEIVED = 'received';
    public const STATUS_REFUNDED = 'refunded';

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_APPROVED => 'bg-blue-100 text-blue-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            self::STATUS_RECEIVED => 'bg-indigo-100 text-indigo-800',
            self::STATUS_REFUNDED => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
}
