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
        <h4 style="font-family: sans-serif !important; text-transform:uppercase">BUKU KAS MASUK <br>KOPERASI PRODUKSI AMANAH SEJATI <br> BULAN {{ $tanggal }} </h4>
    </div>

    <table class="table table-bordered table-hover table-striped" id="kelas">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No</th>
                <th>Uraian</th>
                <th>Simpanan Pokok</th>
                <th>Simpanan Wajib</th>
                <th>Angsuran Pokok</th>
                <th>Angsuran Jasa</th>
                <th>Denda</th>
                <th>Dana Operasional</th>
                <th>Simpanan Sukarela</th>
                <th>Pinjaman Taspen</th>
                <th>Pinjaman Dana Bergulir</th>
                <th>Lain-Lain</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($tanggal))
                @php
                    $totalSimpananPokok = 0;
                    $totalSimpananWajibs = 0;
                    $totalAngsuranPokok = 0;
                    $totalAngsuranJasa = 0;
                    if (isset($modalAwal)) {
                        $totalModalAwal = $modalAwal->modal_awal;
                    }else{
                        $totalModalAwal = 0;
                    }
                @endphp
                <tr>
                    <td>{{ $tanggal ? $tanggal : '-' }}</td>
                    <td></td>
                    <th>Saldo Kas Bulan {{ $tanggal ? $tanggal : '-' }}</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>
                        @if (isset($modelAwal))
                            Rp.{{ number_format($modalAwal->modal_awal) }},-
                        @else
                            Rp.0,-
                        @endif
                    </th>
                </tr>
                @foreach ($kasMasuks as $index => $kasMasuk)
                    
                    <tr>
                        <td>
                            @if (!empty($kasMasuk->simpananPokok[0]))
                                {{ \Carbon\Carbon::parse($kasMasuk->simpananPokok[0]->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}
                            @elseif (!empty($kasMasuk->simpananWajibs[0]))
                                {{ \Carbon\Carbon::parse($kasMasuk->simpananWajibs[0]->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $kasMasuk->nama_lengkap }}</td>
                        <td>
                            @if ($kasMasuk->simpanan_pokok_sum_jumlah_transaksi)
                                Rp.{{ number_format($kasMasuk->simpanan_pokok_sum_jumlah_transaksi) }},-
                                @php $totalSimpananPokok += $kasMasuk->simpanan_pokok_sum_jumlah_transaksi; @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($kasMasuk->simpanan_wajibs_sum_jumlah_transaksi)
                                Rp.{{ number_format($kasMasuk->simpanan_wajibs_sum_jumlah_transaksi) }},-
                                @php $totalSimpananWajibs += $kasMasuk->simpanan_wajibs_sum_jumlah_transaksi; @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($kasMasuk->angsurans_sum_angsuran_pokok)
                                Rp.{{ number_format($kasMasuk->angsurans_sum_angsuran_pokok) }},-
                                @php $totalAngsuranPokok += $kasMasuk->angsurans_sum_angsuran_pokok; @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($kasMasuk->angsurans_sum_angsuran_jasa)
                                Rp.{{ number_format($kasMasuk->angsurans_sum_angsuran_jasa) }},-
                                @php $totalAngsuranJasa += $kasMasuk->angsurans_sum_angsuran_jasa; @endphp
                            @else
                                -
                            @endif
                        </td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <th>
                            Rp.{{ number_format($kasMasuk->simpanan_pokok_sum_jumlah_transaksi + $kasMasuk->simpanan_wajibs_sum_jumlah_transaksi + $kasMasuk->angsurans_sum_angsuran_pokok + $kasMasuk->angsurans_sum_angsuran_jasa) }},-
                        </th>
                    </tr>
                @endforeach
                    <tr>
                        <th colspan="3"><strong>Total</strong></th>
                        <th>Rp.{{ number_format($totalSimpananPokok) }},-</th>
                        <th>Rp.{{ number_format($totalSimpananWajibs) }},-</th>
                        <th>Rp.{{ number_format($totalAngsuranPokok) }},-</th>
                        <th>Rp.{{ number_format($totalAngsuranJasa) }},-</th>
                        <th colspan="6"></th>
                        <th>
                            Rp.{{ number_format($totalSimpananPokok + $totalSimpananWajibs + $totalAngsuranPokok + $totalAngsuranJasa + $totalModalAwal) }},-
                        </th>
                    </tr>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>