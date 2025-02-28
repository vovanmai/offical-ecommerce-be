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
            <div class="col-md-4">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.category.index') }}" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Tạo mới
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="dd" id="nestable-category">
                            <ol class="dd-list">
                                @foreach ($items as $item)
                                    @include('admin.category.tree_item', ['category' => $item])
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-info">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('admin.category.store') }}">
                        @csrf
                        <div class="box-header with-border">
                            <h3 class="box-title">Tạo mới danh mục</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('parent_id') has-error @enderror">
                                <label class="col-md-2 control-label">
                                    Danh mục cha<span class="required"></span>
                                </label>
                                <div class="col-md-9">
                                    <div style="border: 1px solid #d2d6de; padding: 10px 20px; height: 300px; overflow-y: auto;">
                                        @foreach($items as $item)
                                            @include('admin.component.child-category', ['item' => $item])
                                        @endforeach
                                    </div>
                                    @error('parent_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group @error('name') has-error @enderror">
                                <label class="col-md-2 control-label">
                                    Tên<span class="required">(*)</span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control">
                                    @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group @error('description') has-error @enderror">
                                <label class="col-md-2 control-label">
                                    Mô tả<span class="required"></span>
                                </label>
                                <div class="col-md-9">
                                    <textarea name="description" class="form-control" rows="3" placeholder=""></textarea>
                                    @error('description')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        <div class="box-footer text-center">
                            <div class="text-center">
                                <button type="reset" class="btn btn-default" style="margin-right: 10px">Xóa</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i>Tạo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
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

        $('#nestable-menu').on('click', function(e)
        {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('#nestable-category').nestable({
            maxDepth: 2
        });
    </script>
@endpush
