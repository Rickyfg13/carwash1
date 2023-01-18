<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orderan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\DetailOrderan;
use App\User;
use Auth;
use Carbon\Carbon;
use stdClass;
use Validator;

use App\Helper\PaginationHelper;
use App\Models\Gambar;

class ServiceController extends Controller
{

	// Menampilkan histori orderan berdasarkan id user
	function index()
	{
		$histori_orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('detail_orderan', 'orderan_id', '=', 'orderan.id')
			->join('layanan', 'layanan.id', '=', 'layanan_id')
			->where([
				['orderan.status', '=', 2],
				['orderan.user_id', '=', Auth::user()->id]
				// ['orderan.status', '=', 0],
				// ['orderan.user_id', '=', Auth::user()->id]
			])
			->orderBy('orderan.created_at', 'DESC')
			
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'layanan.nama_layanan as layanan ', 'detail_orderan.layanan_detail as nama_layanan' ,'orderan.catatan', 'detail_orderan.harga', 'orderan.status' , 'orderan.metode_pembayaran', 'orderan.created_at')
			->with('gambar')
			->paginate(20);

		return response()->json([
			'success' => true,
			'message' => 'Data Semua Orderan',
			'data_user' => Auth::user(),
			'histori_orderan' => $histori_orderan
		], 200);
	}

	function addOrderan(Request $request)
	{
		try {
			// Periksa apakah pelanggan sudah pernah mencuci sebelumnya
			if ($request->pelanggan_id == null || !isset($request->pelanggan_id) || $request->pelanggan_id == '') {
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
				'status' => 2
			]);

			$orderan_baru = Orderan::orderBy('created_at', 'DESC')->first();

			for ($i = 2; $i < count($request->layanan); $i++) {
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
					['orderan.status', '=', 2],
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
		} catch (\Throwable $th) {
			return response()->json([
				'success' => false,
				'message' => 'Terjadi Kesalahan' . $th
			]);
		}
	}

	function todayHistory()
	{
		$params = [
			['orderan.status', '=', 0],
			['orderan.user_id', '=', Auth::user()->id]
		];
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('detail_orderan', 'orderan_id', '=', 'orderan.id')
			->join('layanan', 'layanan.id', '=', 'layanan_id')
			->where($params)
			->whereDate('orderan.created_at', Carbon::today()->format('Y-m-d'))
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'layanan.nama_layanan as layanan ', 'detail_orderan.layanan_detail as nama_layanan' ,'orderan.catatan', 'detail_orderan.harga', 'orderan.status' , 'orderan.metode_pembayaran', 'orderan.created_at')
			->with('gambar')
			->paginate(20);

		return response()->json([
			'success' => true,
			'message' => 'orderan hari ini',
			'data_orderan' => $orderan,
		]);
	}

	function findingCustomer(Request $request)
	{
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
			->select('pelanggan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.catatan')->distinct()->get();

		return response()->json([
			'success' => true,
			'hasil_cari' => $orderan
		]);
	}


	function customerHistory(Request $request)
	{
		if (!$request->pelanggan_id) {
			return response()->json([
				'success' => false,
				'message' => 'Mohon kirimkan id pelanggan'
			], 400);
		}

		$pelanggan_history = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('detail_orderan', 'orderan_id', '=', 'orderan.id')
			->join('layanan', 'layanan.id', '=', 'layanan_id')
			->where('pelanggan_id', $request->pelanggan_id)
			// ->select('orderan.id', 'orderan.pelanggan_id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.status', 'orderan.catatan', 'orderan.created_at')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'layanan.nama_layanan as layanan ', 'detail_orderan.layanan_detail as nama_layanan' ,'orderan.catatan', 'detail_orderan.harga', 'orderan.status' , 'orderan.metode_pembayaran', 'orderan.created_at')
			->orderBy('orderan.created_at', 'DESC')
			->with('gambar')
			->paginate(20);
		// return response()->json($pelanggan_history);

		// $pelanggan_history_full = [];

		// foreach ($pelanggan_history as $key => $value) {
		// 	$pelanggan_history_full[$key] = $value;
		// 	$detail = $this->detailOrderan($value->id);
		// 	$pelanggan_history_full[$key]->layanan = $detail;
		// 	$pelanggan_history_full[$key]->gambar = $this->getGambarByOrderId($value->id);
		// }

		// $orderan_full = collect($pelanggan_history_full);
		// $orderan_full = PaginationHelper::paginate($orderan_full, 20);

		return response()->json([
			'success' => true,
			'message' => 'Histori Orderan Pelanggan',
			'data_orderan' => $pelanggan_history
		]);
	}

	function detailOrderan($orderan_id)
	{
		$detail_orderan = DetailOrderan::join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')
			->where('detail_orderan.orderan_id', $orderan_id)
			->select('layanan.nama_layanan', 'detail_orderan.layanan_detail', 'detail_orderan.harga')->get();
		return $detail_orderan;
	}

	function getGambarByOrderId($orderan_id) 
	{
		$gambar = Gambar::where('orderan_id', $orderan_id)
				->orWhereNull('orderan_id')
				->select('path')
				->get();

		return $gambar;
	}

	function uploadImage(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'orderan' => 'required|numeric',
			'gambar' => 'required',
			'gambar.*' => 'required'
		]);
		
		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'error' => $validator->errors()
			], 401);
		}


		try {
			$imgPath = 'img/upload/';

			if (!file_exists($imgPath)) {
				mkdir($imgPath, 0755, true);
			}

			$gambar = [];

			foreach ($request->gambar as $x => $v) {

				$image_parts = explode(";base64,", $v);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];
				$image_base64 = base64_decode($image_parts[1]);

				$filename = Carbon::now()->timestamp . '-' . uniqid() . '.' .
					$image_type;
				// $uploadedFile->move(public_path($imgPath), $filename);
				$final_filename = $imgPath . $filename;

				file_put_contents($final_filename, $image_base64);

				$gambar[$x] = [
					'orderan_id' => $request->orderan,
					'path' => $final_filename
				];
			}

			Gambar::insert($gambar);

			return response()->json([
				'success' => true,
				'message' => 'Gambar Berhasil Disimpan'
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

    public function uploadImage2(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'orderan' => 'required|numeric',
			'gambar' => 'required'
		]);
		
		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'error' => $validator->errors()
			], 401);
		}


		try {
			$imgPath = 'img/upload/';

			if (!file_exists($imgPath)) {
				mkdir($imgPath, 0755, true);
			}

			$gambar = $request->gambar;
			$image_parts = explode(";base64,", $gambar);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);

			$filename = Carbon::now()->timestamp . '-' . uniqid() . '.' .
				$image_type;			
			$final_filename = $imgPath . $filename;

			file_put_contents($final_filename, $image_base64);

			Gambar::create([
				'orderan_id' => $request->orderan,
				'path' => $final_filename
			]);

			return response()->json([
				'success' => true,
				'message' => 'Gambar Berhasil Disimpan'
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function deleteImage(Request $request) 
	{
		$validator = Validator::make($request->all(), [
			'gambar' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'error' => $validator->errors()
			], 401);
		}

		try {
			$gambar = Gambar::whereIn('id', $request->gambar);

			foreach ($gambar->get() as $x => $v) {
				if (file_exists($v->path)) {
					@unlink($v->path);
				}
			}

			$gambar->delete();

			return response()->json([
				'success' => true,
				'message' => 'Gambar berhasil dihapus'
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'success' => false,
				'message' => 'Gagal menghapus gambar'
			], 400);	
		}
	}

	public function uploadImage1(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'avatar' => 'required'
		]);

		return response()->json([
			'ukuran' => strlen($request->avatar)
		]);

		try {

			if ($request->avatar) {


				$img = $request->avatar;
				$folderPath = "images/users/"; //path location

				if (!file_exists($folderPath)) {
					mkdir($folderPath, 0755, true);
				}

				$image_parts = explode(";base64,", $img);
				// $image_type_aux = explode("image/", $image_parts[0]);
				// $image_type = $image_type_aux[1];
				// $image_base64 = base64_decode($image_parts[1]);
				// $uniqid = uniqid();
				// $file = $folderPath . $uniqid . '.'.$image_type;
				// file_put_contents($file, $image_base64);

				dd($image_parts);
			}

			return response()->json([
				'success' => true,
				'message' => 'Data Berhasil Disimpan'
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'success' => false,
				'message' => $e->getMessage()
			], 400);
		}
	}

	public function v2TodayHistory()
	{
		
		$params = [
			['orderan.status', '=', 0],
			['orderan.user_id', '=', Auth::user()->id]
		];
		$orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('detail_orderan', 'orderan_id', '=', 'orderan.id')
			->join('layanan', 'layanan.id', '=', 'layanan_id')
			->where($params)
			->whereDate('orderan.created_at', Carbon::today()->format('Y-m-d'))
			->orderBy('orderan.created_at', 'DESC')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp','orderan.hidrolik_id' ,'orderan.no_kendaraan', 'orderan.merk', 'layanan.nama_layanan as layanan ', 'detail_orderan.layanan_detail as nama_layanan' ,'orderan.catatan', 'detail_orderan.harga', 'orderan.status' , 'orderan.metode_pembayaran', 'orderan.created_at')
			->with('gambar')
			->paginate(20);

		return response()->json([
			'success' => true,
			'message' => 'orderan hari ini',
			'data_orderan' => $orderan,
		]);
	
	}

	public function v2CustomerHistory(Request $request)
	{
		if (!$request->pelanggan_id) {
			return response()->json([
				'success' => false,
				'message' => 'Mohon kirimkan id pelanggan'
			], 400);
		}

		$pelanggan_history = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('detail_orderan', 'orderan_id', '=', 'orderan.id')
			->join('layanan', 'layanan.id', '=', 'layanan_id')
			->where('pelanggan_id', $request->pelanggan_id)
			// ->select('orderan.id', 'orderan.pelanggan_id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'orderan.status', 'orderan.catatan', 'orderan.created_at')
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'layanan.nama_layanan as layanan ', 'detail_orderan.layanan_detail as nama_layanan' ,'orderan.catatan', 'detail_orderan.harga', 'orderan.status' , 'orderan.metode_pembayaran', 'orderan.created_at')
			->orderBy('orderan.created_at', 'DESC')
			->with('gambar')
			->paginate(20);

			return response()->json([
				'success' => true,
				'message' => 'Histori Orderan Pelanggan',
				'data_orderan' => $pelanggan_history
			]);
	}

	public function UbahStatus(Request $request, $id)
	{
		$today = Carbon::now()->toDateString();
		$orderan = Orderan::find($id);
		// $orderan = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
		// ->where('orderan.created_at', $today)
		// ->first();
		
		if ($orderan->status != $request->status){
			$orderan->status = $request->status;
			$orderan->update();
		}

		// For ATTENTION! Update 5/12/2022
		// Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
		// if (!$request->type || $request->type =='antri') {
		// 	$orderan = $orderan->where('status', 2)->where('orderan.created_at',$today);
		// } 
		// else if($request->type == 'proses'){
		// 	$orederan = $orderan->where('status',0)->where('orderan.created_at',$today);
		// }
		// else if ($request->type =='finishing' ){
		// 	$orderan = $orderan->where('status', 3 )->where('orderan.created_at',$today);
		// } 
		// else if ($request->type =='selesai'){
		// 	$orderan = $orderan->where('status', 1)->where('orderan.created_at',$today);
		// }
		
		$data = orderan::orderBy('orderan.created_at','DESC');

		return response()->json(['data' => $orderan]);
	
	}
}
