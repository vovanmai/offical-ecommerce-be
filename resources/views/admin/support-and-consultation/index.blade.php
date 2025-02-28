@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Quản lý liên hệ</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form class="form-horizontal" method="GET" action="{{ route('admin.consultation.list') }}">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-search"></i>Tìm kiếm</h3>
                        </div>
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label for="name" class="col-sm-2 control-label">Tên</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ request()->get('name') ?? '' }}" class="form-control">
                                            @error('name')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group @error('is_read') has-error @enderror">
                                        <label for="is_read" class="col-sm-2 control-label">Chưa đọc</label>
                                        <div class="col-sm-10">
                                            <input style="height: 21px; width: 21px" {{ request()->get('is_read') ? 'checked' : '' }} type="checkbox" id="vehicle3" name="is_read" value="true">
                                            @error('is_read')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group @error('phone') has-error @enderror">
                                        <label class="col-sm-2 control-label">Số điện thoại</label>
                                        <div class="col-sm-10">
                                            <input type="text" value="{{ request()->get('phone') ?? '' }}" name="phone" class="form-control">
                                            @error('phone')
                                            <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Ngày tạo</label>
                                        <div class="col-sm-10">
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" value="{{ request()->get('created_at_from') ?? '' }}" class="form-control" name="created_at_from" />
                                                <span class="input-group-addon">~</span>
                                                <input type="text" value="{{ request()->get('created_at_to') ?? '' }}" class="form-control" name="created_at_to" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <button type="reset" onclick="resetSearchForm('/admin/support-and-consultation')" class="btn btn-default reset-form-admin" style="margin-right: 2px">
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
                            <a href="{{ route('admin.consultation.list') }}" type="button" class="btn btn-primary"><i class="fa fa fa-refresh"></i>
                                Làm mới
                            </a>
                            <button onclick="readAll()" type="button" class="btn btn-success"><i class="fa fa-check"></i>
                                Đánh dấu đã đọc tất cả
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        @if ($items->count())
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                </tr>
                                @foreach($items as $key => $item)
                                    <tr class="tr-{{$item->id}}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->content }}</td>
                                        <td class="mark-read">
                                            @if($item->is_read)
                                                <span style="padding: 5px; background: #00acd6; color: white">Đã đọc</span>
                                            @else
                                                <span style="padding: 5px; background: #FF851B; color: white">Chưa đọc</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $item->created_at->diffForHumans() }}</div>
                                            <div>{{ $item->created_at }}</div>
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
        $('.input-daterange').datepicker({
            daysOfWeekHighlighted: "0",
            clearBtn: true,
            todayBtn: "linked",
            language: "vi",
            format: "yyyy-mm-dd",
            timePicker: true,
            //autoclose: true,
        });

        function readAll () {
            $.ajax({
                type: 'POST',
                dataType: "JSON",
                url: '{{ route('admin.consultation.mark_read') }}',
                success: function(response)
                {
                    toastr.success("Đánh dấu thành công", 'Thành công');
                    $('.count-unread-contact').html('')
                    $('.mark-read').html('<span style="padding: 5px; background: #00acd6; color: white">Đã đọc</span>')
                },
                error: function(error) {
                    toastr.error("Có lỗi trong khi truy cập đến máy chủ.", 'Lỗi');
                }
            });
        }
    </script>
@endpush
