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
    </style>
    <style>
        .bold900 { font-weight: 900; }
    </style>
</head>
<!-- <body onload="window.print()"> -->

<body onLoad="javascript:print()">
    @foreach ($data as $item)
    <table style="width: 30%; margin: auto; text-align: center; font-size: 14px;" border="0">
        <tr>
            <td><img src="{{asset('img/logo1.png')}}" style="width: 200px;height:100px" alt=""></td>
        </tr>
    </table>
    <table style="width: 30%; margin: auto; text-align: center; font-size: 13px;" border="0">
        <tr>
            <th style="text-align: left">No Order</th>
            <td>:</td>
            <td colspan="2" style="text-align: right">{{ $item->id }}</td>
        </tr>
        <tr>
            <th style="text-align: left">Nama</th>
            <td>:</td>
            <td colspan="2" style="text-align: right">{{ $item->nama }}</td>
        </tr>
        <tr>
            <th style="text-align: left">No Telp</th>
            <td>:</td>
            <td colspan="2" style="text-align: right">{{ $item->nohp }}</td>
        </tr>
        <tr>
            <th style="text-align: left">No Kendaraan</th>
            <td>:</td>
            <td colspan="2" style="text-align: right">{{ $item->no_kendaraan }}</td>
        </tr>
        <tr>
            <th style="text-align: left">Merk</th>
            <td>:</td>
            <td colspan="2" style="text-align: right">{{ $item->merk }}</td>
        </tr>
        @if ($item->catatan != null)
        <tr>
            <th style="text-align: left">Catatan</th>
            <td>:</td>
            <td colspan="2" style="text-align: right">{{ $item->catatan }}</td>
        </tr>
        @endif
        <tr>
            <td colspan="5">
                <hr>
            </td>
        </tr>
        @php
          $layanan = detailOrderan($item->id);
          $total = 0;

          for($i = 0; $i < count($layanan); $i++){
            $total += $layanan[$i]->harga;
            if ($i == 0){
              echo "<tr>
                <th style='text-align: left'>Layanan</th>
                <td>".$layanan[$i]->nama_layanan."</td>
                <td style='text-align: left'>".rupiah($layanan[$i]->harga)."</td>
              </tr>";
            } else {
              echo "<tr>
                <th></th>
                <td>".$layanan[$i]->nama_layanan."</td>
                <td style='text-align: left' class='bold900'>".rupiah($layanan[$i]->harga)."</td>
              </tr>";
            }
          }
        @endphp
        <tr>
          <td colspan="3"><hr class="pembatas-table"></td>
        </tr>
        <tr>
          <th colspan="2" style="text-align: left">Total</th>
          <td style="text-align: left"><b>{{ rupiah($total) }}</b></td>
        </tr>
        <tr>
            <td colspan="5"><hr></td>
        </tr>
        <tr style="text-align: center">
            <td colspan="3">Jl. Ps. Malintang No.32, Pasa Gadang, Kota Padang</th>
        </tr>
        <tr style="text-align: center">
            <td colspan="3">081212391305</th>
        </tr>
    </table>
    @endforeach
</body>

</html>