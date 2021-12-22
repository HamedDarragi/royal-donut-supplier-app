<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastGroup extends Model
{
    use HasFactory;
    protected $fillable=['name'];

    
    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }
}
