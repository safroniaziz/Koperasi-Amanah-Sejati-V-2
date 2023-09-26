@extends('layouts.backend')
@section('subTitle','Data Modal Awal')
@section('page','Data Modal Awal')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-money-bill"></i>&nbsp;Manajemen Data Modal Awal</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modalTambah">
                            <i class="fa fa-plus"></i>&nbsp;Tambah Data
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>Modal Awal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($modalAwals as $index => $modalAwal)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $modalAwal->tahun }}</td>
                                    <td>{{ date("F", mktime(0, 0, 0, $modalAwal->bulan, 1)) }}</td>
                                    <td>Rp.{{ number_format($modalAwal->modal_awal) }},-</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a onclick="editModalAwal({{ $modalAwal->id }})" class="btn btn-success btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('modalAwal.delete',[$modalAwal->id]) }}" method="POST" id="form-hapus">
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
                                    <td colspan="5" class="text-center" style="font-style:italic;">
                                        <a class="text-danger">data masih kosong</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @include('backend/modalAwal/partials/modal_add')
                    </table>
                    @include('backend/modalAwal/partials/modal_edit')
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

        function editModalAwal(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('modal_awal').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#modalEdit').modal('show');
                    $('#modal_awal_id_edit').val(data.id);
                    $('#tahun_edit').val(data.tahun);
                    $('#bulan_edit').val(data.bulan);
                    $('#modal_awal_edit').val(data.modal_awal);
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
