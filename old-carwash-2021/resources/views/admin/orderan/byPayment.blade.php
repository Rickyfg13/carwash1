@extends('admin.base')

@section('content')
<div class="container">
  <div class="card mt-5">
    <h3 class="card-header bg-primary text-white"> <i class="fa fa-money"></i> Payment Method</h3>
    <div class="card-body">
      <form action="{{ url('admin/payment/filter') }}" method="post">
        @csrf
        <div class="form-row">
          @php
            if (isset($tanggal) || (isset($tglmulai) && isset($tglakhir))){
              echo '<div class="col-2">Hasil Filter Data Orderan</div>';
              if (isset($tanggal)){
                echo 'Tanggal '.date('Y-m-d', strtotime($tanggal));
              } else if (isset($tglmulai) && isset($tglakhir)){
                echo 'Tanggal '.date('d-m-Y', strtotime($tglmulai)).' sampai dengan Tanggal '.date('d-m-Y', strtotime($tglakhir));      
              }
            }
          @endphp
          <div class="col">Tampilkan Data Berdasarkan Rentang Tanggal</div>
          <div class="col">
            <input type="date" name="tglmulai" id="tglmulai" class="form-control">
          </div>
          <div class="col">
            <input type="date" name="tglakhir" id="tglakhir" class="form-control">
          </div>
          <div class="col-1">
            <button type="submit" class="btn btn-danger">Tampilkan</button>
          </div>
        </div>
      </form>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Semua</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="false">Cash</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="edisi-tab" data-toggle="tab" href="#edisi" role="tab" aria-controls="edisi" aria-selected="false">Edisi</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" id="transfer-tab" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="false">Transfer</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" id="kepeng-tab" data-toggle="tab" href="#kepeng" role="tab" aria-controls="kepeng" aria-selected="false">Kepeng</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" id="hutang-tab" data-toggle="tab" href="#hutang" role="tab" aria-controls="hutang" aria-selected="false">Hutang</a>
        </li>        
      </ul>
      @php        
        $data_cash = $orderan->where('metode_pembayaran', 1);
        $data_edisi = $orderan->where('metode_pembayaran', 2);
        $data_transfer = $orderan->where('metode_pembayaran', 3);
        $data_kepeng = $orderan->where('metode_pembayaran', 4);
        $data_hutang = $orderan->where('metode_pembayaran', 5);
        
        $allTotal = 0; $totalCash = 0; $totalEdisi = 0; $totalTransfer = 0; $totalKepeng = 0; $totalHutang = 0;

        function setPayMethod($method_code){
          if ($method_code == 1){
            return "Cash/Tunai";
          } else if ($method_code == 2){
            return "Edisi";
          } else if ($method_code == 3){
            return "Transfer";
          } else if ($method_code == 4){
            return "Kepeng";
          } else {
            return "Hutang";
          }
        }
        
      @endphp
      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">            
          <table class="table">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No HP</th>
              <th>No Kendaraan</th>
              <th>Merk</th>
              <th>Layanan</th>
              <th>Metode Pembayaran</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            
            @forelse ($orderan as $key => $item)
              @php       
                $key += 1;                           
                $layanan = detailOrderan($item->id);
                $status = null;
                if ($item->status == 0){
                  $status = 'Diproses';
                } else if ($item->status == 1){
                  $status = 'Diselesaikan';
                } else {
                  $status = 'Dibatalkan';
                }
                
              @endphp
              <tr>
                <td>{{ $key++ }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ '+62'.$item->nohp }}</td>
                <td>{{ $item->no_kendaraan }}</td>
                <td>{{ $item->merk }}</td>
                <td>
                  @php
                    $subTotal = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $subTotal += $layanan[$i]->harga;
                      if($i != (count($layanan) - 1)){
                        echo $layanan[$i]->nama_layanan.", ";
                      } else {
                        echo $layanan[$i]->nama_layanan;
                      }
                    }

                    $allTotal += $subTotal;
                  @endphp
                </td>
                <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                <td>{{ $status }}</td>
                <td>{{ rupiah($subTotal) }}</td>
              </tr>
              
            @empty 
              <tr>
                <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
              </tr>
            @endforelse            
              <tr>
                <th colspan="7"></th>
                <th>Total</th>
                <td>{{ rupiah($allTotal) }}</td>
              </tr>
          </table>
        </div>

        <div class="tab-pane" id="cash" role="tabpanel" aria-labelledby="cash-tab">
          <table class="table">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No HP</th>
              <th>No Kendaraan</th>
              <th>Merk</th>
              <th>Layanan</th>
              <th>Metode Pembayaran</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            
            @forelse ($data_cash as $a => $item)
            @php
              $a +=1;
              
              $status = null;
                if ($item->status == 0){
                  $status = 'Diproses';
                } else if ($item->status == 1){
                  $status = 'Diselesaikan';
                } else {
                  $status = 'Dibatalkan';
                }
            @endphp
              <tr>
                <td>{{ $a++ }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ '+62'.$item->nohp }}</td>
                <td>{{ $item->no_kendaraan }}</td>
                <td>{{ $item->merk }}</td>
                <td>
                  @php
                    $subTotal = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $subTotal += $layanan[$i]->harga;
                      if($i != (count($layanan) - 1)){
                        echo $layanan[$i]->nama_layanan.", ";
                      } else {
                        echo $layanan[$i]->nama_layanan;
                      }
                    }

                    $totalCash += $subTotal;
                  @endphp
                </td>
                <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                <td>{{ $status }}</td>
                <td>{{ rupiah($subTotal) }}</td>
              </tr>
            @empty 
              <tr>
                <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
              </tr>
            @endforelse
            <tr>
              <th colspan="7"></th>
              <th>Total</th>
              <td>{{ rupiah($totalCash) }}</td>
            </tr>
          </table>
        </div>

        <div class="tab-pane" id="edisi" role="tabpanel" aria-labelledby="edisi-tab">
          <table class="table">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No HP</th>
              <th>No Kendaraan</th>
              <th>Merk</th>
              <th>Layanan</th>
              <th>Metode Pembayaran</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            
            @forelse ($data_edisi as $a => $item)
            @php
              $a++;
              
              $status = null;
                if ($item->status == 0){
                  $status = 'Diproses';
                } else if ($item->status == 1){
                  $status = 'Diselesaikan';
                } else {
                  $status = 'Dibatalkan';
                }
            @endphp
            
              <tr>
                <td>{{ $a }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ '+62'.$item->nohp }}</td>
                <td>{{ $item->no_kendaraan }}</td>
                <td>{{ $item->merk }}</td>  
                <td>
                  @php
                    $subTotal = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $subTotal += $layanan[$i]->harga;
                      if($i != (count($layanan) - 1)){
                        echo $layanan[$i]->nama_layanan.", ";
                      } else {
                        echo $layanan[$i]->nama_layanan;
                      }
                    }

                    $totalEdisi += $subTotal;
                  @endphp
                </td> 
                <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                <td>{{ $status }}</td>               
                <td>{{ rupiah($subTotal) }}</td>
              </tr>
            @empty 
              <tr>
                <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
              </tr>
            @endforelse
            <tr>
              <th colspan="7"></th>
              <th>Total</th>
              <td>{{ rupiah($totalEdisi) }}</td>
            </tr>
          </table>
        </div>

        <div class="tab-pane" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
          <table class="table">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No HP</th>
              <th>No Kendaraan</th>
              <th>Merk</th>
              <th>Layanan</th>
              <th>Metode Pembayaran</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            
            @forelse ($data_transfer as $a => $item)
            @php
              $a++;
              
              $status = null;
                if ($item->status == 0){
                  $status = 'Diproses';
                } else if ($item->status == 1){
                  $status = 'Diselesaikan';
                } else {
                  $status = 'Dibatalkan';
                }
            @endphp
            
              <tr>
                <td>{{ $a }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ '+62'.$item->nohp }}</td>
                <td>{{ $item->no_kendaraan }}</td>
                <td>{{ $item->merk }}</td>   
                <td>
                  @php
                    $subTotal = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $subTotal += $layanan[$i]->harga;
                      if($i != (count($layanan) - 1)){
                        echo $layanan[$i]->nama_layanan.", ";
                      } else {
                        echo $layanan[$i]->nama_layanan;
                      }
                    }

                    $totalTransfer += $subTotal;
                  @endphp
                </td>
                <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                <td>{{ $status }}</td>               
                <td>{{ rupiah($item->harga) }}</td>
              </tr>
            @empty 
              <tr>
                <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
              </tr>
            @endforelse
            <tr>
              <th colspan="7"></th>
              <th>Total</th>
              <td>{{ rupiah($totalTransfer) }}</td>
            </tr>
          </table>
        </div>

        <div class="tab-pane" id="kepeng" role="tabpanel" aria-labelledby="kepeng-tab">
          <table class="table">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No HP</th>
              <th>No Kendaraan</th>
              <th>Merk</th>
              <th>Layanan</th>
              <th>Metode Pembayaran</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            
            @forelse ($data_kepeng as $a => $item)
            @php
              $a++;
              
              $status = null;
                if ($item->status == 0){
                  $status = 'Diproses';
                } else if ($item->status == 1){
                  $status = 'Diselesaikan';
                } else {
                  $status = 'Dibatalkan';
                }
            @endphp
            
              <tr>
                <td>{{ $a }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ '+62'.$item->nohp }}</td>
                <td>{{ $item->no_kendaraan }}</td>
                <td>{{ $item->merk }}</td>   
                <td>
                  @php
                    $subTotal = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $subTotal += $layanan[$i]->harga;
                      if($i != (count($layanan) - 1)){
                        echo $layanan[$i]->nama_layanan.", ";
                      } else {
                        echo $layanan[$i]->nama_layanan;
                      }
                    }

                    $totalKepeng += $subTotal;
                  @endphp
                </td>
                <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                <td>{{ $status }}</td>               
                <td>{{ rupiah($subTotal) }}</td>
              </tr>
            @empty 
              <tr>
                <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
              </tr>
            @endforelse
            <tr>
              <th colspan="7"></th>
              <th>Total</th>
              <td>{{ rupiah($totalKepeng) }}</td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="hutang" role="tabpanel" aria-labelledby="hutang-tab">
          <table class="table">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No HP</th>
              <th>No Kendaraan</th>
              <th>Merk</th>
              <th>Layanan</th>
              <th>Metode Pembayaran</th>
              <th>Status</th>
              <th>Total</th>
            </tr>
            
            @forelse ($data_hutang as $a => $item)
            @php
              $a++;
              
              $status = null;
                if ($item->status == 0){
                  $status = 'Diproses';
                } else if ($item->status == 1){
                  $status = 'Diselesaikan';
                } else {
                  $status = 'Dibatalkan';
                }
            @endphp
            
              <tr>
                <td>{{ $a }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ '+62'.$item->nohp }}</td>
                <td>{{ $item->no_kendaraan }}</td>
                <td>{{ $item->merk }}</td>   
                <td>
                  @php
                    $subTotal = 0;
                    for($i = 0; $i < count($layanan); $i++){
                      $subTotal += $layanan[$i]->harga;
                      if($i != (count($layanan) - 1)){
                        echo $layanan[$i]->nama_layanan.", ";
                      } else {
                        echo $layanan[$i]->nama_layanan;
                      }
                    }

                    $totalHutang += $subTotal;
                  @endphp
                </td>
                <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                <td>{{ $status }}</td>               
                <td>{{ rupiah($subTotal) }}</td>
              </tr>
            @empty 
              <tr>
                <th colspan="9"><p class="text-center text-warning">Belum Ada Data</p></th>
              </tr>
            @endforelse
            <tr>
              <th colspan="7"></th>
              <th>Total</th>
              <td>{{ rupiah($totalHutang) }}</td>
            </tr>
          </table>
        </div>

        
      </div>
    </div>
  </div>
</div>
    
@endsection