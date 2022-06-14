<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Section;
use Session;

class CouponController extends Controller
{
    public function coupons()
    {
        Session::put('page','coupons');
        $coupons = Coupon::get()->toArray();
        return view('admin.coupons.coupons', compact('coupons'));
    }

    public function updateCouponStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            if ($data['status']=='Actif') {
                $status = 0;
            }else{
                $status = 1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 200, 'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function deleteCoupon(Request $request,$id)
    {
        Coupon::where('id', $id)->delete();

        $request->session()->flash('success_message', 'le coupon a été supprimé avec succes!');
        return redirect()->back();
    }

    public function addEditCoupon(Request $request, $id=null)
    {
        if($id==""){
            $title = "Ajouter un coupon";
            $coupon = new Coupon;
        } else {
             $title = "Modifier le coupon";
             $coupon = Coupon::find($id);
        }

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);

        return view('admin.coupons.add_edit_coupon', compact('title','coupon','categories'));
    }
}
