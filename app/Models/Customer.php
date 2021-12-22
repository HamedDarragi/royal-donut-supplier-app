<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'password',
        'franchise_name',
        'mobilenumber',
        'address',
        'isBlocked',
        'isBookmarked',
        'isActive'
    ];
// check
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }

    
}
