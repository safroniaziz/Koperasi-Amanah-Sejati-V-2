@extends('layouts.backend')
@section('subTitle', 'Data Jenis Transaksi')
@section('page', 'Data Jenis Transaksi')
@section('subPage', 'Semua Data')
@section('user-login')
    {{-- {{ Auth::user()->nama_lengkap }} --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Tambah Data Transaksi Simpanan Wajib</h3>
                </div>
                <!-- /.box-header -->
                <form action="{{ route('pinjaman.store') }}" method="POST" id="form-create">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="box-body ">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Pilih Nama Anggota</label>
                                <select name="anggota_id" class="form-control" id="">
                                    <option disabled selected>-- pilih nama anggota --</option>
                                    @foreach ($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Jumlah Transaksi</label>
                                <input type="text" name="jumlah_transaksi" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Presentase Jasa</label>
                                <input type="text" name="presentase_jasa" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Angsuran Pokok</label>
                                <input type="text" name="angsuran_pokok" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Angsuran Jasa</label>
                                <input type="text" name="angsuran_jasa" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Jumlah Bulan</label>
                                <input type="text" name="jumlah_bulan" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Bulan Mulai Angsuran</label>
                                <select name="bulan_mulai_angsuran" class="form-control" id="">
                                    <option disabled selected>-- pilih bulan mulai angsuran --</option>
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
                                <label for="">Tahun Mulai Angsuran</label>
                                <input type="text" name="tahun_mulai_angsuran" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Bulan Selesai Angsuran</label>
                                <select name="bulan_selesai_angsuran" class="form-control" id="">
                                    <option disabled selected>-- pilih bulan selesai angsuran --</option>
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
                                <label for="">Tahun Selesai Angsuran</label>
                                <input type="text" name="tahun_selesai_angsuran" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Pinjaman Ke</label>
                                <input type="text" name="pinjaman_ke" class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- box-footer --}}
                    <div class="box-footer">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('pinjaman') }}" class="btn btn-warning btn-sm btn-flat"><i
                                    class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            <button type="reset" class="btn btn-danger btn-sm btn-flat"><i
                                    class="fa fa-refresh"></i>&nbsp; Ulangi</button>
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
    </script>
@endpush