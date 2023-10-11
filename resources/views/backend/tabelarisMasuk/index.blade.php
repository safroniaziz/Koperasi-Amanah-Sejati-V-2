@extends('layouts.backend')
@section('subTitle','Data Kas Masuk')
@section('page','Data Kas Masuk')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@push('styles')
<style>
    table {
        font-size: 11px; /* Ubah ukuran font sesuai kebutuhan */
    }
</style>

@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-arrow-circle-left"></i>&nbsp;Tabelaris Kas Masuk</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @php
                        $tahun = request()->input('tahun');
                        $bulan = request()->input('bulan');
                    @endphp
                    <form action="{{ route('tabelarisMasuk.cari') }}" method="GET" id="form">
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
                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp; Cari Tabelaris Masuk</button>
                            </div>
                        </div>
                    </form>
                    @isset($tanggal)
                        <div class="alert alert-danger">
                            Menampilkan tabelaris kas masuk {{ $tanggal }}
                        </div>
                    @endisset

                    <div class="row">
                        <div class="col-md-12">
                            <a style="margin-bottom:10px !important" class="btn btn-primary btn-sm btn-flat" id="excelExport"><i class="fa fa-file-excel-o"></i>&nbsp;Export Excel</a>
                            <a style="margin-bottom:10px !important" href="{{ route('tabelarisMasuk.pdf') }}" target="_blank" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i>&nbsp; Export PDF</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="tableData" style="width: 100%">
                            <thead class="bg-primary">
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
                                        <td></td>
                                        <td></td>
                                        <th>Saldo Kas Bulan {{ $namaBulanSebelumnya }}</th>
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
                                            @if (isset($saldoKasAwal))
                                                Rp.{{ number_format($saldoKasAwal->modal_awal) }},-
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
                                                <form action="{{ route('tabelarisMasuk.modalAwalPost') }}" method="POST">
                                                    @csrf @method('POST')
                                                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                                                    <input type="hidden" name="bulan" value="{{ $bulanSekarang }}">
                                                    <input type="text" name="saldo_kas" class="form-control" value="{{ number_format($totalSimpananPokok + $totalSimpananWajibs + $totalAngsuranPokok + $totalAngsuranJasa + $totalModalAwal, 0, ',', '.') }}">
                                                    <button type="submit" class="btn btn-primary btn-sm btn-flat">Simpan</button>
                                                </form>
                                            </th>
                                        </tr>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
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
                XLSX.writeFile(workbook, 'tabelaris_kas_masuk.xlsx');
            });
        });
    </script>
@endpush