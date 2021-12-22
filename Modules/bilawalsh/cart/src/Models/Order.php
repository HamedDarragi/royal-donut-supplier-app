<?php

namespace bilawalsh\cart\Models;

use App\Models\Product;
use App\Models\User;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    const CONFIRMED = 1;
    const INDELIVERY = 2;
    const DELIVERED = 3;
    const TREATED = 4;


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
