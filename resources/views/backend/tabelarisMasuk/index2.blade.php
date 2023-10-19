@extends('layouts.backend')
@section('subTitle','Tabelaris Kas Masuk')
@section('page','Tabelaris Kas Masuk')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-book"></i>&nbsp;Tabelaris Kas Masuk</h3>
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
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Pilih Tahun</label>
                                <select name="tahun" id="tahun" class="form-control"></select>
                            </div>

                            <div class="col-md-12 text-center" style="margin-bottom: 10px;">
                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp; Cari</button>
                                @if(session()->has('tahunKasMasuk') && session()->has('bulanKasMasuk'))
                                    <a href="{{ route('tabelarisMasuk.exportData') }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i>&nbsp;Export Data</a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-hover table-striped" id="kelas" style="width: 100%">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Transaksi</th>
                                <th>Uraian</th>
                                <th>Masuk</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tahun)
                                <tr>
                                    <td>1</td>
                                    <td>1 {{ \Carbon\Carbon::createFromDate(null, $bulan)->locale('id')->monthName }} {{ $tahun }}</td>
                                    <td>Modal Awal</td>
                                    <td>
                                        Rp.{{ number_format($modalAwal->modal_awal) }},-
                                    </td>
                                    <td>
                                        Rp.{{ number_format($modalAwal->modal_awal) }},-
                                    </td>
                                </tr>
                                @php
                                $modalAwalSesudah = $modalAwal->modal_awal;
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
                                        $modalAwalSesudah += $transaksi->jumlah_transaksi;
                                        @endphp
                                        <td>
                                            Rp.{{ number_format($modalAwalSesudah, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
    </script>
@endpush