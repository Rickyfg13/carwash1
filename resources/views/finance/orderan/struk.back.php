<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Struk Order</title>
    <style>
        /* @font-face {
            font-family: 'quick';
            src: url(Quicksand-Regular_afda0c4733e67d13c4b46e7985d6a9ce.ttf);
        }

        * {
            font-family: 'quick';
        } */
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
            margin-top: 2rem;
        }
        /* .page-body table td {
            width: 14.7rem;
        }         */
        .image-container {
            display: flex;
            justify-content: center;
            /* width: 100%; */
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 1rem;
        }
        .image-container img {
            width: 300px;
            flex-wrap: wrap;
            height: 200px;
            object-fit: cover;
            object-position: center;
        }

        .grey-background-color {
            background-color: #808080;
            color: #fff;
        }

        @media print {
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
                -webkit-print-color-adjust: exact;
            }

            .page-body table tr.thead-orange th {
                background-color: #F79646 !important;
                color: #fff;
                -webkit-print-color-adjust: exact;
            }
            .grey-background-color {
                background-color: #808080 !important;
                color: #fff;
                -webkit-print-color-adjust: exact;
            }
            
        }
    </style>
</head>
<!-- <body onload="window.print()"> -->

<body onLoad="javascript:print()">    
{{-- <body> --}}
    <div class="print-area">
        <div class="page-header" style="display: flex;align-items:center;gap:10px;">
            <div class="page-header-asset">
                <img src="{{asset('img/logo1.png')}}" style="width: 130px;height:60px" alt="">
            </div>
            <div class="page-header-text">
                <p class="title">HD CARWASH</p>
                <p class="address">Jl. Ps. Malintang No.32, Pasa Gadang, Kec. Padang Sel., Kota Padang, Sumatera Barat (0751) 841555</p>
            </div>

        </div>
        <hr class="page-header-divider">
        <div class="page-body">
            
            <div style="display: flex; justify-content:space-between; margin: 0 5px 1rem">
                <span style="font-weight: bold">No Orderan : {{ $data->id }}</span>
                <span class="grey-background-color">{{ tgl_indo($data->created_at) }}</span>
            </div>

            @php
                $total = 0;
            @endphp

            @foreach ($layanan as $lyn)
            @php
                $total += $lyn->harga;
            @endphp

            <table style="font-size: 14px;width:100%;">
                <tr class="thead-orange">
                    <th style="padding: 10px 0;background: #F79646;" colspan="2">Customer</th>
                    <th style="padding: 10px 0;background: #F79646;" colspan="2">Detail Order</th>
                </tr>

                <tr>
                    <td align="left">Nama</td>
                    <td>{{ $data->nama }}</td>      
                    <td align="left">Jenis Layanan</td>
                    <td></td>              
                </tr>
                <tr>
                    <td align="left">No HP</td>
                    <td>{{ $data->nohp }}</td> 
                    <td align="left">Nama Layanan</td>                   
                    <td>{{ $lyn->nama_layanan }}</td>
                </tr>
                <tr>
                    <td align="left">No Plat</td>
                    <td>{{ $data->no_kendaraan }}</td>                    
                    <td align="left">Catatan</td>
                    <td>{{ $data->catatan }}</td>
                </tr>
                <tr>
                    <td align="left">Merk Mobil</td>
                    <td>{{ $data->merk }}</td>                    
                    <td align="left">Metode Pembayaran</td>
                    <td>{{ is_null($data->metode_pembayaran) ? "" : loadMetodePembayaran($data->metode_pembayaran) }}</td>                 
                </tr>                
                <tr>
                    <th></th>
                    <td></td>
                    <td align="left">Harga</td>
                    <td>{{ rupiah($lyn->harga) }}</td>
                </tr>
            </table>
            @endforeach
            <table style="font-size:14px;width: 100%">
                <tr>
                    <th style="width: 12rem;"></th>
                    <td style="width: 11rem;"></td>
                    <th align="right">Total &emsp;</th>
                    <td>{{ rupiah($total) }}</td>
                </tr>
            </table>
        </div>

        {{-- gambar --}}

        @if (count($gambar) > 0)
        <div class="image-container">
            @foreach ($gambar as $a => $b)
            <img src="{{ $b->path }}" alt="Gambar mobil yg dicuci">    
            @endforeach            
        </div>    
        @endif
        
    </div>


    
    
</body>

</html>
