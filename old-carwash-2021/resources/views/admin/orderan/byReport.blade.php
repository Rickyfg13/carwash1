@extends('admin.base')

@section('content')
  <div class="container">
    <div class="card mt-5">
      <h3 class="card-header bg-primary text-white">
        <i class="fa fa-file-text-o"></i> Laporan Pendapatan
      </h3>
      <div class="card-body">
        <form action="{{ url('admin/pendapatan/filter') }}" method="post">
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
            <a href="#home" class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Hidrolik 1</a>
          </li>
          <li class="nav-item">
            <a href="#home2" class="nav-link" id="home2-tab" data-toggle="tab" role="tab" aria-controls="home2" aria-selected="true">Hidrolik 2</a>
          </li>
          <li class="nav-item">
            <a href="#home3" class="nav-link" id="home3-tab" data-toggle="tab" role="tab" aria-controls="home3" aria-selected="true">Hidrolik 3</a>
          </li>
        </ul>
        @php
          $data_hidrolik_1 = $orderan->where('hidrolik_id', 1);
          $data_hidrolik_2 = $orderan->where('hidrolik_id', 2);
          $data_hidrolik_3 = $orderan->where('hidrolik_id', 3);

          $totalHidrolik1 = 0; $totalHidrolik2 = 0; $totalHidrolik3 = 0;
        @endphp

        <div class="tab-content">
          <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="table">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Subtotal</th>
              </tr>

              @forelse ($data_hidrolik_1 as $a => $item)
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
                  <td>{{ "+62".$item->nohp }}</td>
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

                    $totalHidrolik1 += $subTotal;
                  @endphp
                  </td>
                  <td>{{ $status }}</td>
                  <td>{{ rupiah($subTotal) }}</td>
                </tr>
              @empty
                <tr>
                  <th colspan="6"><p class="text-center text-warning">Belum Ada Data</p></th>
                </tr> 
              @endforelse
              <tr>
                <th colspan="4"></th>
                <th>Total</th>
                <th>{{ rupiah($totalHidrolik1) }}</th>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="home2" role="tabpanel" aria-labelledby="home2-tab">
            <table class="table">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Subtotal</th>
              </tr>

              @forelse ($data_hidrolik_2 as $a => $item)
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
                  <td>{{ "+62".$item->nohp }}</td>
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

                    $totalHidrolik2 += $subTotal;
                  @endphp
                  </td>
                  <td>{{ $status }}</td>
                  <td>{{ rupiah($subTotal) }}</td>
                </tr>
              @empty
                <tr>
                  <th colspan="6"><p class="text-center text-warning">Belum Ada Data</p></th>
                </tr> 
              @endforelse
              <tr>
                <th colspan="4"></th>
                <th>Total</th>
                <th>{{ rupiah($totalHidrolik2) }}</th>
              </tr>
            </table>
          </div>
          <div class="tab-pane" id="home3" role="tabpanel" aria-labelledby="home3-tab">
            <table class="table">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Subtotal</th>
              </tr>

              @forelse ($data_hidrolik_3 as $a => $item)
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
                  <td>{{ "+62".$item->nohp }}</td>
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

                    $totalHidrolik3 += $subTotal;
                  @endphp
                  </td>
                  <td>{{ $status }}</td>
                  <td>{{ rupiah($subTotal) }}</td>
                </tr>
              @empty
                <tr>
                  <th colspan="6"><p class="text-center text-warning">Belum Ada Data</p></th>
                </tr> 
              @endforelse
              <tr>
                <th colspan="4"></th>
                <th>Total</th>
                <th>{{ rupiah($totalHidrolik3) }}</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection