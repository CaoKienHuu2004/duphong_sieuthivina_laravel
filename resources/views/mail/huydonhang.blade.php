<x-mail::message>
# Thông báo hủy đơn hàng

Xin chào **{{ $order->nguoinhan }}**,

Rất tiếc phải thông báo rằng đơn hàng **#{{ $order->madon }}** của bạn tại Siêu Thị Vina đã bị hủy.

<x-mail::panel>
**Thời gian hủy:** {{ date('d/m/Y H:i') }}
</x-mail::panel>

Chúng tôi thành thật xin lỗi về sự bất tiện này. Nếu bạn đã thanh toán trước (Chuyển khoản/VNPAY), bộ phận kế toán sẽ liên hệ để hoàn tiền cho bạn trong vòng 24-48h làm việc.

## Chi tiết đơn hàng đã hủy

<x-mail::table>
| Sản phẩm | SL | Giá |
| :--- | :---: | ---: |
@foreach($order->chitietdonhang as $item)
| {{ $item->tensanpham }} <br> <small>({{ $item->tenbienthe }})</small> | {{ $item->soluong }} | {{ number_format($item->dongia, 0, ',', '.') }}đ |
@endforeach
</x-mail::table>

<div style="text-align: right; font-size: 16px;">
Tổng trị giá đơn hàng: <b>{{ number_format($order->thanhtien, 0, ',', '.') }}đ</b>
</div>

<x-mail::button :url="env('FRONTEND_URL', 'http://localhost:3000')">
Quay lại cửa hàng
</x-mail::button>

Nếu bạn có thắc mắc, vui lòng trả lời email này hoặc liên hệ hotline hỗ trợ.

Trân trọng,<br>
**Siêu Thị Vina**
</x-mail::message>