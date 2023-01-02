<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data['today'] = date('Y-m-d');
        if($request->get('tanggal'))
        $data['today'] = $request->get('tanggal');
        $data['laporan'] = DB::table('orderan')
            ->join('pelanggan','orderan.pelanggan_id','pelanggan.id')
            ->leftJoin('users','orderan.user_id','users.id')
            ->leftJoin('hidrolik','orderan.hidrolik_id','hidrolik.id')
            ->whereDate('orderan.created_at',$data['today'])
            ->whereStatus(1)
            ->orderBy('orderan.id','asc')
            ->select('orderan.id', 'pelanggan.nama', 'hidrolik.keterangan','pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.hidrolik_id', 'orderan.metode_pembayaran', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.created_at')
            ->get();

        return view('finance.laporan.index',$data);
    }

    public function bulanan(Request $request)
    {
        $data['month'] = date('m');
        $data['year'] = date('Y');
        if($request->get('bulan'))
            $data['month'] = $request->get('bulan');
        if($request->get('tahun'))
            $data['year'] = $request->get('tahun');
        $data['laporan'] = DB::table('orderan')
            ->join('pelanggan','orderan.pelanggan_id','pelanggan.id')
            ->leftJoin('users','orderan.user_id','users.id')
            ->leftJoin('hidrolik','orderan.hidrolik_id','hidrolik.id')
            ->whereMonth('orderan.created_at',$data['month'])
            ->whereYear('orderan.created_at',$data['year'])
            ->whereStatus(1)
            ->orderBy('orderan.id','asc')
            ->select('orderan.id', 'pelanggan.nama', 'hidrolik.keterangan','pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.hidrolik_id', 'orderan.metode_pembayaran', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.created_at')
            ->get();

     
        return view('finance.laporan.bulanan',$data);
    }


}
