<h2>Xin chào,</h2>
<p>Có đơn hàng mới</p>
Thông tin đơn hàng:
<ul>
    <li>Mã đơn hàng: {{ $order->id }}</li>
    <li>Tên khách hàng: {{ $order->name }}</li>
    <li>Email: {{ $order->email }}</li>
    <li>Số điện thoại: {{ $order->phone }}</li>
    <li>Địa chỉ giao hàng: {{ $order->shipping_address }}</li>
    <li>Ghi chú: {{ $order->note }}</li>
    <li>Tổng tiền sản phẩm: {{ number_format($order->total, 0, ',', '.') }} đ</li>
    <li>Phí giao hàng: {{ number_format($order->shipping_fee, 0, ',', '.') }} đ</li>
    <li>
        Tổng tiền: {{ number_format($order->total + $order->shipping_fee, 0, ',', '.') }} đ
    </li>
</ul>
<p>Chi tiết đơn hàng:</p>
<ul>
    @foreach($order->orderDetails as $item)
        <li>
            Sản phẩm: {{ $item->product->name }} - Số lượng: {{ $item->quantity }} - Giá: {{ number_format($item->price, 0, ',', '.') }} đ
        </li>
    @endforeach
</ul>
<p>Vui lòng đăng nhập vào hệ thống để xem chi tiết và xử lý đơn hàng.</p>
<p><a href="{{ config('app.url_frontend') . '/admin/orders/' . $order->id }}">Xem đơn hàng</a></p>
<p>Xin cảm ơn!</p>
