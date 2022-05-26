<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Hash;
use Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
           // echo "<pre>"; print_r($data); die;
           if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
           {
               return redirect('admin/dashboard');
           }else {
               return redirect()->back();
           }
        }
        return view('admin.admin_login');
    }
}
