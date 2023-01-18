<?php

namespace App\Http\Controllers\Finance;

use Carbon\Carbon;
use App\Models\Orderan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
            $today = Carbon::now();
            $orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id');
            
            //For ATTENTION! Update 5/12/2022
            //Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
            
            
            $orderan = $orderan->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.metode_pembayaran','orderan.hidrolik_id' ,'orderan.status', 'orderan.created_at')
            ->where('status',0 )
            ->wheredate('orderan.created_at',$today)
            ->orderBy('orderan.created_at','DESC')
            
            ->get();

            return view('finance.pelanggan.viewCuci.index', compact('orderan','today'));
        

		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewProses2()
    {
        $today = Carbon::now();
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id');
		
		//For ATTENTION! Update 5/12/2022
		//Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
		
		$orderan = $orderan->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.metode_pembayaran','orderan.hidrolik_id' ,'orderan.status', 'orderan.created_at')
        ->where('status',0)
        ->wheredate('orderan.created_at',$today)
		->orderBy('orderan.created_at','DESC')
		->get();

		return view('finance.pelanggan.viewCuci.viewProses2', compact('orderan','today'));
    }
    public function viewProses3()
    {
        $today = Carbon::now();
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id');
		
		//For ATTENTION! Update 5/12/2022
		//Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
		
		$orderan = $orderan->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.metode_pembayaran','orderan.hidrolik_id' ,'orderan.status', 'orderan.created_at')
        ->where('status',0)
        ->wheredate('orderan.created_at',$today)
		->orderBy('orderan.created_at','DESC')
		->get();

		return view('finance.pelanggan.viewCuci.viewProses3', compact('orderan','today'));
    }
    public function viewProses4()
    {
        $today = Carbon::now();
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id');
		
		//For ATTENTION! Update 5/12/2022
		//Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
		
		$orderan = $orderan->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.metode_pembayaran','orderan.hidrolik_id' ,'orderan.status', 'orderan.created_at')
        ->where('status',0)
        ->wheredate('orderan.created_at',$today)
		->orderBy('orderan.created_at','DESC')
		->get();

		return view('finance.pelanggan.viewCuci.viewProses4', compact('orderan','today'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
