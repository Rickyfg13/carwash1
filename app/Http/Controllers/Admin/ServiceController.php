<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Orderan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\DetailOrderan;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    //
    public function index()
	{
		$today = Carbon::now();
        $orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
									->whereDate('orderan.created_at',$today)
									->orderBy('orderan.created_at', 'DESC')
									->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();				
				
			return view('admin.orderan.histori', compact('orderan'));
    }

		function orderanFilter(Request $request){
			if ($request->tglmulai == null || $request->tglakhir == null){
				$tanggal = null;
				$request->tglmulai == null ? $tanggal = $request->tglakhir : $tanggal = $request->tglmulai;

				$orderan = $this->oneDayFilter($tanggal);
				return view('admin.orderan.historiFilter', compact('orderan', 'tanggal'));

			} else if ($request->tglmulai != null && $request->tglakhir != null){

				if (strtotime($request->tglmulai) == strtotime($request->tglakhir)) {
					$tanggal = $request->tglmulai;
					$orderan = $this->oneDayFilter($tanggal);
					return view('admin.orderan.historiFilter', compact('orderan', 'tanggal'));

				} else if (strtotime($request->tglmulai) < strtotime($request->tglakhir)){

					$tglmulai = $request->tglmulai;
					$tglakhir = $request->tglakhir;
					$orderan = $this->rangeDayFilter($tglmulai, $tglakhir);
					return view('admin.orderan.historiFilter', compact('orderan', 'tglmulai', 'tglakhir'));

				} else if (strtotime($request->tglmulai) > strtotime($request->tglakhir)) {

					$tglmulai = $request->tglakhir;
					$tglakhir = $request->tglmulai;
					$orderan = $this->rangeDayFilter($tglmulai, $tglakhir);
					return view('admin.orderan.historiFilter', compact('orderan', 'tglmulai', 'tglakhir'));

				}
			} else{
				
				return back();
			}
		}

		function oneDayFilter($tanggal){
			return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->whereDate('orderan.created_at', date('Y-m-d', strtotime($tanggal)))
						->orderBy('orderan.created_at', 'DESC')
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
		}

		function rangeDayFilter($tglmulai, $tglakhir){
			return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->whereBetween('orderan.created_at', [date('Y-m-d', strtotime($tglmulai)), date('Y-m-d', strtotime($tglakhir))])
						->orderBy('orderan.created_at', 'DESC')
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
		}

		function byPayment(){
			$today = Carbon::now();
			$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->whereDate('orderan.created_at',$today)
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
			
			return view('admin.orderan.byPayment', compact('orderan'));
		}

		function byPaymentFilter(Request $request){
			if ($request->tglmulai == null || $request->tglakhir == null){
				$tanggal = null;
				$request->tglmulai == null ? $tanggal = $request->tglakhir : $tanggal = $request->tglmulai;

				$orderan = $this->oneDayPaymentFilter($tanggal);
				return view('admin.orderan.byPaymentFilter', compact('orderan', 'tanggal'));
			} else if ($request->tglmulai != null && $request->tglakhir != null){
				if (strtotime($request->tglmulai) == strtotime($request->tglakhir)) {
					$tanggal = $request->tglmulai;
					$orderan = $this->oneDayPaymentFilter($tanggal);
					return view('admin.orderan.byPaymentFilter', compact('orderan', 'tanggal'));
				} else if (strtotime($request->tglmulai) < strtotime($request->tglakhir)){
					$tglmulai = $request->tglmulai;
					$tglakhir = $request->tglakhir;
					$orderan = $this->rangeDayPaymentFilter($tglmulai, $tglakhir);
					return view('admin.orderan.byPaymentFilter', compact('orderan', 'tglmulai', 'tglakhir'));
				} else if (strtotime($request->tglmulai) > strtotime($request->tglakhir)) {
					$tglmulai = $request->tglakhir;
					$tglakhir = $request->tglmulai;
					$orderan = $this->rangeDayPaymentFilter($tglmulai, $tglakhir);
					return view('admin.orderan.byPaymentFilter', compact('orderan', 'tglmulai', 'tglakhir'));
				}
			} else{
				return back();
			}
		}

		function oneDayPaymentFilter ($tanggal){
			return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->whereDate('orderan.created_at', date('Y-m-d', strtotime($tanggal)))
						->orderBy('orderan.created_at', 'DESC')
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
		}

		function rangeDayPaymentFilter($tglmulai, $tglakhir){
			return Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->whereBetween('orderan.created_at', [date('Y-m-d', strtotime($tglmulai)), date('Y-m-d', strtotime($tglakhir))])
						->orderBy('orderan.created_at', 'DESC')
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();
		}

		function byReport(){
			$today = Carbon::now();
			$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('users', 'users.id', '=', 'orderan.user_id')
			->orderBy('orderan.created_at', 'DESC')
			->whereDate('orderan.created_at',$today)
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan','orderan.hidrolik_id' ,'orderan.metode_pembayaran','orderan.merk', 'orderan.catatan','orderan.status' ,'orderan.created_at')->get();

			return view('admin.orderan.byReport', compact('orderan'));
		}

		function byReportFilter(Request $request){		

			if ($request->tglmulai == null || $request->tglakhir == null){
				$tanggal = null;
				$request->tglmulai == null ? $tanggal = $request->tglakhir : $tanggal = $request->tglmulai;

				$orderan = $this->oneDayReportFilter($tanggal);
				return view('admin.orderan.byReportFilter', compact('orderan', 'tanggal'));
			} else if ($request->tglmulai != null && $request->tglakhir != null){
				if (strtotime($request->tglmulai) == strtotime($request->tglakhir)) {
					$tanggal = $request->tglmulai;
					$orderan = $this->oneDayReportFilter($tanggal);
					return view('admin.orderan.byReportFilter', compact('orderan', 'tanggal'));
				} else if (strtotime($request->tglmulai) < strtotime($request->tglakhir)){
					$tglmulai = $request->tglmulai;
					$tglakhir = $request->tglakhir;
					$orderan = $this->rangeDayReportFilter($tglmulai, $tglakhir);
					return view('admin.orderan.byReportFilter', compact('orderan', 'tglmulai', 'tglakhir'));
				} else if (strtotime($request->tglmulai) > strtotime($request->tglakhir)) {
					$tglmulai = $request->tglakhir;
					$tglakhir = $request->tglmulai;
					$orderan = $this->rangeDayReportFilter($tglmulai, $tglakhir);
					return view('admin.orderan.byReportFilter', compact('orderan', 'tglmulai', 'tglakhir'));
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

		public function updateStatus(Request $request){
			
			Orderan::where('id', $request->id)->update(
				[
					'status' => $request->permintaan,
					'updated_at' => \carbon\Carbon::now()
				]
			);

			return back();
    }
}
