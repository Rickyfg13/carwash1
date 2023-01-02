<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class LoginController extends Controller
{
    //
    // protected $redirectTo = '';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
    
    protected function index(){
        $title = 'Login';
        return view('auth.login', compact('title'));
    }

    public function username(){
        return 'nohp';
    }

    public function adminLogin(){
        $title = 'Login Admin';
        return view('auth.login-admin', compact('title'));
    }

    public function check(Request $request){
        // dd($request);
        $email = $request->get('email');
        $password = $request->get('password');
        // $akses = $request->get('akses');

        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'akses' => 1], true)){
            
           return redirect('/admin/home');
            
        } else if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'akses' => 2], true)){
            return redirect('/finance/home');
        } else if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'akses' => 3], true)){           
            return redirect('/user/home');
        } else {
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
