<div class="row">
    <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3> {{ number_format($totalUser) }}</h3>
                <p>Tổng số khách hàng</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('admin.user.list') }}" class="small-box-footer">Xem danh sách <i class="fa fa-arrow-circle-right"></i></a>
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
                        $type = request('type_order', array_key_first(\App\Services\Admin\Dashboard\UserStatistic::$types));
                        $type = in_array($type, array_keys(\App\Services\Admin\Dashboard\UserStatistic::$types)) ? $type : array_key_first(\App\Services\Admin\Dashboard\UserStatistic::$types);
                    @endphp
                    <div class="btn-group">
                        <a id="type-order-label" class="btn btn-primary btn-flat">
                            {{ \App\Services\Admin\Dashboard\OrderStatistic::$types[$type] }}
                        </a>

                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            @foreach(\App\Services\Admin\Dashboard\UserStatistic::$types as $key => $type)
                                <li onclick="changeUserData('{{ $key }}')"><a>{{ $type }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="box-body chart-responsive">
                <canvas id="user-chart" width="800" height="200"></canvas>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const userChart = document.getElementById('user-chart');
        const userData = {
            datasets: [
                {
                    label: 'Khách hàng đăng ký',
                    data: {!! json_encode($userData) !!},
                    fill: false,
                    borderColor: '#00a65a',
                    tension: 0.1
                },
            ]
        };

        const userChartObject = new Chart(userChart, {
            type: 'line',
            data: userData,
        });
        const types = {!! json_encode(\App\Services\Admin\Dashboard\UserStatistic::$types) !!}

        function changeUserData(type)
        {
            $.ajax({
                data: {
                    type: type
                },
                type: 'GET',
                url: `/admin/dashboard`,
                success: function(response)
                {
                    userChartObject.data.datasets[0].data = response.data;
                    userChartObject.update();
                    $('#type-label').html(types[type])
                    updateQueryString({ type_order: type })
                },
                error: function(error) {
                    toastr.error('Lỗi', 'Lỗi');
                }
            });
        }
    </script>
@endpush
