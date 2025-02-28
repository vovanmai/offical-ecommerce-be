@extends('admin.layouts.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Thiết lập menu chính</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <form id="create-main-menu-form" class="form-horizontal">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-fw fa-gears"></i> Thiết lập menu chính</h3>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="container">
                                <div style="display:flex;">
                                    <div style="width: 47%">
                                        <label for="">Danh mục hiện có</label>
                                        <div id="available-menu">
                                            @foreach($availableMenu as $item)
                                                <div target-id="{{ $item['id'] }}" target-type="{{ $item['type'] }}">{{ $item['title'] }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div style="width: 6%;">
                                        <div style="display: flex; height: 100%; flex-direction: column; justify-content: center; align-items: center">
                                            <div style="margin-bottom: 10px; margin-top: 21px">
                                                <button type="button"> >> </button>
                                            </div>
                                            <div>
                                                <button type="button"> << </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 47%;">
                                        <label for="">Danh mục đã chọn</label>
                                        <div id="selected-menu">
                                            @foreach(app('web_setting')->main_menu ?? [] as $item)
                                                <div target-id="{{ $item['id'] }}" target-type="{{ $item['type'] }}">{{ $item['title'] }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <div class="text-center">
                                <button type="reset" class="btn btn-default" style="margin-right: 10px">Reset</button>
                                <span class="button-create">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i>Lưu</button>
                                </span>
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
        var availableMenu = document.getElementById('available-menu');
        var selectedMenu = document.getElementById('selected-menu');

        new Sortable(availableMenu, {
            group: 'shared', // set both lists to same group
            animation: 150,
            sort: false,
        });

        new Sortable(selectedMenu, {
            group: 'shared',
            animation: 150,
        });

        $("#create-main-menu-form").submit(function(e) {
            e.preventDefault();
            let data = []

            $('#selected-menu > div').map((index, value) => {
                const item = $(value)
                data.push({
                    target_id: item.attr('target-id'),
                    target_type: item.attr('target-type'),
                })
            })

            $.ajax({
                data: {
                    data: data
                },
                type: 'POST',
                cache:false,
                url: `/admin/main-menu`,
                success: function(response)
                {
                    toastr.success(response.message, 'Thành công');
                },
                error: function(error) {
                    const responseError = error.responseJSON
                    if (error.status == 422) {
                        toastr.error(responseError.errors[0], 'Lỗi');
                    } else {
                        toastr.error(responseError.message, 'Lỗi');
                    }
                }
            });
        });
    </script>
@endpush
