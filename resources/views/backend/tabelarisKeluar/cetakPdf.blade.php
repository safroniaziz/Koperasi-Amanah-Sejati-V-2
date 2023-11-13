<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
    }

    .text-center {
        text-align: center;
    }

    h4 {
        margin-top: 20px;
        font-weight: bold;
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 12px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    hr {
        border: none;
        border-top: 1px solid #ddd;
        margin: 10px 0;
    }

    </style>
</head>
<body>
    <div class="text-center">
        <h4 style="font-family: sans-serif !important; text-transform:uppercase">BUKU KAS PEMBANTU</h4>
    </div>
    <div>
        <table>
            <tr>
                <th>Tahun</th>
                <th> : </th>
                <td>{{ $tahun}}</td>
            </tr>
            <tr>
                <th>Bulan</th>
                <th> : </th>
                <td>{{ $bulan }}</td>
            </tr>
            <hr>
        </table>
    </div>
    <table class="table table-bordered table-hover table-striped" id="kelas" style="width: 100%">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Uraian</th>
                <th>Keluar</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @if ($tahun)
                @php
                $saldo = 0;
                @endphp
                @foreach ($transaksis as $index => $transaksi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}</td>
                        <td>{{ $transaksi->jenisTransaksi ? $transaksi->jenisTransaksi->nama_jenis_transaksi : '' }} - {{ $transaksi->anggota->nama_lengkap }}</td>
                        <td>
                            Rp.{{ number_format($transaksi->jumlah_transaksi, 2) }}
                        </td>
                        @php
                            $saldo += $transaksi->jumlah_transaksi;
                        @endphp
                        <td>
                            Rp.{{ number_format($saldo, 2) }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>