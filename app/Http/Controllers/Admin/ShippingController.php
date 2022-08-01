<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
use Session;

class ShippingController extends Controller
{
    public function viewShippingCharges(){
        Session::put('page', 'shipping_charges');
        $shipping_charges = ShippingCharge::get()->toArray();
        return view('admin.shipping.view_shipping_charges', compact('shipping_charges'));
    }
}
