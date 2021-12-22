<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'index',
        'name',
        'price',
        'description',
        'category_id',
        'image',
        'isActive',
        'min_req_qty',
        'manufacturing_partner_id',
        'supplier_id',
        'unit_id',
        'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    public function allergens()
    {
        return $this->belongsToMany(Allergen::class);
    }
    public function inventory()
    {
        return $this->hasOne(Product::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_items')
            ->withPivot('quantity', 'unit_price', 'min_quantity')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'unit_price', 'min_quantity')->withTrashed()->withTimestamps();
    }
    // Retrive only Active record
    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }
}
