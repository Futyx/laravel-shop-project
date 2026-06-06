<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Payment;

class Order extends Model
{
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'phone', 
        'email', 
        'transaction_id',
        'tracking_code',
        'shipping_address',
        'shipping_phone',
        'postal_code',
    ];
    public static function generateTrackingCode()
    {
        do {
            $code = rand(10000000, 99999999);
        } while (self::where('tracking_code', $code)->exists());

        return $code;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
