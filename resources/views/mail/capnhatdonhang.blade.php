<x-mail::message>
# Xin chào {{ $donhang->nguoinhan }},

{{ $tieuDe }}

**Trạng thái đơn hàng:** {{ $donhang->trangthai }}

{{ $noiDung }}

---

### Thông tin đơn hàng #{{ $donhang->madon }}

| Sản phẩm | Tổng tiền |
|:--- |:--- |
| Đơn hàng gồm {{ $donhang->chitietdonhang->count() ?? 'nhiều' }} sản phẩm | **{{ number_format($donhang->thanhtien) }} đ** |

<x-mail::button :url="$urlChiTiet" color="success">
Xem chi tiết đơn hàng
</x-mail::button>

Cảm ơn bạn đã mua sắm,<br>
{{ config('app.name') }}
</x-mail::message>