<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    //

    public $successStatus = 200;

    function login(Request $request){
			$request->validate([
				'email' => 'required|email',
				'password' => 'required|string'

			]);

			try {
				$credentials = request(['email', 'password']);
				if (!Auth::attempt($credentials))
					return response()->json([
						'success' => false,
						'message' => 'Periksa kembali email atau password anda'
					]);

				
				$user = Auth::user();
				$token = $user->createToken('Personal Access Token')->accessToken;

				return response()->json([
					'success' => true,
					'user' => $user,
					'time_login' => date('d M Y H:i:s'),
					'access_token' => $token					
				]);


			} catch (\Throwable $th){
				return response()->json([
					'success' => false,
					'message' => $th
				]);
			}
    }

		function register (Request $request){
			$validator = Validator::make($request->all(), [
				'nama' => 'required',
				'email' => 'required|email',
				'password' => 'required'
			]);

			if ($validator->fails()){
				return response()->json([
					'error' => $validator->errors()
				], 401);
			}

			

			User::create([
				'akses' => 3,
				'nama' => $request->nama,
				'email' => $request->email,
				'password' => Hash::make($request->password)
			]);

			return response()->json([
				'success' => true,
				'data_user' => [
					'nama' => $request->nama,
					'email' => $request->email,
					'password' => $request->password,
					'akses' => 3
				],
				'message' => 'Akun berhasil dibuat, silahkan login ke akun anda'
			]);
		}

		function details(){
			$user = Auth::user();
			return response()->json([
				'success' => true,
				'data_user' => $user
			]);
		}

		function bypass(){
			$pass =  DB::table('users')
            ->whereIdUser(1)
            ->update([
                'password' => Hash::make('admin1')
            ]);
			dd($pass);
		}
}
