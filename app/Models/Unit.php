<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        // 'symbol',
        'abbreviation',
        'isActive'
    ];

    public function inventory()
    {
        return $this->hasOne(Product::class);
    }

    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }
}
