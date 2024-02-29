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
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Tambah Data Pinjaman <b><u><i>{{ $anggota->nama_lengkap }}</i></u></b></h3>
                </div>
                <!-- /.box-header -->
                <form action="{{ route('pinjaman.store',[$anggota->id]) }}" method="POST" id="form-create">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="box-body ">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Jumlah Transaksi <small style="display: none;" id="alert" class="text-danger">Maksimal Rp.25.000.000</small></label>
                                <input type="text" name="jumlah_transaksi" id="jumlah_transaksi" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Bulan Transaksi</label>
                                <select name="bulan_transaksi" id="bulan_transaksi" class="form-control" id="bulan">
                                <option disabled selected>-- pilih bulan --</option>
                                @foreach ($bulans as $bulan)
                                    <option value="{{ $bulan }}">{{ $bulan }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Tahun Transaksi</label>
                                <input type="text" name="tahun_transaksi" id="tahun_transaksi" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Jumlah Bulan Angsuran</label>
                                <select name="jumlah_bulan" id="jumlah_bulan" class="form-control" id="">
                                    <option disabled selected>-- pilih jumlah bulan --</option>
                                    <option value="12">12 Bulan</option>
                                    <option value="24">24 Bulan</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Persentase Jasa</label>
                                <input type="text" name="presentase_jasa" id="presentase_jasa" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Angsuran Pokok</label>
                                <input type="text" name="angsuran_pokok" id="angsuran_pokok" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Angsuran Jasa</label>
                                <input type="text" name="angsuran_jasa" id="angsuran_jasa" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Bulan Mulai Angsuran</label>
                                <select name="bulan_mulai_angsuran" id="bulan_mulai_angsuran" class="form-control" id="">
                                    <option disabled selected>-- pilih bulan mulai angsuran --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Tahun Mulai Angsuran</label>
                                <input type="text" name="tahun_mulai_angsuran" id="tahun_mulai_angsuran" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Bulan Selesai Angsuran</label>
                                <select name="bulan_selesai_angsuran" id="bulan_selesai_angsuran" class="form-control" readonly id="">
                                    <option disabled selected>-- pilih bulan mulai angsuran --</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Tahun Selesai Angsuran</label>
                                <input type="text" name="tahun_selesai_angsuran" id="tahun_selesai_angsuran" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    {{-- box-footer --}}
                    <div class="box-footer">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('pinjaman.detail',[$anggota->id]) }}" class="btn btn-warning btn-sm btn-flat"><i
                                    class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                            <button type="reset" class="btn btn-danger btn-sm btn-flat"><i
                                    class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm btn-flat"><i
                                    class="fa fa-check-circle"></i>&nbsp; Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('submit', '#form-create', function(event) {
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

        $(document).ready(function(){
            $("#jumlah_transaksi").keyup(function(){
                var jumlah_transaksi = $("#jumlah_transaksi").val();
                if (jumlah_transaksi >25000000) {
                    $('#alert').show();
                }
                else{
                    $('#alert').hide();
                }
            });
        });

        $(document).ready(function(){
            $("#jumlah_transaksi").on('keyup', function(){
                calculateValues();
            });

            $(document).on('change', '#jumlah_bulan', function() {
                var jumlah_bulan = parseInt($(this).val());
                calculateValues();
            });

            function calculateValues() {
                var jumlah_transaksi = parseFloat($("#jumlah_transaksi").val());
                var jumlah_bulan = parseInt($('#jumlah_bulan').val());

                if (!isNaN(jumlah_transaksi) && !isNaN(jumlah_bulan) && jumlah_bulan !== 0) {
                    var jumlah = jumlah_transaksi / jumlah_bulan;

                    if (jumlah_bulan === 12) {
                        var bunga = ((jumlah_transaksi * 8) / 100) / jumlah_bulan;
                        $('#presentase_jasa').val("8");
                    } else {
                        var bunga = ((jumlah_transaksi * 16) / 100) / jumlah_bulan;
                        $('#presentase_jasa').val("16");
                    }

                    $('#angsuran_pokok').val(jumlah);
                    $('#angsuran_jasa').val(bunga);
                } else {
                    $('#angsuran_pokok').val("");
                    $('#angsuran_jasa').val("");
                    $('#presentase_jasa').val("");
                }
            }
        });

        $(document).ready(function() {
    $("#jumlah_bulan, #bulan_mulai_angsuran, #tahun_mulai_angsuran").on("change input", function() {

        var bulanMulaiAngsuran = parseInt($("#bulan_mulai_angsuran").val());
        var jumlahBulan = parseInt($("#jumlah_bulan").val());
        var tahunMulaiAngsuran = parseInt($("#tahun_mulai_angsuran").val());

        if (isNaN(bulanMulaiAngsuran) || isNaN(jumlahBulan) || isNaN(tahunMulaiAngsuran)) {
            // Salah satu atau lebih input belum diisi, hentikan eksekusi lebih lanjut
            return;
        }

        // Hitung bulan selesai dan tahun akhir
        var bulanSelesai = (bulanMulaiAngsuran + jumlahBulan - 1) % 12;
        var tahunAkhir = tahunMulaiAngsuran + Math.floor((bulanMulaiAngsuran + jumlahBulan - 1) / 12);

        // Penanganan khusus untuk bulan Desember
        if (bulanSelesai === 0) {
            bulanSelesai = 12;
            tahunAkhir -= 1;
        }

        // Set nilai pada elemen-elemen output
        $('#bulan_selesai_angsuran').val(bulanSelesai);
        $('#tahun_selesai_angsuran').val(tahunAkhir);
    });
});

    </script>
@endpush
