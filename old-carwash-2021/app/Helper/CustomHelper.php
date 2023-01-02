<?php

use App\Models\Orderan;
use App\Models\DetailOrderan;

if (! function_exists('tgl_indo')) {
	function tgl_indo($date , $tipe = 'full'){

		$date = explode(' ', $date);

		$tanggal = explode('-', $date[0]);
		$tanggal = $tanggal[0].' '.med_bulan($tanggal[1]).' '.$tanggal[2];
		if($tipe=="full"){
			$tanggal .= ' '.$date[1];
		}
		return $tanggal;
	}
}

if (! function_exists('bulan')) {
	function bulan($month){
		$namaBulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		$bulan = $namaBulan[intval($month)];
		return $bulan;
	}
}

if (! function_exists('med_bulan')) {
	function med_bulan($month){
		$namaBulan = array(1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sep','Okt','Nov','Des');
		$bulan = $namaBulan[intval($month)];
		return $bulan;
	}
}

if (! function_exists('rupiah')) {
	function rupiah($pitih){
		$pitih = number_format($pitih,0,',','.');
		return "Rp ".$pitih;
	}
}

if (! function_exists('nopesan')){
	function nopesan($toko, $id, $tgl){
		$tanggal = explode(' ', $tgl);
		$tanggal = explode('-', $tanggal[0]);

		$nopesan = $toko.'-'.$tanggal[1].substr($tanggal[0],2).'-'.$id;

		return $nopesan;
	}
}

if (! function_exists('detailOrderan')){
	function detailOrderan($orderan_id){
		$detail_orderan = DetailOrderan::join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')
											->where('detail_orderan.orderan_id', $orderan_id)
											->select('layanan.nama_layanan','detail_orderan.layanan_detail' ,'detail_orderan.harga')->get();
		return $detail_orderan;
	}
}

if (! function_exists('orderanFullInfo')){
	function orderanFullInfo($layanan_id){
		$full = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
						->join('detail_orderan', 'detail_orderan.orderan_id', '=', 'orderan.id')						
						->join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')
						->orderBy('orderan.created_at', 'DESC')
						->where('detail_orderan.layanan_id', $layanan_id)
						->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'detail_orderan.harga', 'orderan.status', 'orderan.metode_pembayaran')->get();
		return $full;
	}
}