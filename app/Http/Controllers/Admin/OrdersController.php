<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\OrdersLog;
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
    $orderLog = OrdersLog::where('order_id', $id)->orderBy('id', 'Desc')->get()->toArray();
    return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderLog'));
    }

    public function updateOrderStatus(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message','Le statut de la commande a été mis à jour avec succès!');

            if(!empty($data['courrier_name']) && !empty($data['tracking_number'])){
                Order::where('id',$data['order_id'])->update(['courrier_name'=>$data['courrier_name'], 'tracking_number'=>$data['tracking_number']]);
            }

            $deliveryDetails = Order::select('email','name')->where('id', $data['order_id'])->first()->toArray();
            $orderDetails = Order::with('orders_products')->where('id', $data['order_id'])->first()->toArray();

                $email = $deliveryDetails['email'];
                $messageData = [
                    'email'=> $email,
                    'name' => $deliveryDetails['name'],
                    'order_id' => $data['order_id'],
                    'order_status' => $data['order_status'],
                    'courrier_name' => $data['courrier_name'],
                    'tracking_number' => $data['tracking_number'],
                    'orderDetails' =>  $orderDetails
                ];

                Mail::send('emails.order_status', $messageData, function($message) use($email){
                    $message->to($email)->subject('Statut de votre commande - Evisem');
                });

            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            return redirect()->back();
        }
    }

}
