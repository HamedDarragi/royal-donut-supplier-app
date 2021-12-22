<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastHistory extends Model
{
    use HasFactory;
    protected $fillable=[
        'sending_date',
        'sending_time',
        'broadcast_group_id',
        'broadcast_group_id',
        'broadcast_id',
        'broadcast_id'
    ];
}
