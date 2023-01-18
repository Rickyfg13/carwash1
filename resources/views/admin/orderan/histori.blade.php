@extends('admin.base')

@section('content')
  <div class="container">
    <div class="card mt-5">
      <h3 class="card-header bg-primary text-white"> <i class="fa fa-exchange"></i> Transaksi</h3>
      <div class="card-body">
        <form action="{{ url('admin/orderan/filter') }}" method="post">
          @csrf
          <div class="form-row">
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
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Salon</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Cuci</a>
          </li>        
        </ul>
        @php
          $data_cuci  = orderanFullInfo(1);
          $data_salon = orderanFullInfo(2);
          $allTotal = 0; $totalSalon = 0; $totalCuci = 0;

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
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
              @php
                $a = 0;
              @endphp
              @foreach ($orderan as $item)
                @php                  
                  $a++;
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
                    @endphp
                  </td>
                  <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                  <td>{{ $status }}</td>
                  <td>{{ rupiah($subTotal) }}</td>
                  <td>
                    @if ($item->status == 0)
                    <a href="{{ url('admin/updateStatus?id='.$item->id.'&permintaan=2') }}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Batalkan</a>
                    @endif
                  </td>
                </tr>
                @php
                  $allTotal += $subTotal;
                @endphp
              @endforeach
                <tr>
                  <th colspan="7"></th>
                  <th>Total</th>
                  <td>{{ rupiah($allTotal) }}</td>
                </tr>
            </table>
          </div>
          <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table class="table">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>No Kendaraan</th>
                <th>Merk</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
              @php
                $a = 0;
              @endphp
              @foreach ($data_salon as $item)
              @php
                $a++;
                $totalSalon += $item->harga;
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
                  <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                  <td>{{ $status }}</td>
                  <td>{{ rupiah($item->harga) }}</td>
                  <td>
                    @if ($item->status == 0)
                    <a href="{{ url('admin/updateStatus?id='.$item->id.'&permintaan=2') }}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Batalkan</a>
                    @endif
                  </td>
                </tr>
              @endforeach
              <tr>
                <th colspan="6"></th>
                <th>Total</th>
                <td>{{ rupiah($totalSalon) }}</td>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
            <table class="table">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>No Kendaraan</th>
                <th>Merk</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
              @php
                $a = 0;
              @endphp
              @foreach ($data_cuci as $item)
              @php
                $a++;
                $totalCuci += $item->harga;
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
                  <td>{{ setPayMethod($item->metode_pembayaran) }}</td>
                  <td>{{ $status }}</td>               
                  <td>{{ rupiah($item->harga) }}</td>
                  <td>
                    @if ($item->status == 0)
                    <a href="{{ url('admin/updateStatus?id='.$item->id.'&permintaan=2') }}" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Batalkan</a>
                    @endif
                  </td>
                </tr>
              @endforeach
              <tr>
                <th colspan="6"></th>
                <th>Total</th>
                <td>{{ rupiah($totalCuci) }}</td>
              </tr>
            </table>
          </div>
          
        </div>
      </div>
    </div>
  </div>    
@endsection