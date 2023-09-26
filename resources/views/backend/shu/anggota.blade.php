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
                </div>
                <!-- /.box-header -->
                <div class="box-body">
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
