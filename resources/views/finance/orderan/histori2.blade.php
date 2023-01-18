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
      <h3 class="card-header bg-primary text-center fixed-top text-white">Semua Orderan</h3>
      <div class="card-body">
        <ul class="nav nav-tabs justify-content-center" id="myTab">
          <li class="nav-item">
            <a class="nav-link @if (!request()->type) active @endif" id="home-tab"
              href="{{ url('/finance/orderan') }}">Antre
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (request()->type == 'proses') active @endif" id="profile-tab"
              href="{{ url('/finance/orderan?type=proses') }}">Proses
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (request()->type == 'finishing') active @endif" id="contact-tab"
              href="{{ url('/finance/orderan?type=finishing') }}">Finishing
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (request()->type == 'selesai') active @endif" id="setting-tab"
              href="{{ url('/finance/orderan?type=selesai') }}">Selesai
            </a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade py-2 show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            @forelse ($orderan as $item)
            <div class="card mb-2">
              <div class="card-header">
                <i class="fa fa-calendar"></i> {{ tgl_indo($item->created_at) }}

                @if($item->hidrolik_id == 0)
                <div class="float-right">
                  <div class="badge badge-danger" style="padding: 5px 10px; margin-left:3px;" > </i> Hidrolik Belum Dipilih</div>
                </div>
                @else
                <div class="float-right mx-3">
                  <div class="badge badge-info"></i>Hidrolik {{ $item->hidrolik_id }}</div>
                </div>
                @endif

                @if ($item->status == 0)
                <div class="float-right">
                  <div class="badge badge-warning"><i class="fa fa-spinner"></i> Diproses</div>
                </div>
                @elseif ($item->status == 1)
                <div class="float-right">
                  <div class="badge badge-success"><i class="fa fa-spinner"></i> Selesai</div>
                </div>
                @elseif ($item->status == 2)
                <div class="float-right">
                  <div class="badge badge-success"><i class="fa fa-spinner"></i> Antre</div>
                </div>
                @elseif ($item->status == 3)
                <div class="float-right">
                  <div class="badge badge-success"><i class="fa fa-spinner"></i> Finishing</div>
                </div>
                @else
                <div class="float-right">
                  <div class="badge badge-danger"><i class="fa fa-spinner"></i> Dibatalkan</div>
                </div>
                @endif
              </div>
              <div class="card-body">
                <table class="w-100">
                  <tr>
                    <th>No Order</th>
                    <td colspan="2">{{ $item->id }}</td>
                  </tr>
                  <tr>
                    <th>Nama</th>
                    <td colspan="2">{{ $item->nama }}</td>
                  </tr>
                  <tr>
                    <th>No Telp</th>
                    <td colspan="2">{{ '+62'.$item->nohp }}</td>
                  </tr>
                  <tr>
                    <th>No Kendaraan</th>
                    <td colspan="2">{{ $item->no_kendaraan }}</td>
                  </tr>
                  <tr>
                    <th>Merk Kendaraan</th>
                    <td colspan="2">{{ $item->merk }}</td>
                  </tr>
                  <tr>
                    <th>Metode Pembayaran</th>
                    <td colspan="2">{{ is_null($item->metode_pembayaran) ? '-' :
                      loadMetodePembayaran($item->metode_pembayaran) }}</td>
                  </tr>
                  @php
                  $layanan = detailOrderan($item->id);
                  $gambar = gambarByOrderId($item->id);
                  $total = 0;

                  for($i = 0; $i < count($layanan); $i++){ $total +=$layanan[$i]->harga;
                    if ($i == 0){
                    echo "<tr>
                      <th>Layanan</th>
                      <td>".$layanan[$i]->nama_layanan."</td>
                      <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                    </tr>";
                    } else {
                    echo "<tr>
                      <th></th>
                      <td>".$layanan[$i]->nama_layanan."</td>
                      <td class='text-right'>".rupiah($layanan[$i]->harga)."</td>
                    </tr>";
                    }
                    }
                    @endphp
                    <tr>
                      <td colspan="3">
                        <hr class="pembatas-table">
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2" class="text-center">Total</th>
                      <td class="text-right">{{ rupiah($total) }}</td>
                    </tr>
                </table>
                {{-- @if ($item->catatan != null)
                <hr>
                <p class="notes"><b>Catatan</b> : {{ $item->catatan }}</p>
                @endif --}}

                @if (!is_null($item->catatan))
                <hr>
                @endif
                <div class="row">
                  <div class="col-sm-6">
                    @if ($item->catatan != null)
                    <p class="notes"><b>Catatan</b> : {{ $item->catatan }}</p>
                    @endif
                  </div>
                  {{-- Jika Status Selesai  --}}
                  <div class="col-sm-6">
                    @if ($item->status == 1)
                    <a target="_blank" href="{{url('finance/print', $item->id)}}" class="btn btn-sm btn-outline-info" style="padding: 5px 10px;"><i class="fa fa-print"></i> (58)</a>
                    <a target="_blank" href="{{url('send/kwitansi/'. $item->id . '?type=print')}}" class="btn btn-sm btn-success"
                      style="padding: 5px 10px;">Print</a>
                    <a href="https://wa.me/{{ substr_replace($item->nohp, "+62", 0, 1) }}?text=Yth Customer,%0a%0aKwitansi sudah bisa didownload, silahkan klik link dibawah : %0a{{ url('send/kwitansi/'.$item->id) }} %0a%0aJika ada kritik dan saran dengan senang hati kami akan menerima.%0aSemoga sehat selalu dan selamat sampai tujuan.%0aTerima Kasih %0a*HD CARWASH*" target="_blank" class="btn btn-outline-warning btn-sm" style="padding:5px 10px;"><i class="fa fa-whatsapp"></i> KIRIM PESAN</a>
                    @endif
                  </div>
                </div>
                
                {{-- Jika Status Proses  --}}
                @if ($item->status == 0)
                <div class="text-center mt-2">
                 
                  <a href="{{ url('finance/updateStatus?id='.$item->id.'&permintaan=3') }}"
                    class="btn btn-success btn-sm" style="padding:5px 10px;"><i class="fa fa-check"></i> Finishing</a>
                  
                  <a href="https://wa.me/{{ substr_replace($item->nohp, "+62", 0, 1) }}?text=Yth Customer,%0a%0aBerikut Detail Order anda di HDCarwash, silahkan klik link dibawah : %0a{{ url('send/struk/'.$item->id) }}%0a%0aTerima Kasih %0a*HD CARWASH*" target="_blank" class="btn btn-outline-warning btn-sm" style="padding:5px 10px;"><i class="fa fa-whatsapp"></i> KIRIM PESAN</a>
                </div>
                
             

                 {{-- Jika Status Antre  --}}
                @elseif($item->status == 2)
                <div class="text-center mt-2">
                  {{-- pemilihan hidrolik --}}
                  @if($item->hidrolik_id == 0 )
                  <a href="{{ route('pilih.hidrolik',$item->id) }}"
                    class="btn btn-danger btn-sm" style="padding:5px 10px;">Pilih Hidrolik</a>
                  @else
                  <a href="{{ url('/finance/updateStatus?id='.$item->id.'&permintaan=0') }}"
                    class="btn btn-success btn-sm"><i class="fa fa-check"></i> Proses Sekarang</a>
                    @endif
                </div>

                 {{-- Jika Status Finishing  --}}
                @elseif($item->status == 3)
                <div class="text-center mt-2">
                  <a href="{{ url('finance/updateStatus?id='.$item->id.'&permintaan=1') }}"
                    class="btn btn-success btn-sm"><i class="fa fa-check"></i> SELESAIKAN</a>
                </div>
                @endif

                @if (count($gambar) > 0)
                <hr>
                <div class="row">
                  @foreach ($gambar as $a => $g)
                  <div class="col-md-6 mb-2">
                    <img class="car-image-before-wash" src="{{ $g->path }}" alt="Gambar Mobil Sebelum Cuci">
                  </div>
                  @endforeach
                </div>

                @endif


              </div>

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
@endsection