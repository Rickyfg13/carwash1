@extends('mobile.base')

@section('content')
  <div class="container">
    <div class="card mt-5 mb-5">
      <h3 class="card-header bg-primary text-white fixed-top">
        <i class="fa fa-file-text-o"></i> Laporan Pendapatan
      </h3>
      <div class="card-body">
        <form action="{{ url('finance/pendapatan/filter') }}" method="post">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-4">
              Tampilkan Data Berdasarkan Rentang Tanggal
            </div>
            <div class="form-group col-md-3">
              <input type="date" name="tglmulai" id="tglmulai" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <input type="date" name="tglakhir" id="tglakhir" class="form-control">
            </div>
            <div class="form-group col-md-1">
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
          <li class="nav-item">
            <a href="#home4" class="nav-link" id="home4-tab" data-toggle="tab" role="tab" aria-controls="home4" aria-selected="true">Hidrolik 4</a>
          </li>
        </ul>
        
        @php
          //For ATTENTION! Update 5/12/2022
          //Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
          $data_hidrolik_1 = $orderan->where('hidrolik_id' , 1);
          $data_hidrolik_2 = $orderan->where('hidrolik_id' , 2);
          $data_hidrolik_3 = $orderan->where('hidrolik_id', 3);
          $data_hidrolik_4 = $orderan->where('hidrolik_id' , 4);

          $totalHidrolik1 = 0; $totalHidrolik2 = 0; $totalHidrolik3 = 0; $totalHidrolik4 = 0;
        @endphp

        <div class="tab-content">
          <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="table-responsive">
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
                  //For ATTENTION! Update 5/12/2022
                  //Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
                    $a++;
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
          </div>

          <div class="tab-pane" id="home2" role="tabpanel" aria-labelledby="home2-tab">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>No HP</th>
                  <th>Layanan</th>
                  <th>Status</th>
                  <th>Subtotal</th>
                </tr>
                @php
                  $d2aNumber = 1;
                @endphp
                @forelse ($data_hidrolik_2 as $a => $item)
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
                    <td>{{ $d2aNumber++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ "+62".$item->nohp }}</td>
                    <td>
                      @php
                      $subTotal = 0;
                      for($i = 0; $i < count($layanan); $i++)
                      {
                        $subTotal += $layanan[$i]->harga;

                        if ($i != (count($layanan) - 1))
                          {
                            echo $layanan[$i]->nama_layanan.", ";
                          } 
                        else {
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
          </div>

          <div class="tab-pane" id="home3" role="tabpanel" aria-labelledby="home3-tab">
            <div class="table-responsive">
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
                    } else if ($item->status == 2){
                      $status = 'Antre';
                    } else {
                      $status = 'Finishing';
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

          <div class="tab-pane" id="home4" role="tabpanel" aria-labelledby="home4-tab">
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>No HP</th>
                  <th>Layanan</th>
                  <th>Status</th>
                  <th>Subtotal</th>
                </tr>
  
                @forelse ($data_hidrolik_4 as $a => $item)
                  @php
                  //For ATTENTION! Update 5/12/2022
                  //Status, 2 = Antri, 1 = selesai , 0 = proses, 3 = finishing.
                    $a++;
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
  
                      $totalHidrolik4 += $subTotal;
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
                  <th>{{ rupiah($totalHidrolik4) }}</th>
                </tr>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection