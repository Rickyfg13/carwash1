@extends('mobile.base')

@section('content')
  <section class="body mt-3">
    <div class="row justify-content-center">
      <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 my-5 py-3">
        @if (count($orderan) == 0)
        <h3 class="text-center mb-3 d-block">Tidak Ada Hasil Pencarian untuk Nomor HP "<span class="text-primary">{{ '+62'.$nohp }}</span>"</h3>
        @else
          <h3 class="text-center mb-3 d-block">Hasil Pencarian Nomor HP "<span class="text-primary">{{ '+62'.$nohp }}</span>"</h3>
        @endif
        

        <table class="table">
          @foreach ($orderan as $item)
            <tr>
              <td>{{ $item->nama }}</td>
              <td align="right">{{ "+62".$item->nohp }}</td>
              <td width="20px">
                <a href="{{ url('/finance/pelanggan/histori/'.$item->id) }}" class="text-danger"> <i class="fa fa-search"></i> </a>
              </td>
            </tr>
          @endforeach
        </table>

        

        <div class="mt-5">
          <a href="{{ url('/finance/home') }}" class="btn btn-primary btn-block">Cari Lagi</a>
        </div>
      </div>
    </div>
  </section>
@endsection