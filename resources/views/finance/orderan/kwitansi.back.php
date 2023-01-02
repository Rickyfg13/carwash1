<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Kwitansi</title>
    <style>
        /* @font-face {
            font-family: 'quick';
            src: url(Quicksand-Regular_afda0c4733e67d13c4b46e7985d6a9ce.ttf);
        } */
        body {
            font-family: Verdana, sans-serif;
        }
        .print-area {
            margin : 5px auto;
            min-width: 500px;
            width: 100%;
            max-width: 720px;
            border: 2px solid;
        }
        .page-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 1rem;
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
            border: 1px solid #000;
        }
        .page-body {
            /* margin-top: 1rem; */
            padding: 1rem;
        }

        .kwitansi-body {
            width: 100%;
            font-size: 12px;
        }

        .kwitansi-body .row {
            width: 100%;
            display: flex;
        }

        .kwitansi-body .row span {
            padding: 5px 0;
        }

        .kwitansi-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            align-items: center;
        }

        .kwitansi-footer .total-text {
            width: 300px;
            font-size: 20px;
            font-weight: bold;                        
        }

        .kwitansi-footer .total-text span {            
            padding: 10px 5px 0;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .kwitansi-footer .total-text span.number {
            width: 200px;
            background-color: #ddd;
            display: inline-block;
        }

        .kwitansi-footer .stamp-area {
            width: 250px;
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
            background-color: #ddd;            
        }

        .has-border-bottom-1 {
            border-bottom: 1px solid #000;
        }

        @media print {
            .page-header-text .title {
                font-weight: bold;
                font-size: 18px;
                color: #F79646;
                margin-bottom: 5px;
                -webkit-print-color-adjust: exact;
            }

            .page-header-text .address {
                font-size: 12px;
                line-height: 18px;
                margin-top: 0 !important;
            }

            .page-body {
                font-size: 12px;
                -webkit-print-color-adjust: exact;
            }

            .page-body table tr.thead-orange th {
                background-color: #F79646 !important;
                color: #fff;
                -webkit-print-color-adjust: exact;
            }
            .grey-background-color {
                background-color: #ddd !important;
                -webkit-print-color-adjust: exact;
            }

            .kwitansi-footer .total-text span.number {
                background-color: #ddd !important;
                -webkit-print-color-adjust: exact;
            }

            .has-border-bottom-1 {
                border-bottom: 1px solid #000;
                -webkit-print-color-adjust: exact;
            }
            
        }
    </style>
    <style>
        .bold900 { font-weight: 900; }
    </style>
</head>
<!-- <body onload="window.print()"> -->

<body onLoad="javascript:print()">    
{{-- <body> --}}

    <div class="print-area">
        <div class="page-header">            
            <div class="page-header-text">
                <p class="title">HD CARWASH</p>
                <p class="address">Jl. Ps. Malintang No.32, Pasa Gadang, Kec. Padang Sel., Kota Padang, Sumatera Barat (0751) 841555</p>
            </div>
            <div class="page-header-asset">
                <img src="{{asset('img/logo1.png')}}" style="width: 150px;height:70px" alt="">
            </div>

        </div>
        <hr class="page-header-divider">
        <div class="page-body">
            
            {{-- <div style="display: flex; justify-content:space-between; margin: 0 5px 1rem"> --}}
                <span style="font-weight: bold; margin-bottom:1rem;display:block;">No Orderan : {{ $data->id }}</span>                
            {{-- </div> --}}

            

            @php
                $total = 0;
                $allLayanan = "";
            @endphp

            @foreach ($layanan as $x => $lyn)
            @php
                $total += $lyn->harga;
                $allLayanan .= $lyn->nama_layanan;

                if ($x > 0) {
                    $allLayanan .= ", ";
                }
            @endphp
            @endforeach

            <div class="kwitansi-body">
                <div class="row">
                    <span style="width:200px;">Telah terima dari</span>
                    <span style="width: 30px;">:</span>
                    <span class="has-border-bottom-1" style="width:100%;">{{ $data->nama }}</span>
                </div>
                <div class="row">
                    <span style="width:200px;">Uang sejumlah</span>
                    <span style="width: 30px;">:</span>
                    <span class="grey-background-color has-border-bottom-1" style="width:100%;">{{ ucwords(terbilang($total) ." rupiah") }}</span>
                </div>
                <div class="row">
                    <span style="width:200px;">Untuk pembayaran</span>
                    <span style="width: 30px;">:</span>
                    <span class="has-border-bottom-1" style="width:100%;line-height:18px;">{{ $allLayanan ." mobil " . $data->merk }}</span>
                </div>
                <div class="row">
                    <span class="has-border-bottom-1" style="width:100%;height:18px;"></span>
                </div>
                <div class="row">
                    <span class="has-border-bottom-1" style="width:100%;height:18px;"></span>
                </div>
                <div class="row">
                    <span class="has-border-bottom-1" style="width:100%;height:18px;"></span>
                </div>
                
            </div>
    
            <div class="kwitansi-footer">
                <div class="total-text">
                    <span class="currency">Rp. </span><span class="number">{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="stamp-area">
                    <span class="has-border-bottom-1" style="width: 100%;display:inline-block;margin-bottom:6.7rem;text-align:center;">{{ just_tgl($data->updated_at) }}</span>
                    <img src="{{ asset('img/stamp.png') }}" style="margin-top: -7rem;margin-bottom:-2rem;height:10rem;" alt="Stempel Lunas">
                    <div style="width:100%;display:flex;justify-content:space-between">
                        <span>(</span>
                        <span style="width:100%;border-bottom:1px dotted #000;text-align:center;">HD Carwash</span>
                        <span>)</span>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>


    
    
</body>

</html>
