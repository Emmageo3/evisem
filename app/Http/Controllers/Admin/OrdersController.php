<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Session;

class OrdersController extends Controller
{
    public function orders()
    {
        Session::put('page','orders');
        $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
    $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
    $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
    return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }

}
