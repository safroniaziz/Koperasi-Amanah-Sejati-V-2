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
        <h4 style="font-family: sans-serif !important; text-transform:uppercase">LAPORAN <br> TRANSAKSI USAHA TELUR</h4>
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
    <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Transaksi</th>
                <th>Nama Anggota</th>
                <th>Tanggal Transaksi</th>
                <th>Keterangan/Uraian</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @if ($tahun)
                @php
                    $saldo = 0; // Inisialisasi saldo awal
                @endphp
                @forelse ($transaksiTelurs as $index => $transaksiTelur)
                    <tr>
                        <td> {{ $index + 1 }} </td>
                        <td>{{ $transaksiTelur->jenisTransaksi->nama_jenis_transaksi }}</td>
                        <td>{{ $transaksiTelur->user->nama_lengkap }}</td>
                        <td>{{ $transaksiTelur->tanggal }}</td>
                        <td>{{ $transaksiTelur->keterangan }}</td>
                        @if ($transaksiTelur->jenis_transaksi == "debet")
                            <td>Rp.{{ number_format($transaksiTelur->jumlah_transaksi) }},-</td>
                            <td></td>
                        @else
                            <td></td>
                            <td>Rp.{{ number_format($transaksiTelur->jumlah_transaksi) }},-</td>
                        @endif
                        <td>
                            @php
                                // Hitung saldo
                                if ($transaksiTelur->jenis_transaksi == "debet") {
                                    $saldo += $transaksiTelur->jumlah_transaksi;
                                } else {
                                    $saldo -= $transaksiTelur->jumlah_transaksi;
                                }
                            @endphp
                            Rp.{{ number_format($saldo) }},-
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="font-style:italic;">
                            <a class="text-danger">data transaksi masih kosong</a>
                        </td>
                    </tr>
                @endforelse
            @endif
        </tbody>
    </table>
</body>
</html>