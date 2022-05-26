<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Hash;
use Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function settings()
    {
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings',compact('adminDetails'));
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        //echo "<pre>"; print_r($data);
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            echo "true";
        }else {
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
           // echo "<pre>"; print_r($data); die;
           if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
                if($data['new_pwd'] == $data['confirm_pwd']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    $request->session()->flash('success_message', 'Votre mot de passe a été modifié avec succes!');
                }else{
                    $request->session()->flash('error_message', 'Vos mots de passe ne correspondent pas');
                }
           }else{
               $request->session()->flash('error_message', 'Votre mot de passe actuel est incorrect');
           }
           return redirect()->back();
        }
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
