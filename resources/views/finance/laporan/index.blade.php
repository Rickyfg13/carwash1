@extends('mobile.base')

@section('content')
<div class="container">
  <div class="card mt-5 md-5">
    <div class="card-body">
      <div class="card border-0">
        <h3 class="card-header bg-primary text-center fixed-top text-white">Laporan Orderan Harian</h3>
        <div class="card-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a href="#home" class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Harian</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('lap.bul') }}" class="nav-link" id="home2-tab" >Bulanan</a>
              </li>
          </ul>
  
          <div class="tab-content">
              {{-- Laporan Harian --}}
              <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="mb-2">
                  <form method="get" action="" class="form-inline float-right" style="margin-bottom: 10px; ">
                    <div class="input-group">
                        <input class="form-control date" type="date" name="tanggal" id="tanggal" value="{{$today}}" style ='margin-right:10px;'>
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-outline-primary ">Telusuri</button>
                        </div>
                    </div>
                  </form>
                </div>
                @php
                    $total = 0 ;
                @endphp
              
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Layanan</th>
                        <th>Hidrolik</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                      </tr>
        
                    @forelse ($laporan as $no => $item)
                        @php
                        //For ATTENTION! Update 5/12/2022
                        //Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
                          
                          $layanan = detailOrderan($item->id);
                          $status = null;
                          if ($item->status == 0){
                            $status = 'Diproses';
                          } else if ($item->status == 1){
                            $status = 'Diselesaikan';
                          } else if ($item->status == 2){
                            $status = 'Antre';
                          } else {
                            $status = 'Finishing';
                          }
                        @endphp
                        <tr>
                          <td>{{ $no+1 }}</td>
                          <td>{{ $item->nama }}</td>
                          <td>{{ "+62".$item->nohp }}</td>
                          <td>
                              @php
                          
                              $subTotal = 0;
                              for($i = 0; $i < count($layanan); $i++)
                              {
                                  $subTotal += $layanan[$i]->harga;
  
                                  if($i != (count($layanan) - 1))
                                  {
                                  echo $layanan[$i]->nama_layanan.", ";
                                  } 
                                  else 
                                  {
                                  echo $layanan[$i]->nama_layanan;
                                  }
                              }
                                  
                              $total += $subTotal;
                              @endphp
                          </td>
                          <td>{{ $item->keterangan }}</td>
                          <td>{{ is_null($item->metode_pembayaran) ? '-' :
                            loadMetodePembayaran($item->metode_pembayaran) }}
                          </td>
                          <td>{{ $status }}</td>
                          <td>{{ rupiah($subTotal) }}</td>
                        </tr>
                      @empty 
                        <tr>
                          <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
                        </tr>
                      @endforelse
                      <tr>
                        <th colspan="6"></th>
                        <th>Total</th>
                        <th>{{ rupiah($total) }}</th>
                      </tr>
                    </table>
                  </div>
              </div>
  
           
  
              
          
              
          </div>
        </div>
      </div>
    </div>
   

  </div>
</div>
@endsection