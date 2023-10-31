<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Aneka Kreasi - Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #ddd;
        }

        .tanggal {
            text-align: right;
        }

        .status-lunas {
            color: green;
            text-transform: uppercase;
            font-weight: bold;
        }

        .status-belum-lunas {
            color: red;
            text-transform: uppercase;
            font-weight: bold;

        }

        .dp,
        .sisa {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #ffffff;
            padding: 10px;
            background-color: rgb(110, 0, 0);
        }

        .kotak {
            width: 35%;
            padding: 10px;
            border: solid 2px;
            background-image: url(https://khalidr.my.id/assets/img/stempel.png);
            background-size: 160px;
            background-position: center;
            background-repeat: no-repeat;
        }

        .alamat {
            width: max-content;
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
        }
    </style>
</head>

<body>
    <img src="https://khalidr.my.id/assets/img/logo-warna.png" style="width: 100%; max-width: 300px" />
    <div class="alamat">
        <p>Jln. Sultan sulaiman
            Daud. No. 11 Peuniti, <br>
            Kota Banda Aceh</p>
        Kpd Yth. {{ $orderan->nama_pemesan }} <br>
        No Invoice : #{{ $orderan->id_keuangan }}
    </div>
    <h1>Invoice</h1>
    <table>
        <tr>
            <th>Keterangan</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>{{ $orderan->nama_barang }}</td>
            <td>Rp. {{ number_format($orderan->harga_barang, 0, ',', '.') }}</td>
            <td>{{ $orderan->jumlah_barang }} Pcs</td>
            <td>Rp. {{ number_format($orderan->jumlah_total, 0, ',', '.') }}</td>
        </tr>
    </table>
    <p class="tanggal">Tanggal: {{ date('Y-m-d', strtotime($orderan->created_at)) }}</p>
    <div class="kotak">
        <p class="{{ $orderan->keterangan == 'L' ? 'status-lunas' : 'status-belum-lunas' }}">
            {{ $orderan->keterangan == 'L' ? 'Lunas' : 'Belum Lunas' }}
        </p>
        <p class="dp">Uang Muka: Rp. {{ number_format($orderan->uang_muka, 0, ',', '.') }}</p>
        <p class="sisa">Sisa Pembayaran: Rp. {{ number_format($orderan->sisa_pembayaran, 0, ',', '.') }}</p>
    </div>

    <footer class="footer">&copy; Aneka Kreasi {{ date('Y') }}</footer>
</body>

</html>
