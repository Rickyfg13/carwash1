<?php

namespace App\Http\Controllers\Finance;

use PDF;
use App\User;
use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Orderan;
use App\Models\Hidrolik;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\DetailOrderan;

// use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ServiceController extends Controller
{
	//
	public function index()
	{
		return view('finance.index');
	}

	public function orderan(Request $request)
	{
		$today = Carbon::now();
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id');
		
		//For ATTENTION! Update 5/12/2022
		//Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
		if (!$request->type || $request->type =='antri') {
			$orderan = $orderan->where('status', 2)->whereDate('orderan.created_at',$today);
		} 
		else if($request->type == 'proses'){
			$orederan = $orderan->where('status',0)->whereDate('orderan.created_at',$today);
		}
		else if ($request->type =='finishing' ){
			$orderan = $orderan->where('status', 3 )->whereDate('orderan.created_at',$today);
		} 
		else if ($request->type =='selesai'){
			$orderan = $orderan->where('status', 1)->whereDate('orderan.created_at',$today);
		}
		
		$orderan = $orderan->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.metode_pembayaran','orderan.hidrolik_id' ,'orderan.status', 'orderan.created_at')
		->orderBy('orderan.created_at','DESC')
		->get();

		
		
		
		return view('finance.orderan.histori2', compact('orderan','today'));
	}

	public function updateStatus(Request $request)
	{

		Orderan::where('id', $request->id)->update(
			[
				'status' => $request->permintaan,
				'updated_at' => \carbon\Carbon::now()
			]
		);

		return back();
	}

	


	public function cari(Request $request)
	{
		$nohp = $request->nohp;
		if ($request->nohp == "") {
			return redirect('/finance/home');
		} else {
			$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
				->where('pelanggan.nohp', 'LIKE', $request->get('nohp') . '%')
				->select('pelanggan.id', 'pelanggan.nama', 'pelanggan.nohp')->distinct()->get();
			return view('finance.pelanggan.search-result', compact('orderan', 'nohp'));
			// dd($orderan);
		}
	}

	public function ownHistory($id)
	{
		$user_id = $id;
		$pelanggan_history = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->where('pelanggan_id', $id)
			->select('orderan.id', 'orderan.pelanggan_id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.status', 'orderan.catatan', 'orderan.created_at')
			->get();
		return view('finance.pelanggan.histori', compact('pelanggan_history', 'user_id'));
	}

	function byReport()
	{
		$today = Carbon::now();
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('users', 'users.id', '=', 'orderan.user_id')
			->whereDate('orderan.created_at',$today)
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.hidrolik_id', 'orderan.metode_pembayaran', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.created_at')->get();

		return view('finance.orderan.byReport', compact('orderan'));
	}

	function byReportFilter(Request $request)
	{

		if ($request->tglmulai == null || $request->tglakhir == null) {
			$tanggal = null;
			$request->tglmulai == null ? $tanggal = $request->tglakhir : $tanggal = $request->tglmulai;

			$orderan = $this->oneDayReportFilter($tanggal);
			return view('finance.orderan.byReportFilter', compact('orderan', 'tanggal'));
		} else if ($request->tglmulai != null && $request->tglakhir != null) {
			if (strtotime($request->tglmulai) == strtotime($request->tglakhir)) {
				$tanggal = $request->tglmulai;
				$orderan = $this->oneDayReportFilter($tanggal);
				return view('finance.orderan.byReportFilter', compact('orderan', 'tanggal'));
			} else if (strtotime($request->tglmulai) < strtotime($request->tglakhir)) {
				$tglmulai = $request->tglmulai;
				$tglakhir = $request->tglakhir;
				$orderan = $this->rangeDayReportFilter($tglmulai, $tglakhir);
				return view('finance.orderan.byReportFilter', compact('orderan', 'tglmulai', 'tglakhir'));
			} else if (strtotime($request->tglmulai) > strtotime($request->tglakhir)) {
				$tglmulai = $request->tglakhir;
				$tglakhir = $request->tglmulai;
				$orderan = $this->rangeDayReportFilter($tglmulai, $tglakhir);
				return view('finance.orderan.byReportFilter', compact('orderan', 'tglmulai', 'tglakhir'));
			}
		} else {
			return back();
		}
	}

	function oneDayReportFilter($tanggal)
	{
		return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('users', 'users.id', '=', 'orderan.user_id')
			->whereDate('orderan.created_at', date('Y-m-d', strtotime($tanggal)))
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'users.hidrolik_id', 'orderan.metode_pembayaran', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.created_at')->get();
	}

	function rangeDayReportFilter($tglmulai, $tglakhir)
	{
		return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('users', 'users.id', '=', 'orderan.user_id')
			->whereBetween('orderan.created_at', [date('Y-m-d', strtotime($tglmulai)), date('Y-m-d', strtotime($tglakhir))])
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'users.hidrolik_id', 'orderan.metode_pembayaran', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.created_at')->get();
	}

	function print($id)
	{
		$data = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.created_at')
			->where('orderan.id', $id)
			->get();
		return view('finance.orderan.print', compact('data'));
	}

	function genStrukOrder($id)
	{
		$data = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.metode_pembayaran', 'orderan.created_at')
			->where('orderan.id', $id)
			->first();

		$layanan = detailOrderan($id);
		$gambar = gambarByOrderId($id);

		$pdf = PDF::loadView('finance.orderan.struk', compact('data', 'layanan', 'gambar'));
		return $pdf->download('Struk-Order-'. $id . '.pdf');
		// return $pdf->stream();
	}

	function genKwitansi($id)
	{
		$data = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.metode_pembayaran', 'orderan.created_at', 'orderan.updated_at')
			->where('orderan.id', $id)
			->first();

		$layanan = detailOrderan($id);		
		return view('finance.orderan.kwitansi', compact('data', 'layanan'));
	}

	function genKwitansi2(Request $request, $id) 
	{
		$data = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.status', 'orderan.metode_pembayaran', 'orderan.created_at', 'orderan.updated_at')
			->where('orderan.id', $id)
			->first();

		$layanan = detailOrderan($id);		
		$pdf = PDF::loadView('finance.orderan.kwitansi2', compact('data', 'layanan'));
		if ($request->type == 'print') {
			return $pdf->stream();
		} else {
			return $pdf->download('Kwitansi-'.$id . '.pdf');
		}
		
	}

	function pilihHidrolik ($id) 
	{
		$data['orderan'] = DB::table('orderan')
		->whereId($id)->first();
		
		$data['hidrolik'] = DB::table('hidrolik')
		->get();

		return view('finance.orderan.pilihHidrolik',$data);
	}

	function hidrolikUpdate(Request $request) 
	{
		$update = Orderan::where('id', $request->id)->update(
			[
				'hidrolik_id' => $request->hidrolik_id,
				'updated_at' => \carbon\Carbon::now()
			]
		);

		
        if($update)
        {
            return redirect()->route('orderan')->with('success','Data berhasil diubah');
        }
        else
        {
            return redirect()->route('pilih.hidrolik')->with('error','Data gagal diubah');
        }
       

    }
		
	


}
