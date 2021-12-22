<?php

namespace bilawalsh\cart\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'supplier_id', 'ip_address', 'item_count', 'total', 'discount', 'taxes', 'grand_total',
        'delivery_supplier_id', 'parent'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')->withPivot('quantity', 'unit_price', 'min_quantity')->withTimestamps();
    }

    // public function cart_items()
    // {
    //     return $this->belongsToMany(CartItem::class);
    // }
}
