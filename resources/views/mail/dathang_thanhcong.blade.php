<x-mail::message>
# Đặt hàng thành công!

Xin chào **{{ $order->nguoinhan }}**,

Cảm ơn bạn đã mua sắm tại Siêu Thị Vina. Đơn hàng của bạn đã được ghi nhận thành công.

<x-mail::panel>
**Mã đơn hàng:** {{ $order->madon }}<br>
**Ngày đặt:** {{ $order->created_at->format('d/m/Y H:i') }}<br>
**Hình thức thanh toán:** {{ $order->hinhthucthanhtoan }}<br>
**Địa chỉ giao:** {{ $order->diachinhan }}, {{ $order->khuvucgiao }}.
</x-mail::panel>

## Chi tiết đơn hàng

<x-mail::table>
| Sản phẩm | SL | Đơn giá | Thành tiền |
| :--- | :---: | :---: | ---: |
@foreach($order->chitietdonhang as $item)
| {{ $item->tensanpham }} <br> <small>({{ $item->tenbienthe }})</small> | {{ $item->soluong }} | {{ number_format($item->dongia, 0, ',', '.') }}đ | {{ number_format($item->dongia * $item->soluong, 0, ',', '.') }}đ |
@endforeach
</x-mail::table>

<div style="text-align: right; font-size: 16px;">
Phí vận chuyển: <b>{{ number_format($order->phigiaohang, 0, ',', '.') }}đ</b><br>
@if($order->giagiam > 0)
Voucher giảm giá: <b>-{{ number_format($order->giagiam, 0, ',', '.') }}đ</b><br>
@endif
TỔNG THANH TOÁN: <b style="color: #ed3237; font-size: 20px;">{{ number_format($order->thanhtien, 0, ',', '.') }}đ</b>
</div>

<x-mail::button :url="env('FRONTEND_URL', 'http://localhost:3000') . '/don-hang/' . $order->madon">
Xem chi tiết đơn hàng
</x-mail::button>

Cảm ơn bạn,<br>
**{{ config('app.name') }}**
</x-mail::message>