<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orderan;
use App\Models\Layanan;
use App\Models\DetailOrderan;

class DashboardController extends Controller
{
    //
    public function index(){			
			// dd(count(Orderan::join('detail_orderan', 'detail_orderan.orderan_id', '=', 'orderan.id')
								// ->join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')->get()));

				$jumlah_semua_orderan = DetailOrderan::all()->count();
				$layanan = Layanan::all();
				
				$jumlah_per_layanan = [];

				foreach($layanan as $key => $value) {
					$jumlah_per_layanan[$key] = [
						'nama_layanan' => $value->nama_layanan,
						'jumlah' => DetailOrderan::where('layanan_id', $value->id)->get()->count()
					];
				}

				$pemasukan = Orderan::join('detail_orderan', 'detail_orderan.orderan_id', '=', 'orderan.id')
										->where('status', 1)->sum('harga');

				// dd($pemasukan);

        return view('admin.awal.index', compact('jumlah_semua_orderan', 'jumlah_per_layanan', 'pemasukan'));
    }
}

