@extends('layouts.backend')
@section('subTitle','Data Kas Pembantu')
@section('page','Data Kas Pembantu')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-book"></i>&nbsp;Buku Kas Pembantu</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @php
                        $tahun = request()->input('tahun');
                        $bulan = request()->input('bulan');
                    @endphp
                    <form action="{{ route('kasPembantu.cariBukuKas') }}" method="GET" id="form">
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
                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp; Cari Buku Kas</button>
                                @if(session()->has('tahunBukuKas') && session()->has('bulanBukuKas'))
                                    <a href="{{ route('kasPembantu.exportData') }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i>&nbsp;Export Data</a>
                                    <a href="{{ route('kasPembantu.exportDataPdf') }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;Export Data</a>
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
                                <th>Keluar</th>
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
                                    <td> - </td>
                                    <td>
                                        Rp.{{ number_format($modalAwal->modal_awal) }},-
                                    </td>
                                </tr>
                                    @foreach ($transaksis as $index => $transaksi)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->isoFormat('D MMMM YYYY')}}</td>
                                            <td>{{ $transaksi->jenisTransaksi ? $transaksi->jenisTransaksi->nama_jenis_transaksi : '' }} - {{ $transaksi->anggota->nama_lengkap }}</td>
                                            <td>
                                                @if ($transaksi->kategori_transaksi == "masuk")
                                                    Rp.{{ number_format($transaksi->jumlah_transaksi,2) }}
                                                    @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($transaksi->kategori_transaksi == "keluar")
                                                    Rp.{{ number_format($transaksi->jumlah_transaksi,2) }}
                                                    @else
                                                    -
                                                @endif
                                            </td>
                                            <td>

                                                @if ($transaksi->kategori_transaksi == "masuk")
                                                    Rp.{{ number_format($transaksi->jumlah_transaksi + $modalAwal->modal_awal,2) }}
                                                    @php
                                                        $modalAwal->modal_awal = $transaksi->jumlah_transaksi + $modalAwal->modal_awal;
                                                    @endphp
                                                    @else
                                                        Rp.{{ number_format($modalAwal->modal_awal - $transaksi->jumlah_transaksi,2) }}
                                                    @php
                                                        $modalAwal->modal_awal = $modalAwal->modal_awal - $transaksi->jumlah_transaksi;
                                                    @endphp
                                                @endif
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
        // $(document).on('submit','#form',function (event){
        //     event.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: $(this).attr('method'),
        //         typeData: "JSON",
        //         data: new FormData(this),
        //         processData:false,
        //         contentType:false,
        //         success : function(res) {
        //             $("#btnSubmit"). attr("disabled", true);
        //             toastr.success(res.text, 'Yeay, Berhasil');
        //             setTimeout(function () {
        //                 window.location.href=res.url;
        //             } , 100);
        //         },
        //         error:function(xhr){
        //             toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
        //         }
        //     })
        // });

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