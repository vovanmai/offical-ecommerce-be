@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý khách hàng</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form class="form-horizontal" method="GET" action="{{ route('admin.user.list') }}">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tìm kiếm khách hàng</h3>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Tên</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ request()->get('name') ?? '' }}" class="form-control">
                                            @error('name')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group @error('phone') has-error @enderror">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Số điện thoại</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="phone" value="{{ request()->get('phone') ?? '' }}" class="form-control">
                                            @error('phone')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('email') has-error @enderror">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" value="{{ request()->get('email') ?? '' }}" name="email" class="form-control">
                                            @error('email')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <button type="reset" onclick="resetSearchForm('/admin/users')" class="btn btn-default reset-form-admin" style="margin-right: 2px">
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
                        <h3 class="box-title"><i class="fa fa-fw fa-list-ul"></i>Danh sách khách hàng</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.user.list') }}" type="button" class="btn btn-primary"><i class="fa fa fa-refresh"></i>
                                Làm mới
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        @if ($items->count())
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 5%">STT</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Đăng nhập gần nhất</th>
                                    <th>Ngày tạo</th>
                                </tr>
                                @foreach($items as $key => $item)
                                    <tr class="tr-{{$item->id}}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>
                                            {{ $item->login_at ? getTimeAgo($item->login_at) : 'Chưa đăng nhập' }}
                                        </td>
                                        <td>
                                            <div>
                                                {{ $item->created_at->diffForHumans() }}
                                            </div>
                                            <div>
                                                {{ $item->created_at }}
                                            </div>
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
                        {!! $items->links() !!}
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
        $(function() {
            $("form").validate({
                rules: {
                    name: {
                        maxlength: 50,
                    },
                    email: {
                        maxlength: 50,
                        email: true,
                    },
                    phone: {
                        maxlength: 11,
                    },
                },
                highlight: function(element) {
                    $(element).parents('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).parents('.form-group').removeClass('has-error');
                },
                messages: {
                    name: {
                        maxlength: "Tên không được lớn hơn 50 ký tự.",
                    },
                    email: {
                        email: "Email không hợp lệ.",
                        maxlength: "Email không được lớn hơn 50 ký tự.",
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

        function deleteAdmin (id) {
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
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: 'delete',
                        dataType: "JSON",
                        url: `/admin/admins/${id}`,
                        success: function(response)
                        {
                            toastr.success(response.message, 'Thành công');
                            $(`.tr-admin-${id}`).remove()
                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message, 'Lỗi');
                        }
                    });
                }
            })
        }
    </script>
@endpush
