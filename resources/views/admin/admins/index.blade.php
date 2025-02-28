@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý admin</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form class="form-horizontal" method="GET" action="{{ route('admin.admins.list') }}">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tìm kiếm admin</h3>
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
                                <div class="col-md-6">
                                    <div class="form-group @error('role') has-error @enderror">
                                        <label class="col-sm-2 control-label">Quyền</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="role">
                                                <option value="">Vui lòng chọn...</option>
                                                @foreach($roles as $key => $value)
                                                    <option @if($key == (request()->get('role') ?? '')) selected @endif value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
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
                        <h3 class="box-title"><i class="fa fa-fw fa-list-ul"></i>Danh sách admin</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ route('admin.admin.create') }}" type="button" class="btn btn-primary"><i class="fa fa-plus"></i>
                                Tạo mới
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 5%">ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Ảnh đại diện</th>
                                <th>Quyền</th>
                                <th>Active</th>
                                <th>Đăng nhập gần nhất</th>
                                <th>Ngày tạo</th>
                                <th>Ngày cập nhập</th>
                                <th style="width: 10%">Action</th>
                            </thead>
                            <tbody>
                            @if($admins->isNotEmpty())
                                @foreach($admins as $key => $admin)
                                    <tr class="tr-admin-{{ $admin->id }}">
                                        <td>{{ $admin->id }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>
                                            {{ $admin->email }}
                                        </td>
                                        <td style="text-align: center">
                                            @if($admin->avatar)
                                                <img style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%" src="{{ $admin->avatar['url'] ?? '' }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($admin->role == \App\Models\Admin::ROLE_SUPPER_ADMIN)
                                                <span class="badge bg-red">{{ $admin->role_name }}</span>
                                            @elseif ($admin->role == \App\Models\Admin::ROLE_ADMIN)
                                                <span class="badge bg-green">{{ $admin->role_name }}</span>
                                            @elseif ($admin->role == \App\Models\Admin::ROLE_EDITOR)
                                                <span class="badge bg-yellow">{{ $admin->role_name }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $admin->role_name }}</span>
                                            @endif
                                        </td>
                                        <td class="is-active text-center">
                                            @if($admin->active)
                                                <img onclick="changeActive({{ $admin->id }}, 0)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/active.jpg" alt="">
                                            @else
                                                <img onclick="changeActive({{ $admin->id }}, 1)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/inactive.png" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $admin->login_at ? getTimeAgo($admin->login_at) : null }}
                                        </td>
                                        <td>
                                            <div>
                                                {{ $admin->created_at->diffForHumans() }}
                                            </div>
                                            <div>
                                                {{ $admin->created_at }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ $admin->updated_at->diffForHumans() }}
                                            </div>
                                            <div>
                                                {{ $admin->updated_at }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.admin.edit', ['id' => $admin->id]) }}" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            {{--<button onclick="deleteAdmin({{ $admin->id }})" type="button" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="text-center">
                                        <span>Không có dữ liệu</span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="10">
                                    <div class="text-right">{!! $admins->links() !!}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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

        function resetForm () {
            $('.reset-form-admin').find('input[name="name"]').val("");
        }

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

        function changeActive (id, active)
        {
            NProgress.set(0.5)
            NProgress.start();
            $.ajax({
                data: {
                    active: active
                },
                type: 'POST',
                dataType: "JSON",
                url: `/admin/admins/${id}/active`,
                success: function(response)
                {
                    if (active) {
                        var image = `<img onclick="changeActive(${id}, 0)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/active.jpg" alt="">`
                    } else {
                        var image = `<img onclick="changeActive(${id}, 1)" style="height: 28px; width: 28px; cursor: pointer" src="/assets/admin/dist/img/inactive.png" alt="">`
                    }

                    $(`.tr-admin-${id} .is-active`).html(image)
                    NProgress.done();
                },
                error: function(error) {
                    if(error.status == 403) {
                        toastr.error(error.responseJSON.message, 'Lỗi');
                    } else {
                        toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
                    }
                    NProgress.done();
                }
            });
        }
    </script>
@endpush
