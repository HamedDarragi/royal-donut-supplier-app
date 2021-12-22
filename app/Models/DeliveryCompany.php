<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCompany extends Model
{
    use HasFactory;

    protected $fillable = ['name','minimum_order_amount','delivery_fee'];


    public function companies_supplier()
    {
        return $this->hasMany(CompanySupplier::class);
    }
}
