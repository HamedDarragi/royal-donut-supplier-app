<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // protected $fillable=[
    //     'customer_id',
    //     'product_id',
    //     'min_qty',
    //     'req_qty',
    //     'total',
    //     'grandtotal',
    //     'sel_qty',
    //     'status'
    // ];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
