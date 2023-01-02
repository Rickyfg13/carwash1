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
        }

        * {
            font-family: 'quick';
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

        /* @media print {
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
            
        } */
    </style>
</head>
<!-- <body onload="window.print()"> -->

{{-- <body onLoad="javascript:print()">     --}}
<body>    
    <div id="print-area" class="print-area">
        <div class="page-header">
            
            <table style="width:100%;margin-top:-0.5rem;margin-bottom:-0.8rem;">            
                <tr>
                    
                    <td><p style="font-weight: bold; color:#F79646;font-size:18px;margin-bottom:0;">HD CARWASH</p></td>   
                    <th rowspan="2" align="right" style="width:140px;"><img src="{{asset('img/logo1.png')}}" style="width: 130px;height:60px;margin-top:5px;" alt="Logo"></th>       
                    
                </tr>
                <tr>
                    <td><p style="font-size:12px;margin-top:0;">Jl. Ps. Malintang No.32, Pasa Gadang, Kec. Padang Sel., Kota Padang, Sumatera Barat<br/>(0751) 841555</p></td> 
                </tr>
            </table>
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

            <table style="width:100%;font-size:12px;">
                <tr>
                    <th align="left" width="8rem">Telah diterima dari</th>
                    <th>:</th>
                    <td style="border-bottom:1px solid #000">{{ ucwords($data->nama) }}</td>
                </tr>
                <tr>
                    <th align="left" width="8rem">No. Plat Kendaraan</th>
                    <th>:</th>
                    <td style="border-bottom:1px solid #000">{{ strtoupper($data->no_kendaraan) }}</td>
                </tr>
                <tr>
                    <th align="left">Uang sejumlah</th>
                    <th>:</th>
                    <td style="border-bottom:1px solid #000">{{ ucwords(terbilang($total) ." rupiah") }}</td>
                </tr>
                <tr>
                    <th align="left">Untuk pembayaran</th>
                    <th>:</th>
                    <td style="border-bottom:1px solid #000">{{ $allLayanan ." mobil " . $data->merk }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="border-bottom:1px solid #000;height:14px;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="border-bottom:1px solid #000;height:14px;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="border-bottom:1px solid #000;height:14px;"></td>
                </tr>
            </table>

            <table style="width: 100%;margin-top:1rem;">
                <tr>
                    <td width="3rem"><div style="font-size: 24px;font-weight:bold;border-top:1px solid #000;border-bottom:1px solid #000;padding:5px 0;">Rp.</div></td>
                    <td width="8rem"><div style="font-size: 24px;font-weight:bold;background-color:#ddd;border-top:1px solid #000;border-bottom:1px solid #000;padding:5px 2px 5px 2px;">{{ number_format($total, 0, ',', '.') }}</div></td>
                    
                    <td ></td>
                    <td width="10rem">
                        <span class="has-border-bottom-1" style="width: 100%;display:inline-block;margin-bottom:6rem;text-align:center;font-size:14px;">{{ just_tgl($data->updated_at) }}</span>
                        <img src="{{ asset('img/stamp.png') }}" style="margin-top: -6rem;margin-bottom:-3rem;height:7rem;display:block" alt="Stempel Lunas">
                        <span style="width:100%;border-bottom:1px dotted #000;display:block;text-align:center;font-size:14px;font-weight:bold;">HD Carwash</span>
                    </td>
                    <td width="2rem;"></td>
                </tr>
            </table>
            
        </div>
        
    </div>
    
</body>

</html>
