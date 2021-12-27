<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RectifyOrder extends Model
{
    use HasFactory;

    const CONFIRMED = 1;
    const INDELIVERY = 2;
    const DELIVERED = 3;
    const TREATED = 4;
    const RECTIFIED = 5;

    protected $table = "rectify_orders";
    protected $fillable = ['order_no','order_number', 'user_id','user_name', 'supplier_name', 'item_count', 'total', 'order_status', 'discount', 'taxes', 'grand_total','delivery_date'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')->withPivot('unit_name','product_name','quantity', 'unit_price', 'min_quantity')->withTrashed()->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
