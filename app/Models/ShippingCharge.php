<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($zone){
        $shippingDetails = ShippingCharge::where('zone', $zone)->first();
        $shipping_charges = $shippingDetails['shipping_charges'];
        return $shipping_charges;
    }
}
