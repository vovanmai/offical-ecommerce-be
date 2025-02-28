<div class="row">
    <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3> {{ number_format($orderStatistic->count_pending) }}</h3>
                <p>Đơn hàng đang chờ xử lý</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('admin.order.list', ['status' => [\App\Models\Order::STATUS_PENDING]]) }}" class="small-box-footer">Xem danh sách <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3> {{ number_format($orderStatistic->count_verified) }}</h3>
                <p>Đơn hàng đã xác nhận</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('admin.order.list', ['status' => [\App\Models\Order::STATUS_VERIFIED]]) }}" class="small-box-footer">Xem danh sách <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6">
        <div class="small-box" style="background: #00acd6">
            <div class="inner">
                <h3 style="color: white">{{ number_format($orderStatistic->count_shipping) }}</h3>
                <p style="color: white">Đơn hàng đang giao</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('admin.order.list', ['status' => [\App\Models\Order::STATUS_SHIPPING]]) }}" class="small-box-footer">Xem danh sách <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3> {{ number_format($orderStatistic->count_delivered) }}</h3>
                <p>Đơn hàng đã giao thành công</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('admin.order.list', ['status' => [\App\Models\Order::STATUS_DELIVERED]]) }}" class="small-box-footer">Xem danh sách <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ number_format($orderStatistic->count_cancel) }}</h3>
                <p>Đơn hàng đã hủy</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('admin.order.list', ['status' => [\App\Models\Order::STATUS_CANCELED]]) }}" class="small-box-footer">Xem danh sách <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Thống kê đơn hàng</h3>
                <div class="box-tools pull-right">
                    @php
                        $type = request('type', array_key_first(\App\Services\Admin\Dashboard\OrderStatistic::$types));
                        $type = in_array($type, array_keys(\App\Services\Admin\Dashboard\OrderStatistic::$types)) ? $type : array_key_first(\App\Services\Admin\Dashboard\OrderStatistic::$types);
                    @endphp
                    <div class="btn-group">
                        <a id="type-label" class="btn btn-primary btn-flat">
                            {{ \App\Services\Admin\Dashboard\OrderStatistic::$types[$type] }}
                        </a>

                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            @foreach(\App\Services\Admin\Dashboard\OrderStatistic::$types as $key => $type)
                                <li onclick="changeData('{{ $key }}')"><a>{{ $type }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <canvas id="order-chart" width="800" height="200"></canvas>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const orderChart = document.getElementById('order-chart');
        const orderData = {
            datasets: [
                {
                    label: 'Đơn hàng thành công',
                    data: {!! json_encode($data) !!},
                    fill: false,
                    borderColor: '#00a65a',
                    tension: 0.1
                },
            ]
        };

        const chartObject = new Chart(orderChart, {
            type: 'line',
            data: orderData,
        });
        const orderTypes = {!! json_encode(\App\Services\Admin\Dashboard\OrderStatistic::$types) !!}

        function changeData(type)
        {
            $.ajax({
                data: {
                    type: type
                },
                type: 'GET',
                url: `/admin/dashboard`,
                success: function(response)
                {
                    chartObject.data.datasets[0].data = response.data;
                    chartObject.data.datasets[0].data = response.data;
                    chartObject.update();
                    $('#type-label').html(orderTypes[type])
                    updateQueryString({ type })
                },
                error: function(error) {
                    toastr.error('Lỗi', 'Lỗi');
                }
            });
        }
    </script>
@endpush
