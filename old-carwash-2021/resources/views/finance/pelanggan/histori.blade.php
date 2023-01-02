@extends('mobile.base')

@section('content')
  <section class="history">
    <div class="row justify-content-center">
      <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-6 col-xs-12 mb-3 px-0">
        <div class="card border-0 px-0">
          <h3 class="card-header text-center bg-primary text-white fixed-top">Histori Orderan</h3>
          
          <div class="card-body mt-5">
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
            @php
              // Pengelompokkan Data Berdasakan Status
              $orderan_proses = $pelanggan_history->where('status', 0);
              $orderan_selesai = $pelanggan_history->where('status', 1);
              $orderan_batal = $pelanggan_history->where('status', 2);
            @endphp
            <div class="tab-content py-2" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">                
                @forelse ($orderan_proses as $item)
                <div class="card mb-2">
                  <div class="card-header">
                    <i class="fa fa-calendar"></i> {{ $item->created_at }} <div class="float-right"><div class="badge badge-warning"><i class="fa fa-spinner"></i> Diproses</div></div> 
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
                        <td colspan="2">{{ "+62".$item->nohp }}</td>
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
                        $detail_orderan = detailOrderan($item->id);
                        $banyak_layanan = count($detail_orderan);                  
                        // dd($banyak_layanan);
                        $total = 0;
                        for($i = 0; $i < $banyak_layanan; $i++){
                          $total += $detail_orderan[$i]->harga;
                          if ($i == 0){
                              echo "<tr>
                                <th>Layanan</th>
                                <td>".$detail_orderan[$i]->nama_layanan."</td>
                                <td class='text-right'>".rupiah($detail_orderan[$i]->harga)."</td>
                              </tr>";
                              // echo "ini yang pertama";
                          } else {
                            echo "<tr>
                              <th></th>
                              <td>".$detail_orderan[$i]->nama_layanan."</td>
                              <td class='text-right'>".rupiah($detail_orderan[$i]->harga)."</td>
                            </tr>";
                            // echo "ini yang kedua";
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
                      <a href="{{ url('finance/updateStatus?id='.$item->id.'&permintaan=1') }}" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Selesaikan</a>
                    </div>  
                  </div>                  
                </div>
                @empty
                <div class="text-center">
                  <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
                </div>
                <div class="alert alert-primary text-center">  Belum Ada Orderan yang Diproses</div>
                @endforelse                
                
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                @forelse ($orderan_selesai as $item)
                <div class="card mb-2">
                  <div class="card-header">
                    <i class="fa fa-calendar"></i> {{ tgl_indo($item->created_at) }} <div class="float-right"><div class="badge badge-success"><i class="fa fa-check"></i> Diselesaikan</div></div> 
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
                        <td colspan="2">{{ "+62".$item->nohp }}</td>
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
                        $detail_orderan = detailOrderan($item->id);
                        $banyak_layanan = count($detail_orderan);                  
                        // dd($banyak_layanan);
                        $total = 0;
                        for($i = 0; $i < $banyak_layanan; $i++){
                          $total += $detail_orderan[$i]->harga;
                          if ($i == 0){
                              echo "<tr>
                                <th>Layanan</th>
                                <td>".$detail_orderan[$i]->nama_layanan."</td>
                                <td class='text-right'>".rupiah($detail_orderan[$i]->harga)."</td>
                              </tr>";
                              // echo "ini yang pertama";
                          } else {
                            echo "<tr>
                              <th></th>
                              <td>".$detail_orderan[$i]->nama_layanan."</td>
                              <td class='text-right'>".rupiah($detail_orderan[$i]->harga)."</td>
                            </tr>";
                            // echo "ini yang kedua";
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
                  </div>                  
                </div>
                @empty
                <div class="text-center">
                  <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
                </div>
                <div class="alert alert-primary text-center">  Belum Ada Orderan yang Diselesaikan</div>
                @endforelse
              </div>
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                @forelse ($orderan_batal as $item)
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
                        <td colspan="2">{{ "+62".$item->nohp }}</td>
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
                        $detail_orderan = detailOrderan($item->id);
                        $banyak_layanan = count($detail_orderan);                  
                        // dd($banyak_layanan);
                        $total = 0;
                        for($i = 0; $i < $banyak_layanan; $i++){
                          $total += $detail_orderan[$i]->harga;
                          if ($i == 0){
                              echo "<tr>
                                <th>Layanan</th>
                                <td>".$detail_orderan[$i]->nama_layanan."</td>
                                <td class='text-right'>".rupiah($detail_orderan[$i]->harga)."</td>
                              </tr>";
                              // echo "ini yang pertama";
                          } else {
                            echo "<tr>
                              <th></th>
                              <td>".$detail_orderan[$i]->nama_layanan."</td>
                              <td class='text-right'>".rupiah($detail_orderan[$i]->harga)."</td>
                            </tr>";
                            // echo "ini yang kedua";
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
  </section>
@endsection