<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orderan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\DetailOrderan;
Use App\User;
use Auth;
use Carbon\Carbon;
use stdClass;
use Validator;

class ServiceController extends Controller
{
    //

    // Menampilkan histori orderan berdasarkan id user
    function index(){			
      $histori_orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')								
												->where([
													['orderan.status', '=', 0],
													['orderan.user_id', '=', Auth::user()->id]
												])
												->orderBy('orderan.created_at', 'DESC')
												->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.created_at')->get();
			$histori_orderan_full = [];

			foreach($histori_orderan as $key => $value){
				$histori_orderan_full[$key] = $value;
				$detail = detailOrderan($value->id);
				$histori_orderan_full[$key]->layanan = $detail;
			}

			// dd($histori_orderan_full);

			return response()->json([
				'success' => true,
				'data_user' => Auth::user(),
				'semua_histori_orderan' => $histori_orderan_full
			]);
    }		

		function addOrderan(Request $request){
			try {
				// Periksa apakah pelanggan sudah pernah mencuci sebelumnya
				if( $request->pelanggan_id == null || !isset($request->pelanggan_id) || $request->pelanggan_id == '') {
					Pelanggan::create([
							'nama' => $request->nama,
							'nohp' => $request->nohp
					]);

					$pelanggan_baru = Pelanggan::orderBy('created_at', 'DESC')->first();
					$pelanggan_id = $pelanggan_baru->id;            
				} else {
						$pelanggan_id = $request->pelanggan_id;
				}
								

				Orderan::create([
						'user_id' => Auth::user()->id,
						'pelanggan_id' => $pelanggan_id,
						'metode_pembayaran' => $request->metodepembayaran,
						'no_kendaraan' => $request->nokendaraan,
						'merk' => $request->merkkendaraan,
						'catatan' => $request->catatan,
						'status' => 0
				]);

				$orderan_baru = Orderan::orderBy('created_at', 'DESC')->first();
				
				for($i = 0; $i < count($request->layanan); $i++){
					DetailOrderan::create([
						'orderan_id' => $orderan_baru->id,
						'layanan_id' => $request->layanan[$i],
						'layanan_detail' => $request->nama_layanan[$i],
						'harga' => $request->harga[$i]
					]);
				}

				// orderan yg baru saja masuk
				$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')			
									->where([
										['orderan.status', '=', 0],
										['orderan.user_id', '=', Auth::user()->id]
									])									
									->orderBy('orderan.created_at', 'DESC')
									->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.created_at')->first();
				// dd($orderan);

				return response()->json([
					'success' => true,
					'data_user' => Auth::user(),
					'data_orderan' => $request->all()
				]);

			} catch ( \Throwable $th) {
				return response()->json([
					'success' => false,
					'message' => 'Terjadi Kesalahan'.$th
				]);
			}			
		}

		function todayHistory (){
			$params = [
				['orderan.status', '=', 0],
				['orderan.user_id', '=', Auth::user()->id]
			];
			$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')			
								->where($params)			
								->whereDate('orderan.created_at', Carbon::today()->format('Y-m-d'))								
								->orderBy('orderan.created_at', 'DESC')
								->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan', 'orderan.created_at')->get();

			$orderan_full = [];

			foreach($orderan as $key => $value){
				$orderan_full[$key] = $value;
				$detail = detailOrderan($value->id);
				$orderan_full[$key]->layanan = $detail;
			}

			return response()->json([
				'success' => true,
				'data_orderan' => $orderan_full,
				'message' => 'orderan hari ini'
			]);
		}

		function findingCustomer(Request $request){
			$validator = Validator::make($request->all(), [
				'nohp' => 'required|string|max:14'
			]);

			if ($validator->fails())
				return response()->json([
					'success' => false,
					'error' => $validator->errors()
				], 401);
			
			
				$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
				->where('pelanggan.nohp', 'LIKE', $request->get('nohp') . '%')
				->select('pelanggan.id', 'pelanggan.nama', 'pelanggan.nohp')->distinct()->get();

				return response()->json([
					'success' => true,
					'hasil_cari' => $orderan					
				]);
		}


		function customerHistory(Request $request){
			$pelanggan_history = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
													->where('pelanggan_id', $request->pelanggan_id)
													->orderBy('orderan.created_at', 'DESC')
													->select('orderan.id','orderan.pelanggan_id' ,'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk','orderan.status' ,'orderan.catatan', 'orderan.created_at')
													->get();
			
			$pelanggan_history_full = [];

			foreach($pelanggan_history as $key => $value){
				$pelanggan_history_full[$key] = $value;
				$detail = detailOrderan($value->id);
				$pelanggan_history_full[$key]->layanan = $detail;
			}

			return response()->json([
				'success' => true,
				'data_orderan' => $pelanggan_history_full,
				'message' => 'Histori Orderan Pelanggan'
			]);
		}

		function detailOrderan($orderan_id){
			$detail = DetailOrderan::join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')
			->where('detail_orderan.orderan_id', $orderan_id)
			->select('layanan.nama_layanan' ,'detail_orderan.harga')->get();
		}

		


}
