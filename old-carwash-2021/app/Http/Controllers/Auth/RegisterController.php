<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function index(){
        return view('register');
    }

    public function store(Request $request){
        $nama_lengkap = $request->get('nama_lengkap');
        $email = $request->get('email');
        $password = $request->get('password');
        $roles = $request->get('akses');

        $user = User::create([
            'akses' => $roles,
            'nama' => $nama_lengkap,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register Berhasil'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register gagal'
            ], 400);
        }
    }
}
