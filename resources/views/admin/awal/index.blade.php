@extends('admin.base')
@section('content')
  <div class="container">
    <div class="card mt-5">
      <div class="card-header">
        Ini Halaman Admin
      </div>      
      @php
        // dd($jumlah_per_layanan)
      @endphp
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="card text-center">
              <div class="card-header bg-warning text-white">Semua Orderan</div>
              <div class="card-body">
                <h1>{{ $jumlah_semua_orderan }}</h1>
              </div>
            </div>
          </div>
          
          @forelse ($jumlah_per_layanan as $item)          
          <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="card text-center">
              <div class="card-header bg-warning text-white">{{ "Orderan ".$item['nama_layanan'] }}</div>
              <div class="card-body">
                <h1>{{ $item['jumlah'] }}</h1>
              </div>
            </div>
          </div>  
          @empty
            
          @endforelse
          <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="card text-center">
              <div class="card-header bg-warning text-white">Pemasukan</div>
              <div class="card-body">
                <h1>{{ rupiah($pemasukan) }}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection