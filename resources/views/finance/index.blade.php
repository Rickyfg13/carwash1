@extends('mobile.base')

@section('content')
  <section class="body mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-6 col-xs-12 px-0">
        <div class="card border-0 px-0">
          <h3 class="card-header text-center bg-primary text-white fixed-top">
            <i class="fa fa-search"></i> Cari 
          </h3>
          <div class="card-body mt-3">
            <form action="{{ url('/finance/pelanggan/cari') }}" method="POST">
              @csrf
              <div class="form-group">
                <label>Cari Pelanggan</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text">+62</div>
                  </span>
                  <input type="number" name="nohp" id="nohp" class="form-control" placeholder="Masukkan No HP/WhatsApp">
                </div>
              </div>
  
              <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">
                  Cari Sekarang
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection