<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Section;
use App\Models\User;
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
            $message = "Le coupon a été ajouté avec succès";
        } else {
            $title = "Modifier le coupon";
            $coupondata = Coupon::find($id);
            $coupondata = json_decode(json_encode($coupondata), true);
            $coupon = Coupon::find($id);
            $message = "Le coupon a été modifié avec succès";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric'
            ];

            $customMessages = [
                'categories.required' => 'Veuillez choisir une catégorie',
                'coupon_option.required' => 'Veuillez cocher une option de coupon',
                'coupon_type.required' => 'Veuillez choisir un type de coupon',
                'amount_type.required' => 'Veuillez choisir un type de montant',
                'amount.required' => 'Veuillez saisir le montant du coupon'
            ];

            $this->validate($request,$rules,$customMessages);

            if(isset($data['users'])){
                $users = implode(',',$data['users']);
            }else{
                $users = "";
            }

            if(isset($data['categories'])){
                $categories = implode(',',$data['categories']);
            }

            if($data['coupon_option']=="automatic"){
                $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_code'];
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();

            Session::flash('success_message',$message);
            return redirect('admin/coupons');
        }

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);

        $users = User::select('email')->where('status',1)->get()->toArray();

        return view('admin.coupons.add_edit_coupon', compact('title','coupon','categories','users','coupondata'));
    }
}
