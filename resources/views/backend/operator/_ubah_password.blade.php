<div class="modal fade" id="ubahpassword">
    <form method="POST" action="{{ route('operator.update_password') }}" id="form-ubah-password">
        {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-check-circle"></i>&nbsp;Ubah Password Operator</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Password Baru</label>
                    <input type="hidden" name="id" id="id_password">
                    <input type="password" class="form-control password" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="examplenputPassword1">Ulangi Password </label>
                    <input type="password" class="form-control password_confirmation" name="password_confirmation" id="password_confirmation">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                <button type="submit" id="btn_submit" class="btn btn-primary btn-sm btn-flat btn_save"><i class="fa fa-check-circle"></i>&nbsp;Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        $(document).on('submit','#form-ubah-password',function (event){
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
    </script>
@endpush