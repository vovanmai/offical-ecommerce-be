@extends('admin.layouts.adminlte3_master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh mục sản phẩm</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.category.index') }}" type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tạo mới</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('admin.category.list', ['activeId' => $item->id])
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Cập nhật danh mục</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('admin.category.update', ['id' => $item->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                              <div class="form-group @error('name') has-error @enderror">
                                <label for="name">Tên(*)</label>
                                <input name=name value="{{ old('name') ?? $item->name ?? null }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="">
                                @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                              <div class="form-group">
                                <label>Danh mục</label>
                                @php
                                    $category = findCategoryById($items, $item->id);
                                    $ignoreIds = getAllIds($category);
                                @endphp
                                <select name="category_id" class="form-control select2" style="width: 100%;">
                                    <option value="">---Chọn---</option>
                                    {!! buildSelectOptions($items, (old('category_id') ?? $item->parent_id), $ignoreIds) !!}
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Chi tiết</label>
                                <textarea class="form-control" rows="3" placeholder="">{{ old('name') ?? $item->description ?? null}}</textarea>
                              </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer text-center">
                              <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Lưu</button>
                              <button type="reset" class="btn btn-default"><i class="fas fa-eraser"></i> Xoá</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>

            <!-- /.card -->


        </div>
        <!-- /.container-fluid -->
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

        let draggedItemId = null;

        // Lấy ID ngay khi bắt đầu kéo
        $(document).on('mousedown', '.dd-handle', function () {
            draggedItemId = $(this).closest('.dd-item').data('id');
            console.log("Đang kéo category có ID:", draggedItemId);
        });

        $('#nestable-category').nestable({
            maxDepth: 2
        }).on('change', function (e) {
            $('.dd-item').each(function () {
                let itemId = $(this).data('id');
                let parent = $(this).parent('.dd-list').parent('.dd-item');

                if (parent.length) {
                    let parentId = parent.data('id');
                    draggedItemId = itemId; // Cập nhật ID của item vừa được kéo
                    console.log(`Category ${itemId} đã được kéo vào Category ${parentId}`);
                }
            });
        });
    </script>
@endpush
