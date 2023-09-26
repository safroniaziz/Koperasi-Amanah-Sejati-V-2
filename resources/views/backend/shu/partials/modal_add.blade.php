<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('shu.store',[$anggota->id]) }}" method="POST" id="form-tambah-jabatan">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Tambah SHU</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="hidden" name="anggota_id" value="{{ $anggota->id }}">
                            <label for="">Pilih Tahun</label>
                            <select name="tahun" id="tahun" class="form-control"></select>
                            <div>
                                @if ($errors->has('tahun'))
                                    <small class="form-text text-danger">{{ $errors->first('tahun') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Jumlah SHU Pinjaman <a style="color:red">Angka tanpa koma dan titik</a></label>
                            <input type="number" name="shu_simpanan" class="form-control" id="shu_simpanan">
                            <div>
                                @if ($errors->has('shu_simpanan'))
                                    <small class="form-text text-danger">{{ $errors->first('shu_simpanan') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Jumlah SHU Jasa <a style="color:red">Angka tanpa koma dan titik</a></label>
                            <input type="number" name="shu_jasa" class="form-control" id="shu_jasa">
                            <div>
                                @if ($errors->has('shu_jasa'))
                                    <small class="form-text text-danger">{{ $errors->first('shu_jasa') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Jumlah SHU Diterima <a style="color:red">Angka tanpa koma dan titik</a></label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" readonly>
                            <div>
                                @if ($errors->has('jumlah'))
                                    <small class="form-text text-danger">{{ $errors->first('jumlah') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat " data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>&nbsp;Simpan Data</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('scripts')
    <script>
        $(document).on('submit','#form-tambah-jabatan',function (event){
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                typeData: "JSON",
                data: new FormData(this),
                processData:false,
                contentType:false,
                success : function(res) {
                    $("#btnSubmit"). attr("disabled", true);
                    toastr.success(res.text, 'Yeay, Berhasil');
                    setTimeout(function () {
                        window.location.href=res.url;
                    } , 100);
                },
                error:function(xhr){
                    toastr.error(xhr.responseJSON.text, 'Ooopps, Ada Kesalahan');
                }
            })
        });

        $(document).ready(function(){
            $("#shu_simpanan, #shu_jasa").keyup(function(){
                var shu_simpanan = $("#shu_simpanan").val();
                var shu_jasa = $("#shu_jasa").val();
                var shu_diterima = parseInt(shu_simpanan)+parseInt(shu_jasa);
                $('#jumlah').val(shu_diterima);

            });
        });

        $('#tahun').each(function() {
            var year = (new Date()).getFullYear();
            var current = year;
            year -= 10;
            for (var i = 0; i < 11; i++) {
            if ((year+i) == current)
                $(this).append('<option selected value="' + (year + i) + '">' + (year + i) + '</option>');
            else
                $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
            }
        });

    </script>
@endpush
