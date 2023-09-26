@extends('layouts.backend')
@section('subTitle','Data Operator')
@section('page','Data Operator')
@section('subPage','Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-users"></i>&nbsp;Manajemen Data Operator</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form method="GET">
                            <div class="form-group col-md-12" style="margin-bottom: 5px !important;">
                                <label for="nama" class="col-form-label">Cari Nama Investor</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama/Email Anggota..." value="{{$nama}}">
                            </div>
                            <div class="col-md-12" style="margin-bottom:10px !important;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat mb-2"><i class="fa fa-search"></i>&nbsp;Cari Data</button>
                            </div>
                        </form>
                    </div>
                    <small class="label label-default">Total Data : {{ $operators->total() }} Data</small>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startIndex = ($operators->currentPage() - 1) * $operators->perPage();
                                @endphp
                                @forelse ($operators as $index => $operator)
                                    <tr>
                                        <td> {{ $startIndex + $index + 1 }} </td>
                                        <td>{{ $operator->nama_lengkap }}</td>
                                        <td>{{ $operator->email }}</td>
                                        <td>{{ $operator->jabatan->nama_jabatan }}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('operator.edit',[$operator->id]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('operator.delete',[$operator->id]) }}" method="POST" id="form-hapus">
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
                                        <td colspan="7" class="text-center" style="font-style:italic;">
                                            <a class="text-danger">data operator masih kosong</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{$operators->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
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
