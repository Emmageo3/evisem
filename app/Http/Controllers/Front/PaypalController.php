<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class PaypalController extends Controller
{
    public function paypal()
    {
        if(Session::has('order_id')){
            Cart::where('user_id', Auth::user()->id)->delete();
            $orderDetails = Order::where('id', Session::get('order_id')->first()->toArray());
            return view('front.paypal.paypal', compact('orderDetails'));
        }else{
            return redirect('cart');
        }
    }
}
