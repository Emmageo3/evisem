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

           $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

           if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
           {
               return redirect('admin/dashboard');
           }else {
               $request->session()->flash('error_message', 'Adresse email ou mot de passe invalide');
               return redirect()->back();
           }
        }
        return view('admin.admin_login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
