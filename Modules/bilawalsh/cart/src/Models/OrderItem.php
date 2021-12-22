<?php

namespace bilawalsh\cart\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id','product_name', 'quantity', 'min_quantity', 'unit_price'];

    public function order()
    {
        return $this->belongsTo(Cart::class);
    }
}
