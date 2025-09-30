<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SebastianBergmann\CodeUnit\FunctionUnit;

class OrderItem extends Model
{
       protected $guarded = [
        'id'
    ];
    
      public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function order(): BelongsTo
     {
        return $this->belongsTo(Order::class);
     }

}
