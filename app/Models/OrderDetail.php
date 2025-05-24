<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_data',
        'quantity',
        'price',
    ];

    protected $casts = [
        'product_data' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
