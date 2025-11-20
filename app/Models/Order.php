<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pending',
        'accepted',
        'rejected',
    ];

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'cart_items',
        'total_amount',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(fn ($item) => $item->price * $item->quantity);
    }
}