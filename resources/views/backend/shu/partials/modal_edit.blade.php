<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('shu.update',[$anggota->id]) }}" method="POST" id="form-edit-jabatan">
                {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <p style="font-weight: bold"><i class="fa fa-plus"></i>&nbsp;Form Edit SHU</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="shu_id" id="shu_id_edit">
                        <div class="form-group col-md-12">
                            <label for="">Pilih Tahun</label>
                            <input type="text" name="tahun" id="tahun_edit" class="form-control">
                            <div>
                                @if ($errors->has('tahun'))
                                    <small class="form-text text-danger">{{ $errors->first('tahun') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Jumlah SHU Simpanan <a style="color:red">Angka tanpa koma dan titik</a></label>
                            <input type="number" name="shu_simpanan" id="shu_simpanan_edit"  class="form-control" id="">
                            <div>
                                @if ($errors->has('shu_simpanan'))
                                    <small class="form-text text-danger">{{ $errors->first('shu_simpanan') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Jumlah SHU Jasa <a style="color:red">Angka tanpa koma dan titik</a></label>
                            <input type="number" name="shu_jasa" id="shu_jasa_edit" class="form-control" id="">
                            <div>
                                @if ($errors->has('shu_jasa'))
                                    <small class="form-text text-danger">{{ $errors->first('shu_jasa') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Jumlah SHU Ditetima <a style="color:red">Angka tanpa koma dan titik</a></label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah_edit">
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
        $(document).on('submit','#form-edit-jabatan',function (event){
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
            $("#shu_simpanan_edit, #shu_jasa_edit").keyup(function(){
                var shu_simpanan = $("#shu_simpanan_edit").val();
                var shu_jasa = $("#shu_jasa_edit").val();
                var shu_diterima = parseInt(shu_simpanan)+parseInt(shu_jasa);
                $('#jumlah_edit').val(shu_diterima);

            });
        });
    </script>
@endpush
