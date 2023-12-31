<form action="{{ route('angsuran.store',[$anggota->id, $pinjaman->id]) }}" method="POST" class="form" id="form-create" style="display: none">
    {{ csrf_field() }} {{ method_field('POST') }}
    <div class="box-body ">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="">Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control">
            </div>
            {{-- <div class="form-group col-md-6">
                <label for="">Bulan Transaksi</label>
                <select name="bulan_transaksi" class="form-control" id="">
                    <option disabled selected>-- pilih bulan transaksi --</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="">Tahun Transaksi</label>
                <input type="text" name="tahun_transaksi" class="form-control">
            </div> --}}

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Jumlah Angsuran Pokok / Bulan</label>
                <input type="text" name="angsuran_pokok" value="{{ $pinjaman->angsuran_pokok }}" id="angsuran_pokok" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Jumlah Angsuran Jasa / Bulan</label>
                @php
                    $faktorPembulatan = 100;
                    if ($pinjaman->jumlah_bulan == 24) {
                        $jasa = $pinjaman->angsuran_pokok * 16/100;
                        $angkaBulat = ceil($jasa / $faktorPembulatan) * $faktorPembulatan;
                    } else {
                        $jasa = $pinjaman->angsuran_pokok * 8/100;
                        $angkaBulat = ceil($jasa / $faktorPembulatan) * $faktorPembulatan;
                    }
                @endphp

                <input type="text" name="angsuran_jasa" 
                    value="{{ number_format($angkaBulat, 0, '', '') }}"
                    id="angsuran_bunga" class="form-control">

            </div>

            <div class="form-group col-md-6">
                <label for="">Pembayaran Untuk Berapa Bulan ? </label>
                <select name="jumlah_bulan" class="form-control" id="">
                    <option disabled selected>-- pilih jumlah bulan --</option>
                    <option value="1">1 Bulan</option>
                    <option value="2">2 Bulan</option>
                    <option value="3">3 Bulan</option>
                    <option value="4">4 Bulan</option>
                    <option value="5">5 Bulan</option>
                    <option value="6">6 Bulan</option>
                    <option value="7">7 Bulan</option>
                    <option value="8">8 Bulan</option>
                    <option value="9">9 Bulan</option>
                    <option value="10">10 Bulan</option>
                    <option value="11">11 Bulan</option>
                    <option value="13">13 Bulan</option>
                    <option value="14">14 Bulan</option>
                    <option value="15">15 Bulan</option>
                    <option value="16">16 Bulan</option>
                    <option value="17">17 Bulan</option>
                    <option value="18">18 Bulan</option>
                    <option value="19">19 Bulan</option>
                    <option value="20">20 Bulan</option>
                    <option value="21">21 Bulan</option>
                    <option value="22">22 Bulan</option>
                    <option value="23">23 Bulan</option>
                    <option value="24">24 Bulan</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center" style="    border-bottom: 1px solid #f4f4f4;padding-bottom:5px !important;">
        <a onclick="batalkan()" id="batalkan" class="btn btn-danger btn-sm btn-flat"><i
                class="fa fa-refresh"></i>&nbsp; Batalkan</a>
        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i
                class="fa fa-check-circle"></i>&nbsp; Simpan</button>
    </div>
</form>