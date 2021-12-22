<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastGroupDetail extends Model
{
    use HasFactory;
    protected $fillable=[
    'customer_id',
    'broadcast_group_id'
    ];
    
}
