<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Auth;
use Session;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['address'])){
                $data['address']="";
            }

            $userCount = User::where('email',$data['email'])->count();
            if($userCount>0){
                $message = "Cet utilisateur existe déja!";
                Session::flash('error_message',$message);
                return redirect()->back();
            }else {
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->address = "";
                $user->city = "";
                $user->state ="";
                $user->country="";
                $user->pincode="";
                $user->status = 1;
                $user->save();

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    $email = $data['email'];
                    $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                    Mail::send('emails.register',$messageData,function($message) use($email){
                        $message->to($email)->subject('Bienvenue chez Evisem');
                    });

                    return redirect('cart');
                }
            }
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $emailCount = User::where('email',$data['email'])->count();
        if($emailCount>0){
            return "false";
        }else{
            return "true";
        }

    }

    public function loginUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                if(!empty(Session::get('session_id'))){
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }

                return redirect('/cart');
            }else{
                $message = "Adresse email ou mot de passe invalide";
                Session::flash('error_message',$message);
                return redirect()->back();
            }
        }
    }
}
