<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pencucian Mobil</title>
  <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap-mod-pulse.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font-awesome/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bootstrap/css/style.css') }}">
  <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png" sizes="16x16">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body >
  



<meta http-equiv="refresh" content="10000">

  @forelse ($orderan as $item)
  @if($item->hidrolik_id == 4 )
      <div class="card card-fluid bg-dark text-warning" >
        <div class="card-body " style="margin-top: 5cm;" >             
            <h5 class="card-title fw-bold text-uppercase text-center" style="font-size: 80px;">{{ $item->merk }}</h5>
            <p class="card-title fw-bold text-uppercase text-center" style="font-size: 200px;">{{ $item->no_kendaraan }}</p>
            <div id="timer" class="card-title fw-bold text-uppercase text-center" style="font-size: 50px;"></div>
        </div>
        @endif
        </div>
        @empty
  @endforelse




<div class="row justify-content-center">
  <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-6 col-xs-12 px-0 mt-5">
    @php
    // $data_proses = $orderan->where('status', 0);
    // $data_selesai = $orderan->where('status', 1);
    // $data_batal = $orderan->where('status', 2);
    // dd($data_proses);
    @endphp

    <div class="card border-0">
      <h3 class="card-header bg-primary text-center fixed-top text-white">Proses Cuci</h3>
    
      
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
  }

  setInterval(updateTimer,400);
</script>

</div>

<script src="{{ asset('bootstrap/js/jquery-3.0.0.js') }}"></script>
<script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

@stack('custom-script')
</body>
</html>