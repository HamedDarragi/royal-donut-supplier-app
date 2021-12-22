<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'isActive'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Retrive only Active record
    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }
}
