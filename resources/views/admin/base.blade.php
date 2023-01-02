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
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Car Wash</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{ url('/admin/home') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/orderan') }}">Orderan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/payment') }}">Payment Method</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/pendapatan') }}">Laporan Pendapatan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
        </li>        
      </ul>
    </div>
  </nav>

  

  @yield('content')


  <script src="{{ asset('bootstrap/js/jquery-3.0.0.js') }}"></script>
  <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>  

</body>
</html>