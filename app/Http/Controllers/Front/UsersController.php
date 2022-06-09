<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            echo "<pre>";print_r($data);die;
        }
    }
}
