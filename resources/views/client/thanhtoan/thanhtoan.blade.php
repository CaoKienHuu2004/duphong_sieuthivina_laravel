@extends('client.layouts.app')

@section('title')
    Thanh toán đơn hàng | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="cart py-20">
            
            <div class="container container-lg">
                @if(session('error'))
                    <span class="border-dashed border-2 border-main-500 bg-main-100 text-main-900 rounded-8 px-4 py-2 mb-10">{{ session('error') }}</span>
                @endif
                <form action="{{ route('dat-hang') }}" method="POST" class="row gy-4">
                    @csrf
                    <div class="col-xl-7 col-lg-8">
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20">
                            <div class="flex-align flex-between gap-8 mb-20">
                                <h6 class="text-lg m-0 flex-align gap-4">
                                    <i class="ph-bold ph-map-pin-area text-main-600 text-xl"></i>Người nhận hàng</h6>
                                <span href="" class="text-xs text-primary-700 flex-align gap-1 fw-normal" id="openModalBtn" style="cursor:pointer;"><i class="ph-bold ph-pencil-simple"></i> Thay đổi</span>
                            </div>
                            <div class="flex-align flex-wrap">
                                <span class="text-md fw-semibold text-gray-600 border-end border-gray-600 me-8 pe-10">{{ $diachiMacDinh->hoten }}</span>
                                <span class="text-md fw-medium text-gray-600">{{ $diachiMacDinh->sodienthoai }}</span>
                            </div>
                            <div class="flex-align flex-wrap gap-4 mt-10">
                                <span class="text-sm fw-normal text-gray-600"><span
                                        class="text-xs fw-semibold text-white rounded-4 bg-main-two-600 px-7 py-1">Mặc định</span>
                                    {{ $diachiMacDinh->diachi }}, {{ $diachiMacDinh->tinhthanh }}</span>
                            </div>
                            <input type="hidden" name="id_diachinguoidung" value="{{ $diachiMacDinh->id }}">
                            <div class="border border-warning-400 bg-warning-100 px-8 py-4 mt-20 rounded-4 text-warning-900">
                                <span class="text-sm fw-medium flex-align gap-8"><i class="ph-bold ph-warning-circle text-2xl"></i> Phải sử dụng địa chỉ nhận hàng trước sáp nhập</span>
                            </div>
                        </div>
                        @php
                            // Lọc ra các sản phẩm MUA (thanhtien > 0)
                            $sanPham = collect($cartData['giohang'])->filter(function($item) {
                                return $item['thanhtien'] >= 0;
                            });

                            // Lọc ra các sản phẩm MUA (thanhtien > 0)
                            $sanPhamMua = collect($cartData['giohang'])->filter(function($item) {
                                return $item['thanhtien'] > 0;
                            });
                            
                            // Lọc ra các sản phẩm QUÀ TẶNG (thanhtien == 0)
                            $quaTang = collect($cartData['giohang'])->filter(function($item) {
                                return $item['thanhtien'] == 0;
                            });
                        @endphp
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                                <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                    <table class="table style-three mb-20">
                                        <thead>
                                            <tr class=" my-10 py-10">
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-24" colspan="2">
                                                    <div>
                                                        <i class="ph-bold ph-shopping-cart text-main-600 text-lg pe-6"></i>
                                                        Tóm tắt đơn hàng ( {{ $sanPham->count() }} sản phẩm )
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($sanPham as $item)
                                           <tr>
                                                
                                                <td class="rounded-4 py-10 px-5">
                                                    @if($item['thanhtien']==0)<span class="flex-align mb-10 text-sm fw-medium"><i class="ph-bold ph-gift text-main-600 text-lg pe-4"></i>Quà tặng nhận được</span>@endif
                                                    <div class="d-flex align-items-center gap-12">
                                                        <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                            class="border border-gray-100 rounded-8 flex-center"
                                                            style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                                            <img src="{{asset('assets/client')}}/images/thumbs/{{ $item['bienthe']['sanpham']['hinhanhsanpham'][0]['hinhanh'] }}"
                                                                alt="{{ $item['bienthe']['sanpham']['ten'] }}"
                                                                class="w-100 rounded-8">
                                                        </a>
                                                        <div class="table-product__content text-start">
                                                            <h6 class="title text-sm fw-semibold mb-0">
                                                                <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                                    class="link text-line-2"
                                                                    title="{{ $item['bienthe']['sanpham']['ten'] }}"
                                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $item['bienthe']['sanpham']['ten'] }}</a>
                                                            </h6>
                                                            <div class="flex-align gap-16 mb-6">
                                                                <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                                    class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                    {{ $item['bienthe']['loaibienthe']['ten'] }}
                                                                </a>
                                                            </div>
                                                            <div class="product-card__price mb-6">
                                                                <div class="flex-align gap-12">
                                                                    <span class="text-heading text-xs fw-medium bg-gray-100 px-6 py-4 rounded-4">x {{ $item['soluong'] }}</span>
                                                                    <span class="text-main-600 text-sm fw-bold">{{ number_format($item['thanhtien'], 0, ',', '.') }} ₫</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="item-id" value="30">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20 mt-20">
                            <h6 class="flex-between flex-align mb-20">
                                <span class="text-lg flex-align gap-8">
                                    <i class="ph-bold ph-wallet text-main-600 text-xl"></i>Phương thức thanh toán
                                </span>
                            </h6>
                            @foreach ($phuongthucs as $phuongthuc)
                                <label for="phuongthuc{{ $phuongthuc->id }}" class="w-100 mt-10 border border-gray-100 hover-border-main-600 hover-bg-main-50 py-16 px-12 rounded-4 transition-1" style="cursor:pointer;">
                                    <div class="">
                                        <div class="form-check common-check common-radio mb-0">
                                            <input class="form-check-input" type="radio" name="id_phuongthuc" id="phuongthuc{{ $phuongthuc->id }}" value="{{ $phuongthuc->id }}" @if ($phuongthuc->id == 1) checked @endif>
                                            <label class="form-check-label fw-medium text-neutral-600 text-sm w-100"
                                                for="phuongthuc{{ $phuongthuc->id }}">{{ $phuongthuc->ten }}</label>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20">
                            <h6 class="flex-between flex-align mb-20">
                                <span class="text-lg flex-align gap-8">
                                    <i class="ph-bold ph-ticket text-main-600 text-xl"></i>Áp dụng Voucher
                                </span>
                                <a href="{{ route('gio-hang') }}"
                                    class="text-xs text-primary-700 flex-align gap-1 fw-normal" style="cursor:pointer;">
                                    <i class="ph-bold ph-pencil-simple"></i> Thay đổi
                                </a>
                            </h6>
                            @if ($cartData['appliedVoucher'])
                                <div class="flex-align flex-between gap-8 mt-10 border-dashed border-gray-200 py-10 px-12 rounded-4">
                                    <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                        <i class="ph-bold ph-ticket text-main-600 text-2xl"></i>
                                        <div class="text-sm d-flex flex-column">
                                            <span class="text-sm text-gray-900 w-100">
                                                Giảm {{ number_format($cartData['appliedVoucher']['giatri'], 0, ',', '.') }} ₫
                                            </span>
                                            <span class="text-xs text-gray-500 w-100">
                                                {{ $cartData['appliedVoucher']['magiamgia'] }}
                                            </span>
                                        </div>
                                    </span>
                                    <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                        <button class="btn bg-main-two-600 text-white hover-bg-white border hover-border-main-two-600 hover-text-main-two-600 p-6 rounded-4 text-xs" style="cursor: pointer;" disabled="">
                                            Đã chọn
                                        </button>
                                    </span>
                                </div>
                            @else
                                <div class="flex-align flex-center gap-8 mt-10 py-10 px-12 rounded-4">
                                    <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                        <div class="text-sm d-flex flex-column">
                                            <span class="text-sm text-gray-900 w-100">
                                                Không có áp dụng Voucher !
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 mt-20">
                            <div class="mb-20">
                                <h6 class="text-lg mb-6 flex-align gap-4"><i
                                        class="ph-bold ph-notepad text-main-600 text-xl"></i>Đơn hàng</h6>
                                <a href="#" class="text-sm text-gray-600 flex-align gap-1 fw-medium" style="cursor:pointer;">
                                    {{ $sanPhamMua->count() }} sản phẩm 
                                    @if ($quaTang->count() > 0)
                                        + {{ $quaTang->count() }} quà tặng
                                    @endif
                                </a>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Tổng tiền hàng:</span>
                                <span class="text-gray-900 fw-semibold">{{ number_format($cartData['tamtinh'], 0, ',', '.') }} ₫</span>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two d-flex flex-column">
                                    <span>Phí vận chuyển:</span>
                                    <span class="text-xs">- {{ $phivanchuyenModel->ten }}</span>
                                </span>
                                <span class="text-gray-900 fw-semibold">{{ number_format($phiVanChuyen, 0, ',', '.') }} ₫</span>
                            </div>
                            @if($cartData['giamgiaVoucher'] > 0)
                            <div class="flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Giảm giá:</span>
                                <span class="text-main-two-600 fw-semibold"> - {{ number_format($cartData['giamgiaVoucher'], 0, ',', '.') }} ₫</span>
                            </div>
                            @endif
                            <div class="border-top border-gray-100 my-20 pt-24">
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 text-lg fw-semibold">Tổng thanh toán:</span>
                                    <span class="text-main-600 text-lg fw-semibold">
                                        {{ number_format($cartData['tong_thanh_toan'], 0, ',', '.') }} ₫
                                    </span>
                                </div>
                                @if ($cartData['tietkiem'] > 0)
                                    <div class="text-end gap-8">
                                        <span class="text-main-two-600 text-sm fw-normal">Tiết kiệm:</span>
                                        <span class="text-main-two-600 text-sm fw-normal">
                                            {{ number_format($cartData['tietkiem'], 0, ',', '.') }} ₫
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-main py-14 w-100 rounded-8">Đặt hàng</button>
                        </div>
                        <span class="mt-20 w-100">
                            <a href="{{ route('gio-hang') }}" class="text-sm text-main-two-600 fw-medium flex-align d-flex flex-center transition-1 link" style="cursor:pointer;">
                                    <i class="ph-bold ph-arrow-fat-lines-left text-main-two-600 text-md pe-10"></i> <span>Quay lại giỏ hàng</span> 
                                </a>
                        </span>
                    </div>
                </form>
            </div>
        </section>
        <style>
        /* --- CSS cho Modal --- */
        
        /* Modal Backdrop */
        .modal {
            display: none; /* Mặc định ẩn modal */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6); /* Nền tối mờ */
            /* Thêm animation fade in */
            /* animation: fadeIn 0.3s ease-out; */
        }

        /* Modal Content (Popup chính) */
        .modal-content {
            background-color: #fefefe;
            margin: 50px auto; /* Đặt modal ở giữa màn hình */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
            /* Thêm animation slide down */
            /* animation: slideDown 0.4s ease-out; */
        }
        
        /* Tiêu đề */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        /* Nút đóng (X) */
        .close-btn {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #333;
            text-decoration: none;
        }
        
        /* Các Form Địa chỉ */
        .address-form {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .address-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .address-form p {
            margin: 5px 0 10px 0;
            color: #555;
            font-size: 14px;
        }

        .address-form button {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .address-form button:hover {
            background-color: #0056b3;
        }

        /* Animation Keyframes */
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes slideDown {
            from {transform: translateY(-50px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        @keyframes zoomIn {
            0% { /* Bắt đầu */
                opacity: 0;
                transform: scale(0.7); /* Rất nhỏ */
            }
            60% { /* Phóng to quá mức */
                opacity: 1;
                transform: scale(1.1); /* Phóng to hơn kích thước thật một chút */
            }
            80% { /* Lùi lại một chút */
                transform: scale(0.95); /* Thu nhỏ lại một chút */
            }
            100% { /* Về kích thước cuối cùng */
                transform: scale(1); /* Kích thước thật */
            }
        }
    </style>
        <div id="deliveryAddressModal" class="modal">

        <div class="modal-content container container-lg">
            <div class="flex-align flex-between">
                <span class="pb-10 fw-semibold text-lg text-gray-900">Thay đổi địa chỉ giao hàng</span>
                <button class="pb-10 rounded-circle 0 fw-semibold text-2xl text-gray-900 close-btn" style="cursor: pointer;">&times;</button>
            </div>
                <div class="row gy-4">
                    @foreach ($diachis as $diachi)
                    <div class="col-lg-6 col-xl-6">
                        <form action="{{ route('cap-nhat-mac-dinh') }}" method="POST" class="border-dashed border-2 border-gray-500 text-main-900 rounded-8 px-10 py-8 mb-10">
                            @csrf
                            <div class="d-flex flex-align flex-between gap-24">
                                <div class="flex-align gap-12">
                                    <span class="fw-semibold text-gray-900 text-md border-end border-gray-600 pe-10">{{ $diachi->hoten }}</span>
                                    <span class="fw-semibold text-gray-900 text-md">{{ $diachi->sodienthoai }}</span>
                                </div>
                                <div class="flex-align gap-12">
                                    @if ($diachi->trangthai == 'Mặc định')
                                        <span class="fw-medium text-xs text-main-two-700 bg-main-two-100 px-6 py-2 rounded-4 flex-align gap-8">{{ $diachi->trangthai }}</span>
                                    @else
                                        <span class="fw-medium text-xs text-gray-700 bg-gray-100 px-6 py-2 rounded-4 flex-align gap-8">{{ $diachi->trangthai }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-align gap-24 pt-10">
                                <div class="flex-align gap-12">
                                    <span class="fw-medium text-gray-900 text-sm">Địa chỉ: {{ $diachi->diachi }}, {{ $diachi->tinhthanh }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-align gap-24 pt-10">
                                <div class="flex-align gap-12">
                                    @if ($diachi->trangthai == 'Mặc định')
                                        <span class="text-sm bg-main-300 text-white rounded-4 px-8 py-6 w-100 transition-1 gap-8">Đặt làm mặc định</span>
                                    @else
                                        <input type="hidden" name="id_diachi" value="{{ $diachi->id }}">
                                        <button type="submit" class="text-sm bg-main-600 text-white hover-bg-white hover-text-main-900 border hover-border-main-600 rounded-4 px-8 py-6 w-100 transition-1 gap-8">Đặt làm mặc định</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            
            </div>
    </div>

    <script>
        // Lấy các element cần thiết
        var modal = document.getElementById("deliveryAddressModal");
        var btn = document.getElementById("openModalBtn");
        var closeBtn = document.getElementsByClassName("close-btn")[0];

        // 1. Khi người dùng click vào nút, mở modal
        btn.onclick = function() {
            modal.style.display = "block";
            // Kích hoạt lại animation mỗi lần mở (tùy chọn)
            // modal.querySelector('.modal-content').style.animation = 'slideDown 0.4s ease-out';
            // modal.style.animation = 'fadeIn 0.3s ease-out';
        }

        // 2. Khi người dùng click vào nút (X), đóng modal
        closeBtn.onclick = function() {
            // Thay đổi display sau khi animation kết thúc để có hiệu ứng mượt mà
            // modal.querySelector('.modal-content').style.animation = 'slideDown 0.4s ease-out reverse forwards';
            // modal.style.animation = 'fadeIn 0.3s ease-out reverse forwards';
            
            setTimeout(() => {
                 modal.style.display = "none";
            }, 100); // Chờ 400ms (thời gian animation) để đóng hẳn
        }

        // 3. Khi người dùng click vào bất cứ đâu bên ngoài modal, đóng modal
        window.onclick = function(event) {
            if (event.target == modal) {
                // Tương tự, dùng animation ngược trước khi đóng
                // modal.querySelector('.modal-content').style.animation = 'slideDown 0.4s ease-out reverse forwards';
                // modal.style.animation = 'fadeIn 0.3s ease-out reverse forwards';
                
                setTimeout(() => {
                    modal.style.display = "none";
                }, 100);
            }
        }
    </script>
    </div>
@endsection