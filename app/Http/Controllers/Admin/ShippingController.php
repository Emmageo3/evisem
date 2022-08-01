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

    public function editShippingCharges($id, Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            ShippingCharge::where('id', $id)->update(['shipping_charges'=>$data['shipping_charges']]);
            $message = "Frais modifiés avec succès !";
            Session::put('success_message', $message);
            return redirect()->back();
        }
        $shippingDetails = ShippingCharge::where('id',$id)->first()->toArray();
        return view('admin.shipping.edit_shipping_charges', compact('shippingDetails'));
    }

    public function updateShippingStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if ($data['status']=='Actif') {
                $status = 0;
            }else{
                $status = 1;
            }
            ShippingCharge::where('id',$data['shipping_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 200, 'shipping_id'=>$data['shipping_id']]);
        }
    }
}
