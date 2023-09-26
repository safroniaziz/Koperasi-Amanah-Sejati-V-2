@extends('layouts.backend')
@section('subTitle', 'Data Simpanan Wajib')
@section('page', 'Data Simpanan Wajib')
@section('subPage', 'Semua Data')
@section('sidebar-collapse')
    sidebar-collapse
@endsection
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-search"></i>&nbsp;Detail Simpanan Wajib Anggota</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-hover table-striped" style="width: 100%">
                        <tbody>
                            <tr>
                                <th>Nama Anggota</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->nama_lengkap }}
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->jabatan->nama_jabatan }}
                                </td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->nik }}
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->alamat }}
                                </td>
                            </tr>
                            <tr>
                                <th>Tahun Keanggotaan</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->tahun_keanggotaan }}
                                </td>
                            </tr>
                            @foreach ($anggota->jumlahSimpananWajibPerTahun() as $tahun => $totalSimpanan)
                                    <th>Simpanan Wajib Tahun {{ $tahun }}</th>
                                    <th>:</th>
                                    <td>
                                        Rp.{{ number_format($totalSimpanan) }},-
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: green; color:white">
                                <th>Jumlah Transaksi Keseluruhan</th>
                                <th>:</th>
                                <td>
                                    Rp.{{ number_format($anggota->jumlahSimpananWajib()) }},-
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-user"></i>&nbsp;Riwayat Transaksi Simpanan Wajib <b><u>{{ $anggota->nama_lengkap }}</u></b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-tools" style="margin-bottom: 5px !important;" id="btn-create">
                        <a onclick="tambahTransaksi()" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Transaksi</a>
                    </div>
                    @include('backend/simpananWajib.create')
                    @include('backend/simpananWajib.edit')
                    <table class="table table-hover table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jumlah Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Bulan Transaksi</th>
                                <th>Tahun Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->simpananWajibs as $index => $simpananWajib)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>Rp.{{ number_format($simpananWajib->jumlah_transaksi) }},-</td>
                                    <td>{{ $simpananWajib->tanggal_transaksi }}</td>
                                    <td>{{ $simpananWajib->bulan_transaksi }}</td>
                                    <td>{{ $simpananWajib->tahun_transaksi }}</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a onclick="editTransaksi({{ $simpananWajib->id }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('simpananWajib.delete',[$simpananWajib->id]) }}" method="POST" class="form">
                                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                                        <input type="hidden" name="anggota_id" value="{{ $anggota->id }}">
                                                        <button type="submit" class="btn btn-danger show_confirm btn-sm btn-flat"><i class="fa fa-trash"></i>&nbsp; Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        function tambahTransaksi(){
            $('#form-create').show();
            $('#form-edit').hide();
            $('#btn-create').hide();
        }

        function batalkan(){
            $('#form-create').hide();
            $('#form-edit').hide();
            $('#btn-create').show();
        }

        function editTransaksi(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('simpanan_wajib').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#form-create').hide();
                    $('#btn-create').hide();
                    $('#form-edit').show();
                    $('#simpanan_wajib_id').val(data.id);
                    $('#jumlah_transaksi_edit').val(data.jumlah_transaksi);
                    $('#tanggal_transaksi_edit').val(data.tanggal_transaksi);
                    $('#bulan_transaksi_edit').val(data.bulan_transaksi);
                    $('#tahun_transaksi_edit').val(data.tahun_transaksi);
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }

        function batalkanEdit(){
            $('#form-create').hide();
            $('#form-edit').hide();
            $('#btn-create').hide   ();
        }

        $(document).on('submit', '.form', function(event) {
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
    </script>
@endpush