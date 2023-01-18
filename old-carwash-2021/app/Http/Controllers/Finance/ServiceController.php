<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hidrolik;
use App\Models\Orderan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\DetailOrderan;
use App\User;

class ServiceController extends Controller
{
    //
    public function index(){
        return view('finance.index');
    }

		public function orderan (){
			$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
                        ->orderBy('orderan.created_at', 'DESC')
                        ->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
        return view('finance.orderan.histori', compact('orderan'));
		}

    public function updateStatus(Request $request){
			
			Orderan::where('id', $request->id)->update(
				[
					'status' => $request->permintaan,
					'updated_at' => \carbon\Carbon::now()
				]
			);

			return back();
    }

		public function cari(Request $request){
			$nohp = $request->nohp;
			if ($request->nohp == ""){
				return redirect('/finance/home');
			} else {
				$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
								->where('pelanggan.nohp', 'LIKE', $request->get('nohp') . '%')
								->select('pelanggan.id', 'pelanggan.nama', 'pelanggan.nohp')->distinct()->get();
				return view('finance.pelanggan.search-result', compact('orderan', 'nohp'));
				// dd($orderan);
			}
		}

		public function ownHistory($id){
			$user_id = $id;
			$pelanggan_history = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
								->where('pelanggan_id', $id)
								->select('orderan.id','orderan.pelanggan_id' ,'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk','orderan.status' ,'orderan.catatan', 'orderan.created_at')
								->get();
			return view('finance.pelanggan.histori', compact('pelanggan_history', 'user_id'));
		}

		function byReport(){
			$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('users', 'users.id', '=', 'orderan.user_id')
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan','users.hidrolik_id' ,'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();

			return view('finance.orderan.byReport', compact('orderan'));
		}

		function byReportFilter(Request $request){		

			if ($request->tglmulai == null || $request->tglakhir == null){
				$tanggal = null;
				$request->tglmulai == null ? $tanggal = $request->tglakhir : $tanggal = $request->tglmulai;

				$orderan = $this->oneDayReportFilter($tanggal);
				return view('finance.orderan.byReportFilter', compact('orderan', 'tanggal'));
			} else if ($request->tglmulai != null && $request->tglakhir != null){
				if (strtotime($request->tglmulai) == strtotime($request->tglakhir)) {
					$tanggal = $request->tglmulai;
					$orderan = $this->oneDayReportFilter($tanggal);
					return view('finance.orderan.byReportFilter', compact('orderan', 'tanggal'));
				} else if (strtotime($request->tglmulai) < strtotime($request->tglakhir)){
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
			} else{
				return back();
			}
		}

		function oneDayReportFilter ($tanggal){
			return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->join('users', 'users.id', '=', 'orderan.user_id')
						->whereDate('orderan.created_at', date('Y-m-d', strtotime($tanggal)))
						->orderBy('orderan.created_at', 'DESC')
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan','users.hidrolik_id' ,'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
		}

		function rangeDayReportFilter($tglmulai, $tglakhir){
			return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->join('users', 'users.id', '=', 'orderan.user_id')
						->whereBetween('orderan.created_at', [date('Y-m-d', strtotime($tglmulai)), date('Y-m-d', strtotime($tglakhir))])
						->orderBy('orderan.created_at', 'DESC')
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan','users.hidrolik_id' ,'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
		}
		
		function print($id)
		{
		    $data = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
                        ->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')
                        ->where('orderan.id', $id)
                        ->get();
			return view('finance.orderan.print',compact('data'));
		}
}
