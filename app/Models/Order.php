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
