@extends('mobile.base')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-6 col-xs-12 px-0 mt-5">
    @php
    // $data_proses = $orderan->where('status', 0);
    // $data_selesai = $orderan->where('status', 1);
    // $data_batal = $orderan->where('status', 2);
    // dd($data_proses);
    @endphp

  <div class="card border-0">
    <h3 class="card-header bg-primary text-center fixed-top text-white">Pilih Hidrolik</h3>
    <div class="card-body">
      <ul class="nav nav-tabs justify-content-center" id="myTab">
        <li class="nav-item">
         
        </li>
       
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade py-2 show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <form action="{{ route('update.hidrolik',$orderan->id) }}" method="post" >
                @csrf
                <label for="">Pilih Hidrolik</label>
                <div class="form-group">
                   <select name="hidrolik_id" id="select-member" class="form-control" >
                    @foreach($hidrolik as $item)
                    <option value="{{ old('id') ? old ('id') : $item->id }}">
                        {{ $item->keterangan }}
                    </option>
                    @endforeach
                   </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  </div>
</div>
@endsection