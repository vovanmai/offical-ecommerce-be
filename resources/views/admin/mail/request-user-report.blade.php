<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <style>
        table, th, td {
            border: 1px solid;
        }

        td, th {
            padding: 5px;
        }
    </style>
</head>
    <body>
        <h2>--- Truy cập khách hàng hôm nay--- </h2>
        @if(!empty($data['report']))
            <div>
                <table>
                    <tr>
                        <th>Trang</th>
                        <th>Số lượng truy cập</th>
                    </tr>
                    @foreach($data['report'] as $item)
                        <tr>
                            <td>{{ $item['path'] }}</td>
                            <td>{{ number_format($item['number']) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <p>Chưa có ngưới truy cập trong hôm nay.</p>
        @endif
        <br>
        <h2>--- Lịch sử khách truy cập --- </h2>
        <div>
            <table>
                <tr>
                    <th>Time</th>
                    <th>Path</th>
                    <th>Query</th>
                    <th>Ip</th>
                    <th>Agent</th>
                </tr>
                @foreach($data['requestLogs'] as $item)
                <tr>
                    <td>{{ $item->requested_at }}</td>
                    <td>{{ $item->path }}</td>
                    <td>{{ $item->query }}</td>
                    <td>{{ $item->ip }}</td>
                    <td>{{ $item->user_agent }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
