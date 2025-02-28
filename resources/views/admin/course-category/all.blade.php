@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Danh mục khóa học</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form class="form-horizontal" method="GET" action="{{ route('admin.course_category.list') }}">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tìm kiếm danh mục</h3>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('title') has-error @enderror">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Tiêu đề</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="title" value="{{ old('title') ?? request()->get('title') ?? '' }}" class="form-control">
                                            @error('title')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <button type="reset" onclick="resetForm()" class="btn btn-default reset-form-admin" style="margin-right: 2px">
                                <i class="fa fa fa-eraser"></i> Xóa</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-fw fa-search"></i>Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-list-ul"></i>Danh sách</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.course_category.list') }}" type="button" class="btn btn-success">
                                <i class="fa fa-refresh"></i>
                                Làm mới
                            </a>
                            <a href="{{ route('admin.course_category.create') }}" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Tạo mới
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div style="padding: 0px 50px">
                            @foreach($categories as $item)
                            <div style="display: flex; justify-content: space-between" class="parent-cat cat-{{ $item->id }}">
                                <div>
                                    <span>{{ $item->title }}</span> |
                                    <span>{{ $item->courses_count  }}</span>
                                </div>
                                <div>
                                    <span class="active">
                                        @if($item->active)
                                            <a style="color: green" href="javascript:void(0)" onclick="changeActive({{ $item->id }}, 0)">
                                                <i class="fa fa-check"> Active</i>
                                            </a>
                                        @else
                                            <a style="color: gray" href="javascript:void(0)" onclick="changeActive({{ $item->id }}, 1)">
                                                <i class="fa fa-ban"> Inactive</i>
                                            </a>
                                        @endif
                                    </span>
                                    ||
                                    <a style="color: #367fa9" href="{{ route('admin.course_category.edit', ['id' => $item->id]) }}">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>
                                    ||
                                    <a style="color: red" href="javascript:void(0)" onclick="deleteCategory({{ $item->id }})">
                                        <i class="fa fa-trash"></i> Xóa
                                    </a>
                                </div>
                            </div>
                                @foreach($item->childrenRecursive as $item)
                                    <div style="margin-left: 50px" class="children-cat cat-{{ $item->id }}">
                                        <span class="">{{ $item->title }}</span>
                                        <div class="pull-right">
                                        <span class="active">
                                            @if($item->active)
                                                <a style="color: green" href="javascript:void(0)" onclick="changeActive({{ $item->id }}, 0)">
                                                    <i class="fa fa-check"> Active</i>
                                                </a>
                                            @else
                                                <a style="color: gray" href="javascript:void(0)" onclick="changeActive({{ $item->id }}, 1)">
                                                    <i class="fa fa-ban"> Inactive</i>
                                                </a>
                                            @endif
                                        </span>
                                            ||
                                            <a style="color: #367fa9" href="{{ route('admin.course_category.edit', ['id' => $item->id]) }}">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            ||
                                            <a style="color: red" href="javascript:void(0)" onclick="deleteCategory({{ $item->id }})">
                                                <i class="fa fa-trash"></i> Xóa
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="text-right">
                        </div>
                    </div>
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
        function resetForm () {
            $('.form-horizontal').find("input[type=text]").val("");
        }

        function deleteCategory (id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không ?',
                icon: 'warning',
                text: "Lưu ý xóa danh mục cha sẽ xóa luôn danh mục con.",
                showCancelButton: true,
                confirmButtonText: 'Có',
                confirmButtonColor: 'green',
                cancelButtonText: 'Không',
                width: 400,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: 'delete',
                        dataType: "JSON",
                        url: `/admin/course-categories/${id}`,
                        success: function(response)
                        {
                            $.each(response.data, function(index, value) {
                                $(`.cat-${value}`).remove()
                            });

                            toastr.success(response.message, 'Thành công');
                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message, 'Lỗi');
                        }
                    });
                }
            })
        }

        $(function() {
            $("form").validate({
                rules: {
                    title: {
                        maxlength: 50,
                    }
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function(form) {
                    form.submit()
                }
            });
        });

        function changeActive (id, active) {
            $.ajax({
                data: {
                    active: active
                },
                type: 'POST',
                dataType: "JSON",
                url: `/admin/course-categories/${id}/active`,
                success: function(response)
                {
                    if (active) {
                        var html = `<a style="color: green" href="javascript:void(0)" onclick="changeActive(${id}, 0)">
                            <i class="fa fa-check"> Active</i>
                        </a>`
                    } else {
                        var html = `<a style="color: gray" href="javascript:void(0)" onclick="changeActive(${id}, 1)">
                            <i class="fa fa-ban"> Inactive</i>
                        </a>`
                    }

                    $(`.cat-${id} .active`).html(html)
                },
                error: function(error) {
                    toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
                }
            });
        }
    </script>
@endpush
