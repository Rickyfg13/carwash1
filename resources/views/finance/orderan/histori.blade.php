@extends('mobile.base')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-6 col-xs-12 px-0 mt-5">
    @php      
      $data_proses = $orderan->where('status', 0);   
      $data_selesai = $orderan->where('status', 1);
      $data_batal = $orderan->where('status', 2);
      // dd($data_proses);
    @endphp
    
    <div class="card border-0">
      <h3 class="card-header bg-primary text-center fixed-top text-white">Semua Orderan</h3>    
      <div class="card-body">
        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Proses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Selesai</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Batal</a>
          </li>
        </ul>       
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade py-2 show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            @forelse ($data_proses as $item)
            <div class="card mb-2">
              <div class="card-header">
                <i class="fa fa-calendar"></i> {{ tgl_indo($item->created_at) }} <div class="float-right"><div class="badge badge-primary"><i class="fa fa-spinner"></i> Diproses</div></div> 
              </div>
              <div class="card-body">            
                <table class="w-100">
                  <tr>
                    <th>No Order</th>
                    <td colspan="2">{{ $item->id }}</td>
                  </tr>
                  <tr>
                    <th>Nama</th>
                    <td colspan="2">{{ $item->nama }}</td>
                  </tr>
                  <tr>
                    <th>No Telp</th>
                    <td colspan="2">{{ '+62'.$item->nohp }}</td>
                  </tr>
                  <tr>
                    <th>No Kendaraan</th>
                    <td colspan="2">{{ $item->no_kendaraan }}</td>
                  </tr>
                  <tr>
                    <th>Merk Kendaraan</th>
                    <td colspan="2">{{ $item->merk }}</td>
                  </tr>
                  @php
                    $layanan = detailOrderan($item->id);
                    $gambar = gambarByOrderId($item->id);
                    $total = 0;
                    
                    for($i = 0; $i < count($layanan); $i++){
                      $total += $layanan[$i]->harga;
                      if ($i == 0){
                        echo "<tr>
                          <th>Layanan</th>
                          <td>".$layanan[$i]->nama_layanan."</td>
                          <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                        </tr>";
                      } else {
                        echo "<tr>
                          <th></th>
                          <td>".$layanan[$i]->nama_layanan."</td>
                          <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                        </tr>";
                      }
                    }
                  @endphp
                  <tr>
                    <td colspan="3"><hr class="pembatas-table"></td>
                  </tr>
                  <tr>
                    <th colspan="2" class="text-center">Total</th>
                    <td class="text-right">{{ rupiah($total) }}</td>
                  </tr>              
                </table>
                @if ($item->catatan != null)
                <hr>
                  <p class="notes"><b>Catatan</b> : {{ $item->catatan }}</p>
                @endif
                <div class="text-center mt-2">                  
                  <a href="{{ url('finance/updateStatus?id='.$item->id.'&permintaan=1') }}" class="btn btn-success btn-sm" style="padding:5px 10px;"><i class="fa fa-check"></i> SELESAIKAN</a>
                  <a href="https://wa.me/{{ substr_replace($item->nohp, "+62", 0, 1) }}?text=Yth Customer,%0a%0aBerikut Detail Order anda di HDCarwash, silahkan klik link dibawah : %0a{{ url('send/struk/'.$item->id) }} %0a%0aTerima Kasih %0a*HD CARWASH*" target="_blank" class="btn btn-outline-warning btn-sm" style="padding:5px 10px;"><i class="fa fa-whatsapp"></i> KIRIM PESAN</a>
                </div>  
				@if (count($gambar) > 0)
				<hr>
				<div class="row">
					@foreach ($gambar as $a => $g)
						<div class="col-md-6 mb-2">
							<img class="car-image-before-wash" src="{{ $g->path }}" alt="Gambar Mobil Sebelum Cuci">
						</div>
					@endforeach
				</div>
				
				@endif

				
              </div>
              
            </div> 
            @empty
            <div class="text-center">
              <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
            </div>
            <div class="alert alert-primary text-center">  Belum Ada Orderan yang Diproses</div>            
            @endforelse
            
    
          </div>

          <div class="tab-pane fade py-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            @forelse ($data_selesai as $item)
            <div class="card mb-2">
              <div class="card-header">
                <i class="fa fa-calendar"></i> {{ tgl_indo($item->created_at) }} <div class="float-right"><div class="badge badge-success"><i class="fa fa-check"></i> selesai</div></div> 
              </div>
              <div class="card-body">            
                <table class="w-100">
                  <tr>
                    <th>No Order</th>
                    <td colspan="2">{{ $item->id }}</td>
                  </tr>
                  <tr>
                    <th>Nama</th>
                    <td colspan="2">{{ $item->nama }}</td>
                  </tr>
                  <tr>
                    <th>No Telp</th>
                    <td colspan="2">{{ '+62'.$item->nohp }}</td>
                  </tr>
                  <tr>
                    <th>No Kendaraan</th>
                    <td colspan="2">{{ $item->no_kendaraan }}</td>
                  </tr>
                  <tr>
                    <th>Merk Kendaraan</th>
                    <td colspan="2">{{ $item->merk }}</td>
                  </tr>
                  @php
                    $layanan = detailOrderan($item->id);
					          $gambar = gambarByOrderId($item->id);
                    $numb = substr_replace($item->nohp, "+62", 0, 1);
                    $total = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $total += $layanan[$i]->harga;
                      if ($i == 0){
                        echo "<tr>
                          <th>Layanan</th>
                          <td>".$layanan[$i]->nama_layanan."</td>
                          <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                        </tr>";
                      } else {
                        echo "<tr>
                          <th></th>
                          <td>".$layanan[$i]->nama_layanan."</td>
                          <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                        </tr>";
                      }
                    }
                  @endphp
                  <tr>
                    <td colspan="3"><hr class="pembatas-table"></td>
                  </tr>
                  <tr>
                    <th colspan="2" class="text-center">Total</th>
                    <td class="text-right">{{ rupiah($total) }}</td>
                  </tr>              
                </table>
                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        @if ($item->catatan != null)
                        <p class="notes"><b>Catatan</b> : {{ $item->catatan }}</p>
                        @endif
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-sm-6">
                        <a target="_blank" href="{{url('send/kwitansi', $item->id)}}" class="btn btn-sm btn-success" style="padding: 5px 10px;">Print</a>
                        <a href="https://wa.me/{{ $numb }}?text=Yth Customer,%0a%0aKwitansi sudah bisa didownload, silahkan klik link dibawah : %0a{{ url('send/kwitansi/'.$item->id) }} %0a%0aJika ada kritik dan saran dengan senang hati kami akan menerima.%0aSemoga sehat selalu dan selamat sampai tujuan.%0aTerima Kasih %0a*HD CARWASH*" target="_blank" class="btn btn-outline-warning btn-sm" style="padding:5px 10px;"><i class="fa fa-whatsapp"></i> KIRIM PESAN</a>
                    </div>
                </div>
				@if (count($gambar) > 0)
				<hr>
				<div class="row">
					@foreach ($gambar as $a => $g)
						<div class="col-md-6 mb-2">
							<img class="car-image-before-wash" src="{{ $g->path }}" alt="Gambar Mobil Sebelum Cuci">
						</div>
					@endforeach
				</div>
				
				@endif
                
              </div>              
            </div>  
            @empty
            <div class="text-center">
              <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
            </div>
            <div class="alert alert-primary text-center">  Belum Ada Orderan yang Diselesaikan</div>
            @endforelse
          </div>

          <div class="tab-pane fade py-2" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            @forelse ($data_batal as $item)
            <div class="card mb-2">
              <div class="card-header">
                <i class="fa fa-calendar"></i> {{ tgl_indo($item->created_at) }} <div class="float-right"><div class="badge badge-danger"><i class="fa fa-spinner"></i> Dibatalkan</div></div> 
              </div>
              <div class="card-body">            
                <table class="w-100">
                  <tr>
                    <th>No Order</th>
                    <td colspan="2">{{ $item->id }}</td>
                  </tr>
                  <tr>
                    <th>Nama</th>
                    <td colspan="2">{{ $item->nama }}</td>
                  </tr>
                  <tr>
                    <th>No Telp</th>
                    <td colspan="2">{{ '+62'.$item->nohp }}</td>
                  </tr>
                  <tr>
                    <th>No Kendaraan</th>
                    <td colspan="2">{{ $item->nokendaraan }}</td>
                  </tr>
                  <tr>
                    <th>Merk Kendaraan</th>
                    <td colspan="2">{{ $item->merk }}</td>
                  </tr>
                  @php
                    $layanan = detailOrderan($item->id);
					$gambar = gambarByOrderId($item->id);
                    $total = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $total += $layanan[$i]->harga;
                      if ($i == 0){
                        echo "<tr>
                          <th>Layanan</th>
                          <td>".$layanan[$i]->nama_layanan."</td>
                          <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                        </tr>";
                      } else {
                        echo "<tr>
                          <th></th>
                          <td>".$layanan[$i]->nama_layanan."</td>
                          <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                        </tr>";
                      }
                    }
                  @endphp
                  <tr>
                    <td colspan="3"><hr class="pembatas-table"></td>
                  </tr>
                  <tr>
                    <th colspan="2" class="text-center">Total</th>
                    <td class="text-right">{{ rupiah($total) }}</td>
                  </tr>              
                </table>
                @if ($item->catatan != null)
                <hr>
                  <p class="notes"><b>Catatan</b> : {{ $item->catatan }}</p>
                @endif
                <div class="text-center mt-2">
                  <a href="{{ url('/finance/updateStatus?id='.$item->id.'&permintaan=0') }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Proses Sekarang</a>
                </div>

				@if (count($gambar) > 0)
				<hr>
				<div class="row">
					@foreach ($gambar as $a => $g)
						<div class="col-md-6 mb-2">
							<img class="car-image-before-wash" src="{{ $g->path }}" alt="Gambar Mobil Sebelum Cuci">
						</div>
					@endforeach
				</div>
				
				@endif
              </div>              
            </div>  
            @empty
            <div class="text-center">
              <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
            </div>
            <div class="alert alert-primary text-center">  Belum Ada Orderan yang Dibatalkan</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
@endsection