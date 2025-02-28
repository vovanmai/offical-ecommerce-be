@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý Banner</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="search-recruitment-form" class="form-horizontal" method="GET" action="{{ route('admin.main_banner.list') }}">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tìm kiếm</h3>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Tiêu đề</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="title" value="{{ old('title') ?? request()->get('title') ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Ngày tạo</label>
                                        <div class="col-sm-10">
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" value="{{ old('created_at_from') ?? request()->get('created_at_from') ?? '' }}" class="form-control" name="created_at_from" />
                                                <span class="input-group-addon">~</span>
                                                <input type="text" value="{{ old('created_at_to') ?? request()->get('created_at_to') ?? '' }}" class="form-control" name="created_at_to" />
                                            </div>
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
                            <a href="{{ route('admin.main_banner.create') }}" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Tạo mới
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        @if ($items->count())
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th style="width: 20%">Đường dẫn</th>
                                    <th>Ảnh</th>
                                    <th>Mô tả ngắn</th>
                                    <th>Active</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày cập nhập</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                @foreach($items as $key => $item)
                                    <tr class="tr-item-{{$item->id}}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            <a href="{{ $item->link }}">{{ $item->link }}</a>
                                        </td>
                                        <td style="text-align: center">
                                            @if($item->image)
                                                <img style="height: 50px;width: 50px;object-fit: cover" src="{{ getPublicFile($item->image['store_name']) }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->short_description }}
                                        </td>
                                        <td class="is-active text-center">
                                            @if($item->active)
                                                <img onclick="changeActive({{ $item->id }}, 0)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/active.jpg" alt="">
                                            @else
                                                <img onclick="changeActive({{ $item->id }}, 1)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/inactive.png" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.main_banner.edit', ['id' => $item->id]) }}" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            <button onclick="deleteItem({{ $item->id }})" type="button" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div style="font-weight: bold" class="text-center">Không có dữ liệu</div>
                        @endif
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
        $('.input-daterange').datepicker({
            daysOfWeekHighlighted: "0",
            clearBtn: true,
            todayBtn: "linked",
            language: "vi",
            format: "yyyy-mm-dd",
            timePicker: true,
            //autoclose: true,
        });

        $(function() {
            $("#search-recruitment-form").validate({
                rules: {
                    title: {
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

                },
                invalidHandler: function(form, validator) {
                    toastr.error('Dữ liệu nhập không hợp lệ.', 'Lỗi');
                },
                submitHandler: function(form) {
                    // Search recruitment
                    form.submit();
                }
            });
        });
        function deleteItem (id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa không ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                confirmButtonColor: 'green',
                cancelButtonText: 'Không',
                width: 400,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'delete',
                        dataType: "JSON",
                        url: `/admin/main-banners/${id}`,
                        success: function(response)
                        {
                            toastr.success(response.message, 'Thành công');
                            $(`.tr-item-${id}`).remove()
                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message, 'Lỗi');
                        }
                    });
                }
            })
        }

        function changeActive (id, active) {
            $.ajax({
                data: {
                    active: active
                },
                type: 'POST',
                dataType: "JSON",
                url: `/admin/main-banners/${id}/active`,
                success: function(response)
                {
                    if (active) {
                        var image = `<img onclick="changeActive(${id}, 0)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/active.jpg" alt="">`
                    } else {
                        var image = `<img onclick="changeActive(${id}, 1)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/inactive.png" alt="">`
                    }

                    $(`.tr-item-${id} .is-active`).html(image)
                },
                error: function(error) {
                    toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
                }
            });
        }
    </script>
@endpush
