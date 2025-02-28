    @extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Trang</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="create-page-form" class="form-horizontal">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tạo mới</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('admin.post.list') }}" type="button" class="btn btn-primary"><i class="fa fa-fw fa-list-alt"></i>
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
                                            @error('title')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
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
                                <div class="col-md-6 col-md-offset-1">
                                    <div class="form-group @error('short_description') has-error @enderror" style="margin-bottom: 30px">
                                        <label>
                                            Mô tả ngắn
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="short_description" rows="5">{{ old('short_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="margin-bottom: 30px">
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
        $(function() {
            $("#create-page-form").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 255,
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
                        required: "Không được rỗng.",
                    },
                    short_description: {
                        maxlength: "Không được vượt quá 255 ký tự.",
                    }
                },
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest(".form-group").find('.field-container'));
                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function(form) {
                    // Validate description is required
                    var description = editor.getData();
                    if (description == '<p>&nbsp;</p>') {
                        toastr.error('Vui lòng nhập chi tiết.', 'Lỗi');
                        return;
                    }

                    const data = {
                        title: $("input[name='title']").val(),
                        short_description: $("textarea[name='short_description']").val(),
                        description: description,
                        active: $('input[name="active"]').is(":checked") ? 1 : 0
                    }

                    $.ajax({
                        data: data,
                        type: 'POST',
                        url: "{{ route('admin.page.store') }}",
                        cache: false,
                        success: function(response)
                        {
                            window.location.href = '/admin/pages'
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
            });
        });
    </script>
@endpush
