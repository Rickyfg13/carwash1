<?php

use App\Models\Orderan;
use App\Models\DetailOrderan;
use App\Models\Gambar;

if (!function_exists('tgl_indo')) {
	function tgl_indo($date, $tipe = 'full')
	{

		$date = explode(' ', $date);

		$tanggal = explode('-', $date[0]);
		$tanggal = $tanggal[0] . ' ' . med_bulan($tanggal[1]) . ' ' . $tanggal[2];
		if ($tipe == "full") {
			$tanggal .= ' ' . $date[1];
		}
		return $tanggal;
	}
}

if (!function_exists('just_tgl')) {
	function just_tgl($date)
	{
		$date = explode(' ', $date);

		$tanggal = explode('-', $date[0]);
		$tanggal = $tanggal[0] . ' ' . med_bulan($tanggal[1]) . ' ' . $tanggal[2];
		return $tanggal;
	}
}

if (!function_exists('bulan')) {
	function bulan($month)
	{
		$namaBulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		$bulan = $namaBulan[intval($month)];
		return $bulan;
	}
}

if (!function_exists('med_bulan')) {
	function med_bulan($month)
	{
		$namaBulan = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nov', 'Des');
		$bulan = $namaBulan[intval($month)];
		return $bulan;
	}
}

if (!function_exists('rupiah')) {
	function rupiah($pitih)
	{
		$pitih = number_format($pitih, 0, ',', '.');
		return "Rp " . $pitih;
	}
}

if (!function_exists('nopesan')) {
	function nopesan($toko, $id, $tgl)
	{
		$tanggal = explode(' ', $tgl);
		$tanggal = explode('-', $tanggal[0]);

		$nopesan = $toko . '-' . $tanggal[1] . substr($tanggal[0], 2) . '-' . $id;

		return $nopesan;
	}
}

if (!function_exists('detailOrderan')) {
	function detailOrderan($orderan_id)
	{
		$detail_orderan = DetailOrderan::join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')
			->where('detail_orderan.orderan_id', $orderan_id)
			->select('layanan.nama_layanan', 'detail_orderan.layanan_detail', 'detail_orderan.harga')->get();
		return $detail_orderan;
	}
}

if (!function_exists('gambarByOrderId')) {
	function gambarByOrderId($orderan_id)
	{
		$gambar = Gambar::where('orderan_id', $orderan_id)
			->orWhereNull('orderan_id')
			->select('path')
			->get();

		return $gambar;
	}
}

if (!function_exists('orderanFullInfo')) {
	function orderanFullInfo($layanan_id)
	{
		$full = Orderan::join('pelanggan', 'pelanggan.id', '=', 'orderan.pelanggan_id')
			->join('detail_orderan', 'detail_orderan.orderan_id', '=', 'orderan.id')
			->join('layanan', 'layanan.id', '=', 'detail_orderan.layanan_id')
			->orderBy('orderan.created_at', 'DESC')
			->where('detail_orderan.layanan_id', $layanan_id)
			->select('orderan.id', 'pelanggan.nama', 'pelanggan.nohp', 'orderan.no_kendaraan', 'orderan.merk', 'detail_orderan.harga', 'orderan.status', 'orderan.metode_pembayaran')->get();
		return $full;
	}
}

if (!function_exists('loadMetodePembayaran')) {
	function loadMetodePembayaran($method)
	{
		$result = "Hutang";
		if ($method == 1) {
			$result = "Cash/Tunai";
		} else if ($method == 2) {
			$result = "Edisi";
		} else if ($method == 3) {
			$result = "Transfer";
		} else if ($method == 4) {
			$result = "Kepeng";
		}

		return $result;
	}
}

if (!function_exists('penyebut')) {
	function penyebut($nilai)
	{
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " " . $huruf[$nilai];
		} else if ($nilai < 20) {
			$temp = penyebut($nilai - 10) . " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
		}
		return $temp;
	}
}

if (!function_exists('terbilang')) {
	function terbilang($nilai)
	{
		if ($nilai < 0) {
			$hasil = "minus " . trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}
		return $hasil;
	}
}
