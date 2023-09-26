@extends('layouts.backend')
@section('subTitle', 'Data SHU')
@section('page', 'Data SHU')
@section('subPage', 'Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp;Detail SHU</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modalTambah">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Data
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <a href="{{ route('shu') }}" style="margin-bottom: 10px !important;" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    <div class="alert alert-danger">
                        Detail SHU Anggota : <b><u><i>{{ $anggota->nama_lengkap }}</i></u></b>
                    </div>
                    <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th style=" vertical-align:middle">No</th>
                                <th style=" vertical-align:middle">Nama Anggota</th>
                                <th style=" vertical-align:middle">Jabatan</th>
                                <th style=" vertical-align:middle">SHU Pinjaman</th>
                                <th style=" vertical-align:middle">SHU Jasa</th>
                                <th style=" vertical-align:middle">Jumlah</th>
                                <th style=" vertical-align:middle">Tahun</th>
                                <th style=" vertical-align:middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($shus as $index => $shu)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $shu->anggota->nama_lengkap }}</td>
                                <td>{{ $shu->anggota->jabatan->nama_jabatan }}</td>
                                <td>Rp.{{ number_format($shu->total_shu_simpanan) }}</td>
                                <td>Rp.{{ number_format($shu->total_shu_jasa) }}</td>
                                <td>Rp.{{ number_format($shu->totalShuSimpanan + $shu->totalShuJasa) }}</td>
                                <td>{{ $shu->tahun }}</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>
                                                <a onclick="editShu({{ $shu->id }})" class="btn btn-success btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('shu.delete',[$anggota->id,$shu->id]) }}" method="POST" id="form-hapus">
                                                    {{ csrf_field() }} {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm btn-flat show_confirm"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center" style="font-style:italic;">
                                        <a class="text-danger">data masih kosong</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @include('backend/shu/partials.modal_add')
            </div>
            @include('backend/shu/partials.modal_edit')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function editShu(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('sisa_hasil_usaha').'/' }}"+id+'/edit',
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#shu_id_edit').val(data.id);
                    $('#tahun_edit').val(data.tahun);
                    $('#shu_simpanan_edit').val(data.shu_simpanan);
                    $('#shu_jasa_edit').val(data.shu_jasa);
                    $('#jumlah_edit').val(data.jumlah);
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }

        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: `Apakah Anda Yakin?`,
                text: "Harap untuk memeriksa kembali sebelum menghapus data.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                form.submit();
                }
            });
        });

        $(document).on('submit','#form-hapus',function (event){
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
