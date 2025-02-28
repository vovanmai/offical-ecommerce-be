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
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('admin.course_category.create') }}">
                        @csrf
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tạo mới danh mục</h3>
                            <div class="box-tools pull-right">
                                <a href="{{ route('admin.course_category.list') }}" type="button" class="btn btn-primary"><i class="fa fa-fw fa-list-alt"></i>
                                    Xem danh sách
                                </a>
                            </div>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group @error('parent_id') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Danh mục cha<span class="required"></span>
                                </label>
                                <div class="col-md-6">
                                    <div style="border: 1px solid #d2d6de; padding: 10px 20px; height: 500px; overflow-y: auto;">
                                        @foreach($categories as $cat)
                                            @include('admin.component.child-category', ['category' => $cat])
                                        @endforeach
                                    </div>
                                    @error('parent_id')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group @error('title') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Tiêu đề<span class="required">(*)</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" name="title" class="form-control">
                                    @error('title')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group @error('description') has-error @enderror">
                                <label class="col-md-3 control-label">
                                    Mô tả<span class="required"></span>
                                </label>
                                <div class="col-md-6">
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
                        maxlength: 50,
                    },
                    description: {
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
                        maxlength: "Tiêu đề không được lớn hơn 50 ký tự.",
                    },
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
