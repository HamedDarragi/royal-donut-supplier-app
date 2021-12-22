<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateRule extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'supplier_id', 'rule_id'];
}
