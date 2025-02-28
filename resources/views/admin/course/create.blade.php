@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý khoá học</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="create-post-form" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('admin.course.store') }}">
                        @csrf
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tạo mới khóa học</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('admin.course.list') }}" type="button" class="btn btn-primary"><i class="fa fa-fw fa-list-alt"></i>
                                    Xem danh sách
                                </a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <div class="col-md-5">
                                    <div class="form-group @error('title') has-error @enderror" style="margin-bottom: 30px">
                                        <label>
                                            Tiêu đề<span class="required">(*)</span>
                                        </label>
                                        <div class="field-container">
                                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group @error('short_description') has-error @enderror" style="margin-bottom: 30px">
                                        <label>
                                            Mô tả ngắn
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="short_description" rows="5">{{ old('short_description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Ảnh <span class="required">(*)</span> (Kích thước 320x320 pixel) Nên tạo từ phần mền <a style="text-decoration: underline" href="https://www.canva.com">Canva</a>
                                        </label>
                                        <div class="field-container">
                                            <div id="dropzone-image-preview" class="dropzone">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-1">
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Danh mục<span class="required">(*)</span>
                                        </label>
                                        <div class="field-container">
                                            <div style="border: 1px solid #d2d6de; padding: 10px 20px; max-height: 417px; overflow-y: auto;">
                                                @foreach($categories as $cat)
                                                    @include('admin.component.child-category', [
                                                        'category' => $cat,
                                                    ])
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Active
                                        </label>
                                        <div class="field-container">
                                            <input style="width: 20px; height: 20px" type="checkbox" name="active">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group @error('description') has-error @enderror" style="margin-bottom: 30px">
                                        <label>
                                            Chi tiết<span class="required">(*)</span>
                                        </label>
                                        @include('admin.component.upload-file-ckeditor')
                                        <div class="field-container">
                                            <textarea name="description" id="description-editor"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="text-center">
                                <button type="reset" class="btn btn-default" style="margin-right: 10px">Xóa</button>
                                <span class="button-create">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i>Tạo</button>
                                    </span>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
@endsection

@push('script')
    <script>
        let imagePreview = null;
        $(function() {
            $("#create-post-form").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 255,
                    },
                    category_id: {
                        required: true,
                    },
                    short_description: {
                        maxlength: 255,
                    },
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                messages: {
                    title: {
                        required: "Tiêu đề không được rỗng.",
                    },
                    short_description: {
                        maxlength: "Không được quá 255 ký tự",
                    },
                    category_id: {
                        required: "Danh mục không được rỗng.",
                    },
                },
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest(".form-group").find('.field-container'));
                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function(form) {
                    // validate preview image is required
                    if (!imagePreview) {
                        toastr.error('Vui lòng chọn ảnh đại diện.', 'Lỗi');
                        return;
                    }

                    // Validate description is required
                    var description = editor.getData();
                    if (description == '<p>&nbsp;</p>') {
                        toastr.error('Vui lòng nhập chi tiết.', 'Lỗi');
                        return;
                    }

                    const data = {
                        category_id: $("input[name='category_id']:checked").val(),
                        title: $("input[name='title']").val(),
                        short_description: $("textarea[name='short_description']").val(),
                        description: description,
                        image: imagePreview,
                        active: $('input[name="active"]').is(":checked") ? 1 : 0
                    }
                    createItem(data)
                }
            });
        });

        function createItem (data) {
            $.ajax({
                data: data,
                type: 'POST',
                url: "{{ route('admin.course.store') }}",
                cache: false,
                success: function(response)
                {
                    window.location.href = '/admin/courses'
                },
                error: function(error) {
                    if (error.status === 422) {
                        toastr.error(error.responseJSON.errors[0], 'Lỗi')
                    } else {
                        toastr.error("Máy chủ bị lỗi.", 'Lỗi')
                    }
                }
            });
        }

        Dropzone.autoDiscover = false;

        $("#dropzone-image-preview").dropzone(            {
            maxFiles: 1,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpg,.jpeg,.jpg,.png,.gif,.webp,.svg",
            dictDefaultMessage: "Bạn có thể kéo ảnh hoặc click để chọn",
            dictRemoveFile: 'Xóa',
            addRemoveLinks: true,
            uploadMultiple: false,
            autoProcessQueue: true,
            timeout: 60000,
            url: '/admin/upload-file',
            params: {
                key: "post_preview_",
                resize_height: 320,
                resize_width: 320,
            },
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, response) {
                imagePreview = response.data
            },
            error: function (file, response) {
                return false;
            },
            accept: function(file, done) {
                done()
            },
            init : function() {
                var myDropZone = this;
                myDropZone.on('maxfilesexceeded', function(file) {
                    toastr.error("Ảnh đại diện tối đa là 1 ảnh.", 'Lỗi');
                    myDropZone.removeFile(file);
                });

            },
            removedfile: function (file) {
                file.previewElement.remove()
                removeImageOnServer(JSON.parse(file.xhr.response).data.store_name)
                imagePreview = null
            },
        });
    </script>
@endpush
