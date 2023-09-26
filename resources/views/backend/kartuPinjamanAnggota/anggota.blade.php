@extends('layouts.backend')
@section('subTitle', 'Kartu Pinjaman Anggota')
@section('page', 'Kartu Pinjaman Anggota')
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
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="alert alert-danger">
                        Detail Pinjaman Anggota : <b><u><i>{{ $anggota->nama_lengkap }}</i></u></b>
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
                                        <a target="_blank" href="{{ route('kartuPinjaman.cetak',[$anggota->id,$pinjaman->id]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp; Cetak</a>
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
    </script>
@endpush
