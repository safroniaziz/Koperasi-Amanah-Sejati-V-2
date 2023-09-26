@extends('layouts.backend')
@section('subTitle', 'Data Transaksi Koperasi')
@section('page', 'Data Transaksi Koperasi')
@section('subPage', 'Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-edit"></i>&nbsp;Edit Data Transaksi Koperasi</h3>
                </div>
                <!-- /.box-header -->
                <form action="{{ route('transaksiKoperasi.update',[$transaksiKoperasi->id]) }}" method="POST" id="form-create">
                    {{ csrf_field() }} {{ method_field('PATCH') }}
                    <div class="box-body ">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Pilih Jenis Transaksi</label>
                                <select name="jenis_transaksi_id" class="form-control" id="jenis_transaksi_id">
                                    <option disabled selected>-- pilih jenis transaksi --</option>
                                    @foreach ($jenisTransaksis as $jenisTransaksi)
                                        <option {{ $transaksiKoperasi->jenis_transaksi_id == $jenisTransaksi->id ? 'selected' : '' }} value="{{ $jenisTransaksi->id }}">{{ $jenisTransaksi->nama_jenis_transaksi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Yang Bertransaksi</label>
                                <input type="text" name="anggota_id" value="{{ $anggota->nama_lengkap }}" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Jumlah Transaksi</label>
                                <input type="text" name="jumlah_transaksi" value="{{ $transaksiKoperasi->jumlah_transaksi }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" value="{{ date('Y-m-d', strtotime($transaksiKoperasi->tanggal_transaksi)) }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Bulan Transaksi</label>
                                <select name="bulan_transaksi" class="form-control" id="">
                                    <option disabled selected>-- pilih bulan bulan transaksi --</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Januari" ? 'selected' : '' }} value="1">Januari</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Februari" ? 'selected' : '' }} value="2">Februari</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Maret" ? 'selected' : '' }} value="3">Maret</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "April" ? 'selected' : '' }} value="4">April</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Mei" ? 'selected' : '' }} value="5">Mei</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Juni" ? 'selected' : '' }} value="6">Juni</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Juli" ? 'selected' : '' }} value="7">Juli</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Agustus" ? 'selected' : '' }} value="8">Agustus</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "September" ? 'selected' : '' }} value="9">September</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Oktober" ? 'selected' : '' }} value="10">Oktober</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "November" ? 'selected' : '' }} value="11">November</option>
                                    <option {{ $transaksiKoperasi->bulan_transaksi == "Desember" ? 'selected' : '' }} value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Tahun Transaksi</label>
                                <select name="tahun_transaksi" id="tahun_transaksi" class="form-control"></select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="" cols="30" rows="3">{{ $transaksiKoperasi->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                    {{-- box-footer --}}
                    <div class="box-footer">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('transaksiKoperasi') }}" class="btn btn-warning btn-sm btn-flat"><i
                                    class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            <button type="reset" class="btn btn-danger btn-sm btn-flat"><i
                                    class="fa fa-refresh"></i>&nbsp;
                                Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm btn-flat"><i
                                    class="fa fa-check-circle"></i>&nbsp; Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('submit', '#form-create', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(res) {
                    $("#btnSubmit").attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function() {
                        window.location.href = res.url;
                    }, 100);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                }
            })
        });

        $(document).ready(function() {
            $('#jenis_transaksi_id').select2();
        });

        $('#tahun_transaksi').each(function() {
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
