@extends('layouts.backend')
@section('subTitle', 'Data Anggota')
@section('page', 'Data Anggota')
@section('subPage', 'Semua Data')
@section('user-login')
    {{-- {{ Auth::user()->nama_lengkap }} --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Edit Data Anggota</h3>
                </div>
                <!-- /.box-header -->
                <form action="{{ route('anggota.update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
                    {{ csrf_field() }} {{ method_field('PATCH') }}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Pilih Jabatan</label>
                                <input type="hidden" name="anggota_id_edit" value="{{ $anggota->id }}">
                                <select name="jabatan_id" class="form-control" id="">
                                    <option disabled selected>-- pilih jabatan --</option>
                                    @foreach ($jabatans as $jabatan)
                                        <option {{ $anggota->jabatan_id == $jabatan->id ? 'selected' : '' }}
                                            value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Nama Anggota</label>
                                <input type="text" name="nama_lengkap" value="{{ $anggota->nama_lengkap }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" value="{{ $anggota->nik }}" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Tahun Keanggotaan</label>
                                <input type="text" name="tahun_keanggotaan" value="{{ $anggota->tahun_keanggotaan }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Alamat</label>
                                <textarea name="alamat" class="form-control" id="" cols="30" rows="3">{{ $anggota->alamat }}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Simpanan Pokok</label>
                                <input type="text" name="simpanan_pokok" value="Rp. 500000,-" class="form-control"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Email</label>
                                <input type="text" name="email" value="{{ $anggota->email }}" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Foto</label>
                                <input type="file" name="image_path" onchange="previewFoto2()" class="form-control">
                                <small class="label label-danger">File Lama : {{ $anggota->image_path }}</small>
                            </div>

                            <div class="col-md-12">
                                <img class="foto-baru2" id="preview-foto2" src="" height="100" width="100"
                                    alt="" style="font-size:12px;">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('anggota') }}" class="btn btn-warning btn-sm btn-flat"><i
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
        function previewFoto2() {
            var preview = document.querySelector('#preview-foto2');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }

        $(document).on('submit', '#form-edit', function(event) {
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
