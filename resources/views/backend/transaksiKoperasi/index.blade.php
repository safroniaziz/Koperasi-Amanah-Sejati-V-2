@extends('layouts.backend')
@section('subTitle', 'Data Transaksi Koperasi')
@section('page', 'Data Transaksi Koperasi')
@section('subPage', 'Semua Data')
@section('user-login')
    {{-- {{ Auth::user()->nama_lengkap }} --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Manajemen Data Pinjaman</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ route('transaksiKoperasi.create') }}" class="btn btn-primary btn-sm btn-flat"><i
                                class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="fa fa-success-circle"></i><strong>Berhasil :</strong> {{ $message }}
                        </div>
                    @endif
                    <table class="table table-bordered table-hover" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Transaksi</th>
                                <th>Nama Anggota</th>
                                <th>Jumlah Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Bulan Transaksi</th>
                                <th>Tahun Transaksi</th>
                                <th>Angsuran Ke</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($transaksiKoperasis as $index => $transaksiKoperasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaksiKoperasi->jenisTransaksi->nama_jenis_transaksi }}</td>
                                    <td>{{ $transaksiKoperasi->anggota->nama_lengkap }}</td>
                                    <td>{{ $transaksiKoperasi->jumlah_transaksi }}</td>
                                    <td>{{ $transaksiKoperasi->tanggal_transaksi }}</td>

                                    @php
                                        $bulan = $transaksiKoperasi->bulan_transaksi;
                                        $bulanTransaksi = \Carbon\Carbon::parse('2023-' . $bulan . '-01')->format('F');
                                    @endphp
                                    <td>{{ $bulanTransaksi }}</td>

                                    <td>{{ $transaksiKoperasi->tahun_transaksi }}</td>
                                    <td>{{ $transaksiKoperasi->angsuran_ke }}</td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <a onclick="editJenisTransaksi({{ $transaksiKoperasi->id }})"
                                                        class="btn btn-success btn-sm btn-flat"><i
                                                            class="fa fa-edit"></i>&nbsp; Edit</a>
                                                </td>
                                                <td>
                                                    <form
                                                        action="{{ route('jenisTransaksi.delete', [$transaksiKoperasi->id]) }}"
                                                        method="POST" id="form-hapus">
                                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm btn-flat show_confirm"><i
                                                                class="fa fa-trash"></i>&nbsp;Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center" style="font-style:italic;">
                                        <a class="text-danger">data jenis transaksi masih kosong</a>
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
                responsive: true,
            });
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
