<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = ['user_id', 'session_id', 'product_id', 'quantity', 'variant'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->product->final_price * $this->quantity;
    }

    public function incrementQuantity(int $qty = 1): void
    {
        $this->increment('quantity', $qty);
    }

    public function decrementQuantity(int $qty = 1): void
    {
        $newQty = $this->quantity - $qty;
        if ($newQty <= 0) {
            $this->delete();
        } else {
            $this->decrement('quantity', $qty);
        }
    }
}
