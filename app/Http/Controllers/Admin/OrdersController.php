<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Session;

class OrdersController extends Controller
{
    public function orders()
    {
        Session::put('page','orders');
        $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.orders', compact('orders'));
    }

}
