<div class="modal fade" id="detail-course-image-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="detail-course-image-form">
                <input type="hidden" name="id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Chi tiết ảnh</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="padding: 0px 15px">
                        <img style="width: 100%" src="" alt="">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button id="infileid" type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@push('script')
    <script>
        $("#detail-course-image-form").on('submit', function(e) {
            e.preventDefault();
            const id = $("#detail-course-image-form input[type=hidden]").val()
            $.ajax({
                type: 'DELETE',
                url: '/admin/course-images/' + id,
                cache:false,
                success: function(response)
                {
                    $(`.course-images .image-${id}`).remove()
                    $("#detail-course-image-modal").modal('hide');
                    toastr.success('Xóa thành công', 'Thành công');
                },
                error: function(error) {

                }
            });
        });
    </script>
@endpush
