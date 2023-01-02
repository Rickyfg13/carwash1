<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orderan;
use App\User;
use Auth;

class UserController extends Controller
{
    //
    public function index(){
      $id = Auth::user()->id;
			// dd(Auth::user());

			if(Auth::user()->akses == 1){
				$data_user = Auth::user();
				return view('admin.profile', compact('data_user'));
			} else if(Auth::user()->akses == 2){
				$data_user = Auth::user();
				return view('finance.profile', compact('data_user'));
			} else {
				$data_user = User::join('hidrolik', 'hidrolik.id', '=', 'users.hidrolik_id')->where('users.id', $id)
				->select('*', 'hidrolik.keterangan')->first();
				$jumlah_orderan = Orderan::where('user_id', $id)->count();
				return view('user.profile', compact('data_user', 'jumlah_orderan'));				
			}
    }
}
