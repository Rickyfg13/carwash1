@extends('mobile.base')

@section('content')
<meta http-equiv="refresh" content="10000">

<div class="row justify-content-center">
  <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-6 col-xs-12 px-0 mt-5">
    @php
    // $data_proses = $orderan->where('status', 0);
    // $data_selesai = $orderan->where('status', 1);
    // $data_batal = $orderan->where('status', 2);
    // dd($data_proses);
    @endphp

    <div class="card border-0">
      <h3 class="card-header bg-primary text-center fixed-top text-white">Semua Orderan</h3>
    
      <div class="card-body">
  
        <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade py-2 show active" id="home" role="tabpanel" aria-labelledby="home-tab">
           
           
          @forelse ($orderan as $item)
              @if($item->hidrolik_id == 1 )
              <div class="container">
                  <div class="  bg-dark text-white">
                    <div class="card-body">             
                        <h5 class="card-title fw-bold text-uppercase" style="font-size: 20px;">{{ $item->merk }}</h5>
                        <p class="card-title fw-bold text-uppercase text-center" style="font-size: 150px;">{{ $item->no_kendaraan }}</p>
                        <div id="timer" class="card-title fw-bold text-uppercase text-center"></div>
                    </div>
                    @endif
                    </div>
                    @empty
              </div>
             
              {{-- <div class="text-center">
              <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
              </div>
              <div class="alert alert-primary text-center"> Belum Ada Orderan yang Diproses Hari Ini</div> --}}
            @endforelse

            @forelse ($orderan as $item)
              @if($item->hidrolik_id == 2 )
              <div class="card mb-2  bg-dark text-white">
              <div class="card-header">
              </div>
              <div class="card-body">             
                  <h5 class="card-title fw-bold text-uppercase" style="font-size: 20px;">{{ $item->merk }}</h5>
                  <p class="card-title fw-bold  text-uppercase text-center" style="font-size: 50px;">{{ $item->no_kendaraan }}</p>
                  <div id="timer1" class="card-title fw-bold text-uppercase text-center"></div>
              </div>
              @endif
              </div>
              @empty
              <div class="text-center">
              <div class="info-circle bg-warning text-white"><i class="fa fa-info"></i></div>
              </div>
              <div class="alert alert-primary text-center"> Belum Ada Orderan yang Diproses Hari Ini</div>
            @endforelse

        </div>
        </div>
    </div>  
     

    </div>

  </div>
</div>
<script>
  var seconds = 0;
  var minutes = 0;
  var hours = 0;

  function updateTimer() {
    seconds++;
    if (seconds >= 60) {
      seconds = 0;
      minutes++;
      if (minutes >= 60) {
        minutes = 0;
        hours++;
      }
    }

    document.getElementById('timer').innerHTML = hours + ' hours ' + minutes + ' minutes ' + seconds + ' seconds';
    document.getElementById('timer1').innerHTML = hours + ' hours ' + minutes + ' minutes ' + seconds + ' seconds';
  }

  setInterval(updateTimer,400);
</script>
@endsection