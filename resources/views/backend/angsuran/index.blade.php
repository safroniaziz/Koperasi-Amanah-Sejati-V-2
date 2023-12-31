@extends('layouts.backend')
@section('subTitle', 'Data Pinjaman')
@section('page', 'Data Pinjaman')
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
                    <h3 class="box-title"><i class="fa fa-search"></i>&nbsp;Detail Pinjaman Anggota</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-hover table-striped" style="width: 100%">
                        <tbody>
                            <tr>
                                <th colspan="3">
                                    <a href="{{ route('pinjaman.detail',[$anggota->id]) }}" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                                </th>
                            </tr>
                            <tr>
                                <th>Nama Anggota</th>
                                <th>:</th>
                                <td>
                                    {{ $anggota->nama_lengkap }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Pinjaman</th>
                                <th>:</th>
                                <td>
                                    Rp.{{ number_format($pinjaman->jumlah_transaksi) }},-
                                </td>
                            </tr>
                            <tr>
                                <th>Persentase Jasa</th>
                                <th>:</th>
                                <td>
                                    {{ $pinjaman->presentase_jasa }}
                                </td>
                            </tr>
                            <tr>
                                <th>Angsuran Pokok</th>
                                <th>:</th>
                                <td>
                                    Rp.{{ number_format($pinjaman->angsuran_pokok) }},-
                                </td>
                            </tr>
                            <tr>
                                <th>Angsuran Jasa</th>
                                <th>:</th>
                                <td>
                                    Rp.{{ number_format($pinjaman->angsuran_jasa) }},-
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Bulan</th>
                                <th>:</th>
                                <td>
                                    {{ $pinjaman->jumlah_bulan }} Bulan
                                </td>
                            </tr>
                            <tr>
                                <th>Sudah Mengangsur</th>
                                <th>:</th>
                                <td>
                                    {{ $pinjaman->jumlahAngsuran() }} Bulan
                                </td>
                            </tr>
                            <tr>
                                <th>Mulai Angsuran</th>
                                <th>:</th>
                                <td>
                                    {{ $pinjaman->bulan_mulai_angsuran.' '.$pinjaman->tahun_mulai_angsuran }}
                                </td>
                            </tr>
                            <tr>
                                <th>Selesai Angsuran</th>
                                <th>:</th>
                                <td>
                                    {{ $pinjaman->bulan_selesai_angsuran.' '.$pinjaman->tahun_selesai_angsuran }}
                                </td>
                            </tr>
                            <tr>
                                <th>Pinjaman Ke</th>
                                <th>:</th>
                                <td>
                                    {{ $pinjaman->pinjaman_ke }}
                                </td>
                            </tr>
                            <tr>
                                <th>Status Pinjaman</th>
                                <th>:</th>
                                <td>
                                    @if ($pinjaman->is_paid == 0)
                                        <small class="label label-danger">Belum Lunas</small>
                                    @else
                                        <small class="label label-success">Lunas</small>
                                    @endif
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
                    <h3 class="box-title"><i class="fa fa-user"></i>&nbsp;Riwayat Angsuran Anggota <b><u>{{ $anggota->nama_lengkap }}</u></b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-tools" style="margin-bottom: 5px !important;" id="btn-create">
                        <a onclick="tambahTransaksi()" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Transaksi</a>
                    </div>
                    @include('backend/angsuran.create')
                    @include('backend/angsuran.edit')
                    <table class="table table-hover table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pokok</th>
                                <th>Jasa</th>
                                <th>Tanggal Transaksi</th>
                                {{-- <th>Bulan Transaksi</th>
                                <th>Tahun Transaksi</th> --}}
                                <th>Angsuran Ke</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($angsurans as $index => $angsuran)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>Rp.{{ number_format($angsuran->angsuran_pokok) }},-</td>
                                    <td>Rp.{{ number_format($angsuran->angsuran_jasa) }},-</td>
                                    <td>{{ $angsuran->tanggal_transaksi->isoFormat('dddd, DD MMMM YYYY') }}</td>
                                    {{-- <td>{{ $angsuran->bulan_transaksi }}</td>
                                    <td>{{ $angsuran->tahun_transaksi }}</td> --}}
                                    <td>{{ $angsuran->angsuran_ke }}</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a onclick="editTransaksi({{ $angsuran->id }})" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('angsuran.delete',[$angsuran->id]) }}" method="POST" class="form">
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
            url = "{{ url('pinjaman').'/' }}"+id+'/edit';
            $.ajax({
                url : url,
                type : 'GET',
                success : function(data){
                    $('#form-create').hide();
                    $('#btn-create').hide();
                    $('#form-edit').show();
                    $('#angsuran_id').val(data.id);
                    $('#jumlah_transaksi_edit').val(data.jumlah_transaksi);
                    $('#tanggal_transaksi_edit').val(data.tanggal_transaksi);
                    // $('#bulan_transaksi_edit').val(data.bulan_transaksi);
                    // $('#tahun_transaksi_edit').val(data.tahun_transaksi);
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