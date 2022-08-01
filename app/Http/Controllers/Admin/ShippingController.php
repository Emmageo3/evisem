<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function viewShippingCharges(){
        $shipping_charges = ShippingCharge::get()->toArray();
        return view('admin.shipping.view_shipping_charges', compact('shipping_charges'));
    }
}
