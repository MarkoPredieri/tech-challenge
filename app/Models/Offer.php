<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name',
        'offer_name',
        'supply_type',
        'unit_price',
        'price_unit',
        'is_active',
    ];
}
