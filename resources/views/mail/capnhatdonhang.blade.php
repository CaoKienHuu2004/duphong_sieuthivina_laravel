<x-mail::message>
# Xin chào {{ $donhang->nguoinhan }},

{{ $tieude }}

**Trạng thái đơn hàng:** {{ $donhang->trangthai }}

{{ $noidung }}

### Thông tin đơn hàng #{{ $donhang->madon }}

<x-mail::table>
| Sản phẩm | SL | Thành tiền |
| :--- | :---: | :---: |
@foreach($donhang->chitietdonhang as $item)
| {{ $item->tensanpham }} <br> <small>({{ $item->tenbienthe }})</small> | {{ $item->soluong }} | {{ number_format($item->dongia, 0, ',', '.') }}đ |
@endforeach
</x-mail::table>

<x-mail::button :url="$urlchitiet" color="primary">
Xem chi tiết đơn hàng
</x-mail::button>

Cảm ơn bạn đã mua sắm,<br>
Siêu Thị Vina
</x-mail::message>