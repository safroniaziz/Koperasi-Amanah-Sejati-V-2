@extends('layouts.backend')
@section('subTitle','Data Kas Keluar')
@section('page','Data Kas Keluar')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@push('styles')
<style>
    table {
        font-size: 13px; /* Ubah ukuran font sesuai kebutuhan */
    }
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-left"></i>&nbsp;Tabelaris Kas Keluar</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @php
                        $tahun = request()->input('tahun');
                        $bulan = request()->input('bulan');
                    @endphp
                    <form action="{{ route('tabelarisKeluar.cari') }}" method="GET" id="form">
                        {{ csrf_field() }} {{ method_field('GET') }}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Pilih Bulan</label>
                                <select name="bulan" class="form-control" id="bulan">
                                    <option disabled selected>-- pilih bulan --</option>
                                    <option {{ $bulan == "01" ? 'selected' : '' }} value="01">Januari</option>
                                    <option {{ $bulan == "02" ? 'selected' : '' }} value="02">Februari</option>
                                    <option {{ $bulan == "03" ? 'selected' : '' }} value="03">Maret</option>
                                    <option {{ $bulan == "04" ? 'selected' : '' }} value="04">April</option>
                                    <option {{ $bulan == "05" ? 'selected' : '' }} value="05">Mei</option>
                                    <option {{ $bulan == "06" ? 'selected' : '' }} value="06">Juni</option>
                                    <option {{ $bulan == "07" ? 'selected' : '' }} value="07">Juli</option>
                                    <option {{ $bulan == "08" ? 'selected' : '' }} value="08">Agustus</option>
                                    <option {{ $bulan == "09" ? 'selected' : '' }} value="09">September</option>
                                    <option {{ $bulan == "10" ? 'selected' : '' }} value="10">Oktober</option>
                                    <option {{ $bulan == "11" ? 'selected' : '' }} value="11">November</option>
                                    <option {{ $bulan == "12" ? 'selected' : '' }} value="12">Desember</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Pilih Tahun</label>
                                <select name="tahun" id="tahun" class="form-control"></select>
                            </div>

                            <div class="col-md-12 text-center" style="margin-bottom: 10px;">
                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp; Cari Tabelaris Keluar</button>
                            </div>
                        </div>
                    </form>
                    @isset($tanggal)
                        <div class="alert alert-danger">
                            Menampilkan tabelaris kas keluar {{ $tanggal }}
                        </div>
                    @endisset

                    <div class="row">
                        <div class="col-md-12">
                            <a style="margin-bottom:10px !important" class="btn btn-primary btn-sm btn-flat" id="excelExport"><i class="fa fa-file-excel-o"></i>&nbsp;Export Excel</a>
                            <a style="margin-bottom:10px !important" href="{{ route('tabelarisKeluar.pdf') }}" target="_blank" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i>&nbsp; Export PDF</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-striped" id="tableData" style="width: 100%">
                        <thead class="bg-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>No</th>
                                <th>Uraian</th>
                                <th>Pemberian Pinjaman</th>
                                <th>Konsumsi Rapat</th>
                                <th>Jilid, Fotokopi, Cetak, ATK, dll</th>
                                <th>Rekening Bank</th>
                                <th>Denda</th>
                                <th>Angs. Pinjaman Taspen</th>
                                <th>Pajak</th>
                                <th>SHU</th>
                                <th>Transport Pembina</th>
                                <th>Honor Pengurus</th>
                                <th>Lain-Lain</th>
                                <th>Dana Bergulir</th>
                                <th>Jumlah</th>
                                <th>Saldo</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($tanggal))
                                @foreach ($kasKeluars as $index => $kasKeluar)
                                    
                                    <tr>
                                        <td>
                                            @if (!empty($kasKeluar->simpananPokok[0]))
                                                {{ \Carbon\Carbon::parse($kasKeluar->simpananPokok[0]->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}
                                            @elseif (!empty($kasKeluar->simpananWajibs[0]))
                                                {{ \Carbon\Carbon::parse($kasKeluar->simpananWajibs[0]->tanggal_transaksi)->isoFormat('D MMMM YYYY') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $kasKeluar->nama_lengkap }}</td>
                                        <td>
                                            @if ($kasKeluar->simpanan_pokok_sum_jumlah_transaksi)
                                                Rp.{{ number_format($kasKeluar->simpanan_pokok_sum_jumlah_transaksi) }},-
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kasKeluar->simpanan_wajibs_sum_jumlah_transaksi)
                                                Rp.{{ number_format($kasKeluar->simpanan_wajibs_sum_jumlah_transaksi) }},-
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kasKeluar->angsurans_sum_angsuran_pokok)
                                                Rp.{{ number_format($kasKeluar->angsurans_sum_angsuran_pokok) }},-
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($kasKeluar->angsurans_sum_angsuran_jasa)
                                                Rp.{{ number_format($kasKeluar->angsurans_sum_angsuran_jasa) }},-
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
                                            Rp.{{ number_format($kasKeluar->simpanan_pokok_sum_jumlah_transaksi + $kasKeluar->simpanan_wajibs_sum_jumlah_transaksi + $kasKeluar->angsurans_sum_angsuran_pokok + $kasKeluar->angsurans_sum_angsuran_jasa) }},-
                                        </th>
                                    </tr>
                                @endforeach
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
    <script>
        $('#tahun').each(function() {
            var year = (new Date()).getFullYear();
            var current = year;
            year -= 3;
            for (var i = 0; i < 6; i++) {
            if ((year+i) == current)
                $(this).append('<option selected value="' + (year + i) + '">' + (year + i) + '</option>');
            else
                $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
            }
        });

        $(document).ready(function() {
            $("#excelExport").click(function() {
                var table = document.getElementById("tableData");
                var sheet = XLSX.utils.table_to_sheet(table);
                var workbook = XLSX.utils.book_new();
                var worksheet = XLSX.utils.table_to_sheet(table);

                // Tambahkan lembar kerja ke workbook
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');

                // Ekspor ke file Excel
                XLSX.writeFile(workbook, 'tabelaris_kas_keluar.xlsx');
            });
        });
    </script>
@endpush