<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Struk Order</title>
    <style>        
        body {
            font-family: Verdana, sans-serif;
        }
        .print-area {
            margin : 5px auto;
            /* min-width: 500px; */
            /* width: 100%; */
            /* max-width: 760px; */
            /* border: 1px solid; */
        }
        .page-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-header-text .title {
            font-weight: bold;
            font-size: 18px;
            color: #F79646;
            margin-bottom: 5px;
        }

        .page-header-text .address {
            font-size: 13px;
            margin-top: 0 !important;
        }
        .page-header-divider {
            border: 2px solid #F79646;
        }
        .page-body {
            margin-top: 1rem;
        }
        /* .page-body table td {
            width: 14.7rem;
        }         */
        .image-container {
            /* display: flex; */
            /* justify-content: center; */
            /* width: 100%; */
            /* flex-wrap: wrap;
            gap: 20px;
            margin: 0 auto 0;
            width:100%; */
            margin-top: 50px;
            /* display:table; */

        }
        .image-container img {
            width: 290px;            
            height: 200px;
            object-fit: cover;
            object-position: center;
            margin: 0 5px 5px;            
        }

        .grey-background-color {
            background-color: #808080;
            color: #fff;
            padding: 1px 2px 3px;
        }
    </style>
</head>

<body>
    <div class="print-area">
        <table style="margin-top: -1.5rem;">
            <tr>
                <th rowspan="2"><img src="{{asset('img/logo1.png')}}" style="width: 130px;height:60px;margin-top:5px;" alt="Logo"></th>
                <td><p style="font-weight: bold; color:#F79646;font-size:18px;margin-bottom:0;">HD CARWASH</p></td>
            </tr>
            <tr>
                <td><p style="font-size:13px;margin-top:5px;">Jl. Ps. Malintang No.32, Pasa Gadang, Kec. Padang Sel., Kota Padang, Sumatera Barat<br/>(0751) 841555</p></td>            
            </tr>

        </table>
        <hr class="page-header-divider">
        <div class="page-body">
            <table style="width:100%;margin-bottom:0.5rem;">
                <tr>
                    <td align="left"><span style="font-weight: bold">No Orderan : {{ $data->id }}</span></td>
                    <td align="right"><span class="grey-background-color">{{ tgl_indo($data->created_at) }}</span></td>
                </tr>
            </table>

            @php
                $total = 0;
            @endphp

            @foreach ($layanan as $lyn)
            @php
                $total += $lyn->harga;
            @endphp

            <table style="font-size: 14px;width:100%;margin-top:1rem;border:2px solid #F79646;border-collapse:collapse;">
                <tr class="thead-orange">
                    <th style="padding: 10px 0;background: #F79646;" colspan="2">Customer</th>
                    <th style="padding: 10px 0;background: #F79646;" colspan="2">Detail Order</th>
                </tr>

                <tr>
                    <td align="left" style="padding-left:5px;width:10rem;">Nama</td>
                    <td>{{ $data->nama }}</td>      
                    <td align="left" style="padding-left:5px;width:10rem;">Jenis Layanan</td>
                    <td>{{ $lyn->nama_layanan }}</td>              
                </tr>
                <tr>
                    <td align="left" style="padding-left:5px;">No HP</td>
                    <td>{{ $data->nohp }}</td> 
                    <td align="left" style="padding-left:5px;">Nama Layanan</td>                   
                    <td>{{ $lyn->nama_layanan }}</td>
                </tr>
                <tr>
                    <td align="left" style="padding-left:5px;">No Plat</td>
                    <td>{{ $data->no_kendaraan }}</td>                    
                    <td align="left" style="padding-left:5px;">Catatan</td>
                    <td>{{ $data->catatan }}</td>
                </tr>
                <tr>
                    <td align="left" style="padding-left:5px;">Merk Mobil</td>
                    <td>{{ $data->merk }}</td>                    
                    <td align="left" style="padding-left:5px;">Metode Pembayaran</td>
                    <td>{{ is_null($data->metode_pembayaran) ? "-" : loadMetodePembayaran($data->metode_pembayaran) }}</td>                 
                </tr>                
                <tr>
                    <th></th>
                    <td></td>
                    <td align="left" style="padding-left:5px;">Harga</td>
                    <td>{{ rupiah($lyn->harga) }}</td>
                </tr>
            </table>
            @endforeach
            <table style="font-size:14px;width: 100%;border:2px solid #F79646;border-top:none;border-collapse:collapse;">
                <tr>
                    <th style="width: 12rem;"></th>
                    <td style="width: 11rem;"></td>
                    <th align="right" style="padding:5px 0;">Total &emsp;</th>
                    <td style="padding:5px;">{{ rupiah($total) }}</td>
                </tr>
            </table>

            {{-- gambar --}}

            @if (count($gambar) > 0)
            <div class="image-container">
                @foreach ($gambar as $a => $b)
                <img src="{{ $b->path }}" alt="Gambar mobil yg dicuci">                    
                @endforeach            
            </div>    
            @endif
            
        </div>

        

        
        
    </div>


    
    
</body>

</html>
