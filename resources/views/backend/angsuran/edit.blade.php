<form action="{{ route('angsuran.update',[$anggota->id, $pinjaman->id]) }}" method="POST" class="form" id="form-edit" style="display: none">
    {{ csrf_field() }} {{ method_field('PATCH') }}
    <div class="box-body ">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="">Tanggal Transaksi</label>
                <input type="hidden" name="angsuran_id" id="angsuran_id">
                <input type="date" name="tanggal_transaksi" id="tanggal_transaksi_edit" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="">Bulan Transaksi</label>
                <select name="bulan_transaksi" id="bulan_transaksi_edit" class="form-control" id="">
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
                <input type="text" name="tahun_transaksi" id="tahun_transaksi_edit" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Jumlah Angsuran Pokok / Bulan</label>
                <input type="text" name="angsuran_pokok" id="angsuran_pokok_edit" value="{{ $pinjaman->angsuran_pokok }}" id="angsuran_pokok" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Jumlah Angsuran Jasa / Bulan</label>
                <input type="text" name="angsuran_jasa" id="angsuran_jasa_edit" value="{{ $pinjaman->angsuran_jasa }}" id="angsuran_bunga" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center" style="    border-bottom: 1px solid #f4f4f4;padding-bottom:5px !important;">
        <a onclick="batalkanEdit()" id="batalkanEdit" class="btn btn-danger btn-sm btn-flat"><i
                class="fa fa-refresh"></i>&nbsp; Batalkan</a>
        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i
                class="fa fa-check-circle"></i>&nbsp; Simpan</button>
    </div>
</form>