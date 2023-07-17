@extends('layouts.backend')
@section('subTitle','Dashboard')
@section('page','Dashboard')
@section('user-login')
    {{-- {{ Auth::user()->nama_lengkap }} --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel" style="margin-bottom:20px;">
                <header class="bg-primary" style="color: #ffffff;background-color: #3c8dbc;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                    <i class="fa fa-home"></i>&nbsp;Dashboard
                </header>
                <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                    <div class="row" style="margin-right:-15px; margin-left:-15px;">
                        <div class="col-md-12" style="text-transform: capitalize;">Selamat datang <strong>  </strong> di halaman Dashboard <b> Sistem Informasi Pengaduan Dan Aspirasi Masyarakat</b></div>
                    </div>
                </div>
            </section>

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

                                <p>Berita & Pengumuman</p>
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

                                <p>Daerah Pemilihan</p>
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

                                <p>Organisasi Perangkat Daerah</p>
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

                                <p>Satuan Volume</p>
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

                                <p>Dokumen Reses</p>
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

                                <p>Kategori Pengaduan</p>
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

                                <p>Pengaduan Masyarat</p>
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

                                <p>Aspirasi Masyarakat</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-pen"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
