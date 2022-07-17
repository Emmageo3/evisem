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
            return view('front.paypal.paypal');
        }else{
            return redirect('cart');
        }
    }
}
