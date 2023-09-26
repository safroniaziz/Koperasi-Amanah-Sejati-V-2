@extends('layouts.backend')
@section('subTitle', 'Data Simpanan Wajib')
@section('page', 'Data Simpanan Wajib')
@section('subPage', 'Semua Data')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Manajemen Data Simpanan Wajib</h3>
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
                    <small class="label label-default">Total Data : {{ $anggotas->total() }} Data</small>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Total Bertransaksi</th>
                                    <th>Jumlah Keseluruhan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startIndex = ($anggotas->currentPage() - 1) * $anggotas->perPage();
                                @endphp
                                @forelse ($anggotas as $index => $anggota)
                                    <tr>
                                        <td> {{ $startIndex + $index + 1 }} </td>
                                        <td>{{ $anggota->nama_lengkap }}</td>
                                        <td>{{ $anggota->totalSimpananWajib() }} Kali</td>
                                        <td>Rp.{{ number_format($anggota->jumlahSimpananWajib()) }},-</td>
                                        <td>
                                            <a href="{{ route('simpananWajib.detail',[$anggota->id]) }}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-search"></i>&nbsp;Detail</a>
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
                        {{$anggotas->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection