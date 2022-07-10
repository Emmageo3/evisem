<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
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
    $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
    return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses'));
    }

    public function updateOrderStatus(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message','Le statut de la commande a été mis à jour avec succès!');
            return redirect()->back();
        }
    }

}
