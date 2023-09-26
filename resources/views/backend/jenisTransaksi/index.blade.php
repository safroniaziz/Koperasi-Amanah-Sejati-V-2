@extends('layouts.backend')
@section('subTitle','Data Jenis Transaksi')
@section('page','Data Jenis Transaksi')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Manajemen Data Jenis Transaksi</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modalTambah">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Data
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="fa fa-success-circle"></i><strong>Berhasil :</strong> {{ $message }}
                        </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis Transaksi</th>
                                <th>Kategori Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @forelse ($jenisTransaksis as $index => $jenisTransaksi)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $jenisTransaksi->nama_jenis_transaksi }}</td>
                                    <td>
                                        @if ($jenisTransaksi->kategori_transaksi == "masuk")
                                            <small class="label label-primary"><i class="fa fa-arrow-circle-left">&nbsp;</i>Masuk</small>
                                        @else
                                            <small class="label label-danger"><i class="fa fa-arrow-circle-right">&nbsp;</i>Keluar</small>
                                        @endif
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a onclick="editJenisTransaksi({{ $jenisTransaksi->id }})" class="btn btn-success btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('jenisTransaksi.delete',[$jenisTransaksi->id]) }}" method="POST" id="form-hapus">
                                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger btn-sm btn-flat show_confirm"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center" style="font-style:italic;">
                                        <a class="text-danger">data jenis transaksi masih kosong</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @include('backend/jenisTransaksi/partials/modal_add')
                    </table>
                    @include('backend/jenisTransaksi/partials/modal_edit')
                </div>
            </div>
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

        function editJenisTransaksi(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('jenis_transaksi').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#jenis_transaksi_id_edit').val(data.id);
                    $('#nama_jenis_transaksi_edit').val(data.nama_jenis_transaksi);
                    $('#kategori_transaksi_edit').val(data.kategori_transaksi);
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
