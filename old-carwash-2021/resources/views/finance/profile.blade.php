@extends('mobile.base')

@section('content')
<section class="profile">
  <div class="row justify-content-center">
    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 mb-3 px-0">        
      <div class="card border-0 px-0">
        <h3 class="card-header text-center bg-primary text-white fixed-top">Profile</h3>
        <div class="card-body mt-5">
          <img src="{{ asset('img/man.png') }}" alt="Profile Image" class="profile-img">
          <table class="w-100">
            <tr>
              <th>Nama</th>
              <td>{{ $data_user->nama }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $data_user->email }}</td>
            </tr>           
            <tr>                
              <td colspan="2"> <a href="{{ url('/logout') }}" class="btn btn-outline-danger mt-2"><i class="fa fa-sign-out"></i>  Keluar</a></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection