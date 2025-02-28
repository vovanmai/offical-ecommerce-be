@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Danh mục sản phẩm</small>
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
                        <h3 class="box-title"><i class="fa fa-fw fa-list-ul"></i>Danh mục sản phẩm</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.course_category.create') }}" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Tạo mới
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        @if ($categories->count())
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 5%">STT</th>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Danh mục cha</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhập</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                                @foreach($categories as $key => $category)
                                    <tr class="tr-{{$category->id}}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->title }}</td>
                                        <td>
                                            @foreach(array_reverse(getParentCategories($category->parentRecursive)) as $key => $value)
                                                <p style="margin-left: {{ $key * 20 }}px";>{{'--- ' . $value }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $category->created_at }}
                                        </td>
                                        <td>
                                            {{ $category->updated_at }}
                                        </td>
                                        <td>
                                            @if(hasPermission('PUT'))
                                                <a href="{{ route('admin.course_category.edit', ['id' => $category->id]) }}" class="btn btn-primary">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                            @endif
                                            @if(hasPermission('DELETE'))
                                                <button onclick="deleteCategory({{ $category->id }})" type="button" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div style="font-weight: bold" class="text-center">Không có dữ liệu</div>
                        @endif
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="text-right">
                            {!! $categories->links() !!}
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
                        url: `/admin/categories/${id}`,
                        success: function(response)
                        {
                            $.each(response.data, function(index, value) {
                                $(`.tr-${value}`).remove()
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
    </script>
@endpush
