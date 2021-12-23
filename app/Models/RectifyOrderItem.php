<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RectifyOrderItem extends Model
{
    use HasFactory;
    protected $table = "rectify_order_items";

    protected $fillable = ['cart_id', 'product_id','product_name', 'quantity', 'min_quantity', 'unit_price'];

    public function rectify_order()
    {
        return $this->belongsTo(Cart::class);
    }

}
