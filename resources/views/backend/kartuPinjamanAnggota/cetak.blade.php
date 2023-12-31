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
        <h4 style="font-family: sans-serif !important; text-transform:uppercase">KARTU PINJAMAN {{ $anggota->nama_lengkap }}</h4>
    </div>
    <div>
        <table>
            <tr>
                <th>Nama Anggota</th>
                <th> : </th>
                <td>{{ $anggota->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Jumlah Pinjaman</th>
                <th> : </th>
                <td>Rp. {{ number_format($pinjaman->jumlah_transaksi) }},-</td>
            </tr>
            <tr>
                <th>Pinjaman Ke</th>
                <th> : </th>
                <td>{{ $pinjaman->pinjaman_ke }}</td>
            </tr>
            <hr>
        </table>
    </div>
    <table class="table table-bordered table-hover table-striped" id="kelas">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center">Tanggal Transaksi</th>
                <th rowspan="2" style="text-align: center">Uraian</th>
                <th rowspan="2" style="text-align: center">Ke</th>
                <th colspan="3" style="text-align: center">Angsuran</th>
                <th colspan="3" style="text-align: center">Saldo</th>
                <th rowspan="2" style="text-align: center">Paraf Petugas</th>
            </tr>
            <tr>
                <th style="text-align: center">Pokok</th>
                <th style="text-align: center">Jasa</th>
                <th style="text-align: center">Denda</th>
                <th style="text-align: center">Pokok</th>
                <th style="text-align: center">Jasa</th>
                <th style="text-align: center">Denda</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no=1;
                    $modal_awal = $pinjaman->jumlah_transaksi;
                    $bunga_awal = $pinjaman->angsuran_jasa * $pinjaman->jumlah_bulan;
            @endphp
            @forelse ($angsurans as $angsuran)
                <tr>
                <td>{{ \Carbon\Carbon::parse($angsuran->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}</td>
                    <td style="text-align: center">Angsuran</td>
                    <td style="text-align: center">{{ $no++ }}</td>
                    <td style="text-align: center">Rp.{{ number_format($angsuran->angsuran_pokok) }},-</td>
                    <td style="text-align: center">Rp.{{ number_format($angsuran->angsuran_jasa) }},-</td>
                    <td style="text-align: center">-</td>
                    <td style="text-align: center">Rp. {{ number_format($modal_awal - $pinjaman->angsuran_pokok) }},-</td>
                    @php
                        $modal_awal = $modal_awal - $pinjaman->angsuran_pokok;
                    @endphp
                    <td style="text-align: center">Rp.{{ number_format($bunga_awal - $pinjaman->angsuran_jasa) }},-</td>
                    @php
                        $bunga_awal = $bunga_awal - $pinjaman->angsuran_jasa;
                    @endphp
                    <td style="text-align: center">-</td>
                    <td style="text-align: center"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; color:red">Tidak ada data angsuran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>