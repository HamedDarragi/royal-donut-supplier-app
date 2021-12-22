<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'mobilenumber',
        'address',
        'fax_number',
        'isActive',
        'abbrivation'
    ];
    public function scopeIsActive($query)
    {
        return $query->where('IsActive', 1);
    }


    public function companies()
    {
        return $this->belongsToMany(DeliveryCompany::class, 'companies_supplier')
            ->withPivot('supplier_id', 'delivery_company_id')->withTimestamps();
    }
}
