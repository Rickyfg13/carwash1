<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Carbon\Carbon;
use App\Models\Orderan;
use Auth;

class TestController extends Controller
{
    //

    function index (Request $request){
        $cek = Pelanggan::where('nama','LIKE' ,$request->pelanggan_nama.'%')->exists();
        return $cek;
    }

    function waktu (){
        return Carbon::today();
    }

    function todayHistory(){
        

        $params = [
            ['orderan.status', '=', 0],
            ['orderan.user_id', '=', Auth::user()->id]            
        ];

        $orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')			
        ->where($params)							
        ->whereDate('orderan.created_at', Carbon::today()->format('Y-m-d'))		
        ->orderBy('orderan.created_at', 'DESC')
        ->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.created_at')->get();

        return $orderan;
    }
}
