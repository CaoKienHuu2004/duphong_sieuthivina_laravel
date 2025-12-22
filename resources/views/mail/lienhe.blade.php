@component('mail::message')
# 👋 Bạn có liên hệ mới!

Hệ thống vừa nhận được thông tin liên hệ từ khách hàng **{{ $dataInfo['hoten'] }}**.

@component('mail::panel')
**Nội dung nhắn gửi:** "{{ $dataInfo['content'] }}"
@endcomponent

## Thông tin chi tiết:

@component('mail::table')
| Tiêu đề | Nội dung |
| :--------- | :------------- |
| **Họ tên** | {{ $dataInfo['hoten'] }} |
| **Email** | {{ $dataInfo['email'] }} |
| **SĐT** | {{ $dataInfo['phone'] }} |
| **Thời gian** | {{ $dataInfo['time'] }} |
@endcomponent

@component('mail::button', ['url' => 'mailto:' . $dataInfo['email'], 'color' => 'primary'])
Trả lời khách ngay
@endcomponent

Xin cảm ơn,  
**Siêu Thị Vina**
@endcomponent