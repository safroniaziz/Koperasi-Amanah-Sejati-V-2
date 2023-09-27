@extends('layouts.backend')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
           
            <div class="callout callout-info ">
                <h4>SELAMAT DATANG!</h4>
                <p>
                    Sistem Informasi Koperasi adalah aplikasi yang digunakan untuk memanajemen data investor pada Koperasi Amanah,
                    anda dapat menggunakan menu-menu yang sudah disediakan pada aplikasi.
                    <br>
                    <b><i>Catatan:</i></b> Untuk keamanan, jangan lupa keluar setelah menggunakan aplikasi
                </p>
            </div>

            @if (auth()->user()->hasRole('Operator'))
                <section class="panel">
                    <header class="panel-heading" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                        <i class="fa fa-bar-chart"></i>&nbsp;Informasi Aplikasi
                    </header>
                    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-aqua" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Jabatan</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-bullhorn"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-red" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Jenis Transaksi</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-map-marker-alt"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-yellow" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Pinjaman</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-building"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-green" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>19</h3>

                                    <p>Anggota</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-balance-scale"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-aqua" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Simpanan Wajib</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-file-pdf"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-red" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Tahun Aktif</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-tasks"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-yellow" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Transaksi Masuk</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12 col-md-3" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-green" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3>10</h3>

                                    <p>Transaksi Keluar</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection
