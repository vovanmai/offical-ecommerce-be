<div class="modal fade" id="create-course-image-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="create-course-image-form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Thêm ảnh</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Chọn hình ảnh<span class="required">(*)</span>
                        </label>
                        <div class="col-md-8">
                            <input type="file" name="files" multiple accept="image/*" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button id="infileid" type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success">Thêm</button>
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
        $('#create-course-image-modal').on('hidden.bs.modal', function (e) {
            const file = document.querySelector('input[name=files]');
            file.value = '';
        })

        $("#create-course-image-form").on('submit', function(e) {
            e.preventDefault();
            createCourseImages()
        });

        function uploadToServer (file) {
            return new Promise(function(resolve, reject) {
                const formData = new FormData()
                formData.append('file', file)
                formData.append('key', 'hinh-anh-khoa-hoc-')
                $.ajax({
                    data: formData,
                    type: 'POST',
                    url: '/admin/upload-file',
                    processData: false,
                    contentType: false,
                    cache:false,
                    success: function(response)
                    {
                        resolve(response.data);
                    },
                    error: function(error) {
                        toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
                    }
                });
            });


        }

        function createCourseImages () {
            const listFiles = $('input[name=files]')[0].files
            if (listFiles.length === 0) {
                toastr.error("Vui lòng chọn hình ảnh.", 'Lỗi');
                return ;
            }
            let promises = []
            for (const file of listFiles) {
                promises.push(uploadToServer(file))
            }

            Promise.all(promises).then(response => {
                $.ajax({
                    data: { images: response },
                    type: 'POST',
                    url: '/admin/course-images',
                    cache:false,
                    success: function(response)
                    {
                        window.location.href = '/admin/course-images'
                    },
                    error: function(error) {
                        toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
                    }
                });
            })
        }
    </script>
@endpush
