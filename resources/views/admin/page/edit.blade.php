@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý bài viết</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="edit-page-form" class="form-horizontal">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-edit"></i>Cập nhật bài viết</h3>
                            <div class="box-tools pull-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Lưu</button>
                                <button type="button" onclick="updateItem(0)" class="btn btn-default"><i class="fa fa-edit"></i> Lưu và tiếp tục chỉnh sửa</button>
                                <a target="_blank" href="{{ route('user.page.detail', ['slug' => $item->slug]) }}" class="btn btn-info"><i class="fa fa-eye"></i> Xem bài viết</a>
                                <a href="{{ route('admin.page.list') }}" type="button" class="btn btn-success"><i class="fa fa-fw fa-list-alt"></i>
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
                                            <input type="text" name="title" class="form-control" value="{{ $item->title }}">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px">
                                        <label>
                                            Active
                                        </label>
                                        <div class="field-container">
                                            <input style="width: 20px; height: 20px" type="checkbox" {{ $item->active ? 'checked' : '' }} name="active">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-offset-1 col-md-6">
                                    <div class="form-group @error('short_description') has-error @enderror" style="margin-bottom: 30px">
                                        <label>
                                            Mô tả ngắn
                                        </label>
                                        <div class="field-container">
                                            <textarea class="form-control" name="short_description" rows="5">{{ old('short_description') ?? $item->short_description }}</textarea>
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
                                            <div class="field-container">
                                                <textarea name="description" id="description-editor">{!! $item->description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Lưu</button>
                                <button type="button" onclick="updateItem(0)" class="btn btn-default"><i class="fa fa-edit"></i> Lưu và tiếp tục chỉnh sửa</button>
                                <a target="_blank" href="{{ route('user.page.detail', ['slug' => $item->slug]) }}" class="btn btn-info"><i class="fa fa-eye"></i> Xem bài viết</a>
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
            $("form").validate({
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
                    messages: {
                        title: {
                            required: "Không được rỗng.",
                        },
                        short_description: {
                            maxlength: "Không được vượt quá 255 ký tự.",
                        }
                    },
                },
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest(".form-group").find('.field-container'));
                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function() {
                    updateItem()
                }
            });
        });

        function updateItem (goToList = 1)
        {
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
                url: "{{ route('admin.page.update', ['id' => request()->id]) }}",
                cache: false,
                success: function(response)
                {
                    if (goToList) {
                        window.location.href = '/admin/pages'
                    } else {
                        window.location.href = "/admin/pages/{{$item->id}}/edit"
                    }
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
    </script>
@endpush
