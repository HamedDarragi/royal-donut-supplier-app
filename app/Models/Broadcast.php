<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'message',
        'expiry_date',
        'isActive',
        'image',
        'isSent'
    ];
    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }
}
