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
<body>
  
  <div class="container">
    
    @yield('content')    
    
  </div>
  
  @auth
  {{-- Finance --}}
  @if (Auth::user()->akses == 2)
    <footer class="footer fixed-bottom bg-primary">
      <div class="container">
        <div class="menu">    
          <a href="{{ url('/finance/orderan') }}">
            <i class="fa fa-calendar-check-o"></i>
          </a>
          <a href="{{ url('/finance/pendapatan') }}">
            <i class="fa fa-money"></i>
          </a>
          <a href="{{ url('/finance/laporan') }}">
            <i class="fa fa-file-text-o"></i>
          </a>
          <a href="{{ url('/finance/cari') }}">
            <i class="fa fa-search"></i>
          </a>
          <a href="{{ url('/finance/home') }}">
            <i class="fa fa-user"></i>
          </a>
          
        </div>
      </div>
    </footer>
  @else
  {{-- User --}}
    <footer class="footer fixed-bottom bg-primary">
      <div class="container">
        <div class="menu">    
          <a href="{{ url('/user/orderan') }}">
            <i class="fa fa-calendar-check-o"></i>
          </a>
          <a href="{{ url('/user/orderan/baru') }}">
            <i class="fa fa-plus"></i>
          </a>
          <a href="{{ url('user/cari') }}">
            <i class="fa fa-search"></i>
          </a>
          <a href="{{ url('user/home') }}">
            <i class="fa fa-user"></i>
          </a>
          
        </div>
      </div>
    </footer>
  @endif
  @endauth
  
  <script src="{{ asset('bootstrap/js/jquery-3.0.0.js') }}"></script>
  <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

  @stack('custom-script')
</body>
</html>