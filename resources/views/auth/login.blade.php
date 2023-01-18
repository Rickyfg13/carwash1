@extends('mobile.base')

@section('content')
<div class="row justify-content-md-center">
  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
    <div class="card mt-5">
      <h3 class="card-header text-center bg-primary text-white fixed-top">
         <i class="fa fa-sign-in"></i> Login
      </h3>
      <div class="card-body pt-3 mt-5">
        <div class="text-center">
          <img src="{{ asset('img/logo1.png') }}" alt="Logo" class="login-logo">
        </div>
        <form action="{{ route('login.check') }}" method="post" class="mt-3">
          @csrf
          <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" id="email" class="form-control" style="padding:12px; border-radius:5px" placeholder="Masukkan Email">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="password" class="form-control" style="padding:12px; border-radius:5px" placeholder="Masukkan Password">
          </div>
          <div class="form-group">
            <button class="btn btn-primary btn-block" style="padding:12px; border-radius:5px" name="kirim" type="submit">MASUK</button>
          </div>    
        </form>
      </div>
    </div>
  </div>
</div>
@endsection