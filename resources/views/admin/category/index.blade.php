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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @include('admin.category.list')
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Tạo mới danh mục</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('admin.category.store') }}">
                            @csrf
                            <div class="card-body">
                              <div class="form-group @error('name') has-error @enderror">
                                <label for="name">Tên(*)</label>
                                <input name=name value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="">
                                @error('name')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                              <div class="form-group">
                                <label>Danh mục</label>
                                <select name="category_id" class="form-control select2" style="width: 100%;">
                                    <option value="">---Chọn---</option>
                                    {!! buildSelectOptions($items, old('category_id')) !!}
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Chi tiết</label>
                                <textarea class="form-control" rows="3" placeholder=""></textarea>
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
    </script>
@endpush
