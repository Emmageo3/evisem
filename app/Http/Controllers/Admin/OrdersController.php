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
use Dompdf\Dompdf;

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

    public function viewOrderInvoice($id)
    {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();

        return view('admin.orders.order_invoice', compact('orderDetails', 'userDetails'));
    }

    public function printPdfInvoice($id)
    {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();

        $output = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <title>Example 2</title>
                        <link rel="stylesheet" href="style.css" media="all" />
                    </head>
                    <style>
                    @font-face {
                        font-family: SourceSansPro;
                        src: url(SourceSansPro-Regular.ttf);
                      }

                      .clearfix:after {
                        content: "";
                        display: table;
                        clear: both;
                      }

                      a {
                        color: #0087C3;
                        text-decoration: none;
                      }

                      body {
                        position: relative;
                        width: 21cm;
                        height: 29.7cm;
                        margin: 0 auto;
                        color: #555555;
                        background: #FFFFFF;
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        font-family: SourceSansPro;
                      }

                      header {
                        padding: 10px 0;
                        margin-bottom: 20px;
                        border-bottom: 1px solid #AAAAAA;
                      }

                      #logo {
                        float: left;
                        margin-top: 8px;
                      }

                      #logo img {
                        height: 70px;
                      }

                      #company {
                        float: right;
                        text-align: right;
                      }


                      #details {
                        margin-bottom: 50px;
                      }

                      #client {
                        padding-left: 6px;
                        border-left: 6px solid #0087C3;
                        float: left;
                      }

                      #client .to {
                        color: #777777;
                      }

                      h2.name {
                        font-size: 1.4em;
                        font-weight: normal;
                        margin: 0;
                      }

                      #invoice {
                        float: right;
                        text-align: right;
                      }

                      #invoice h1 {
                        color: #0087C3;
                        font-size: 2.4em;
                        line-height: 1em;
                        font-weight: normal;
                        margin: 0  0 10px 0;
                      }

                      #invoice .date {
                        font-size: 1.1em;
                        color: #777777;
                      }

                      table {
                        width: 100%;
                        border-collapse: collapse;
                        border-spacing: 0;
                        margin-bottom: 20px;
                      }

                      table th,
                      table td {
                        padding: 20px;
                        background: #EEEEEE;
                        text-align: center;
                        border-bottom: 1px solid #FFFFFF;
                      }

                      table th {
                        white-space: nowrap;
                        font-weight: normal;
                      }

                      table td {
                        text-align: right;
                      }

                      table td h3{
                        color: #57B223;
                        font-size: 1.2em;
                        font-weight: normal;
                        margin: 0 0 0.2em 0;
                      }

                      table .no {
                        color: #FFFFFF;
                        font-size: 1.6em;
                        background: #57B223;
                      }

                      table .desc {
                        text-align: left;
                      }

                      table .unit {
                        background: #DDDDDD;
                      }

                      table .qty {
                      }

                      table .total {
                        background: #57B223;
                        color: #FFFFFF;
                      }

                      table td.unit,
                      table td.qty,
                      table td.total {
                        font-size: 1.2em;
                      }

                      table tbody tr:last-child td {
                        border: none;
                      }

                      table tfoot td {
                        padding: 10px 20px;
                        background: #FFFFFF;
                        border-bottom: none;
                        font-size: 1.2em;
                        white-space: nowrap;
                        border-top: 1px solid #AAAAAA;
                      }

                      table tfoot tr:first-child td {
                        border-top: none;
                      }

                      table tfoot tr:last-child td {
                        color: #57B223;
                        font-size: 1.4em;
                        border-top: 1px solid #57B223;

                      }

                      table tfoot tr td:first-child {
                        border: none;
                      }

                      #thanks{
                        font-size: 2em;
                        margin-bottom: 50px;
                      }

                      #notices{
                        padding-left: 6px;
                        border-left: 6px solid #0087C3;
                      }

                      #notices .notice {
                        font-size: 1.2em;
                      }

                      footer {
                        color: #777777;
                        width: 100%;
                        height: 30px;
                        position: absolute;
                        bottom: 0;
                        border-top: 1px solid #AAAAAA;
                        padding: 8px 0;
                        text-align: center;
                      }

                    </style>
                    <body>
                        <header class="clearfix">
                        <div id="logo">
                            <h1>COMMANDE</h1>
                        </div>
                        </header>
                        <main>
                        <div id="details" class="clearfix">
                            <div id="client">
                            <div class="to">Facturée à:</div>
                            <h2 class="name">'.$orderDetails['name'].'</h2>
                            <div class="address">'.$orderDetails['address'].','.$orderDetails['city'].'</div>
                            <div class="address">'.$orderDetails['country'].'-'.$orderDetails['pincode'].'</div>
                            <div class="email"><a href="mailto:'.$orderDetails['email'].'">'.$orderDetails['email'].'</a></div>
                            </div>
                            <div style="float: right">
                            <h1>Numéro de commande : '.$orderDetails['id'].'</h1>
                            <div class="date">Date: '.date('d-m-Y',strtotime($orderDetails['created_at'])).'</div>
                            <div class="date">Montant : '.$orderDetails['grand_total'].'</div>
                            <div class="date">Statut de la commande : '.$orderDetails['order_status'].'</div>
                            <div class="date">Méthode de paiement : '.$orderDetails['payment_method'].'</div>
                            </div>
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th class="no">Code</th>
                                <th class="desc">Taille</th>
                                <th class="unit">Couleur</th>
                                <th class="qty">Prix</th>
                                <th class="total">Quantité</th>
                                <th class="total">Total/th>
                            </tr>
                            </thead>
                            <tbody>';
                            $subTotal = 0;
                            foreach($orderDetails['orders_products'] as $product){
                            $output.='
                            <tr>
                                <td class="no">'.$product['product_code'].'</td>
                                <td class="desc">'.$product['product_size'].'</td>
                                <td class="unit">'.$product['product_color'].'</td>
                                <td class="qty">'.$product['product_price'].' Fcfa</td>
                                <td class="total">'.$product['product_qty'].'</td>
                                <td class="total">'.$product['product_price']*$product['product_qty'].'</td>
                            </tr>';
                            $subTotal = $subTotal + ($product['product_price']*$product['product_qty']);
                            } $output .=
                            '
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Total</td>
                                <td>'.$subTotal.' Fcfa</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Frais de livraison</td>
                                <td>0 Fcfa</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Coupon</td>';
                                if($orderDetails['coupon_amount']>0){
                                    $output .= '<td>'.$orderDetails['coupon_amount'].'</td>';
                                }else{
                                    $output .= '.<td>O Fcfa</td>.';
                                }
                                $output .='
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Montant total</td>
                                <td>'.$orderDetails['grand_total'].' Fcfa</td>
                            </tr>
                            </tfoot>
                        </table>
                        </main>
                        <footer>
                        Cette facture est valide.
                        </footer>
                    </body>
                    </html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream();

        return view('admin.orders.order_invoice', compact('orderDetails', 'userDetails'));
    }

}
