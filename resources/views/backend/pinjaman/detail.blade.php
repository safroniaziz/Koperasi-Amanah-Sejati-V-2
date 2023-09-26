@extends('layouts.backend')
@section('subTitle', 'Data Pinjaman')
@section('page', 'Data Pinjaman')
@section('subPage', 'Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info-circle"></i>&nbsp;Detail Pinjaman</h3>
                    <div class="pull-right">
                        <a href="{{ route('pinjaman.create',[$anggota->id]) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <a href="{{ route('pinjaman') }}" style="margin-bottom: 10px !important;" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    <div class="alert alert-danger">
                        Detail Angsuran Anggota : <b><u><i>{{ $anggota->nama_lengkap }}</i></u></b>
                    </div>
                    <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peminjaman</th>
                                <th>Persentase Jasa</th>
                                <th>Angsuran Pokok</th>
                                <th>Angsuran Jasa</th>
                                <th>Bulan Angsuran</th>
                                <th>Sudah Mengangsur</th>
                                <th>Pinjaman Ke</th>
                                <th>Status Peminjaman</th>
                                <th>Angsuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($anggota->pinjamans as $index => $pinjaman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>Rp.{{ number_format($pinjaman->jumlah_transaksi) }},-</td>
                                    <td>{{ $pinjaman->presentase_jasa }}%</td>
                                    <td>{{ $pinjaman->angsuran_pokok }}</td>
                                    <td>{{ $pinjaman->angsuran_jasa }}</td>
                                    <td>{{ $pinjaman->jumlah_bulan }} Bulan</td>
                                    <td>{{ $pinjaman->jumlahAngsuran() }} Kali</td>
                                    <td>{{ $pinjaman->pinjaman_ke }}</td>
                                    <td>
                                        @if ($pinjaman->is_paid == 0)
                                            <small class="label label-danger">Belum Lunas</small>
                                        @else
                                            <small class="label label-success">Lunas</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('angsuran',[$anggota->id,$pinjaman->id]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp;Angsuran</a>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('pinjaman.edit',[$anggota->id, $pinjaman->id]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('pinjaman.delete',[$anggota->id, $pinjaman->id]) }}" method="POST" id="form-hapus">
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
                                    <td colspan="8" class="text-center" style="font-style:italic;">
                                        <a class="text-danger">data masih kosong</a>
                                    </td>
                                </tr>
                            @endforelse
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
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        $(document).on('submit', '#form-hapus', function(event) {
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
            var form = $(this).closest("form");
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
