@extends('layouts.backend')
@section('subTitle','Data Anggota')
@section('page','Data Anggota')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-users"></i>&nbsp;Tambah Data Anggota</h3>
                </div>
                <!-- /.box-header -->
                <form action="{{ route('anggota.store') }}" method="POST" id="form-create" enctype="multipart/form-data">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Pilih Jabatan</label>
                                <select name="jabatan_id" class="form-control" id="">
                                    <option disabled selected>-- pilih jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Nama Anggota</label>
                                <input type="text" name="nama_lengkap" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Tahun Keanggotaan</label>
                                <input type="text" name="tahun_keanggotaan" class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Alamat</label>
                                <textarea name="alamat" class="form-control" id="" cols="30" rows="3"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Simpanan Pokok</label>
                                <input type="text" name="simpanan_pokok" value="Rp. 500000,-" class="form-control" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Konfiramsi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('anggota') }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            <button type="reset" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp; Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('submit','#form-create',function (event){
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    $("#btnSubmit"). attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 100);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                }
            })
        });
    </script>
@endpush
