@extends('client.layouts.app')

@section('title')
    Thanh toán đơn hàng | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="cart py-40">
            <div class="container container-lg">
                <form action="{{ route('dat-hang') }}" method="POST" class="row gy-4">
                    <div class="col-xl-9 col-lg-8">
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0">
                                <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                    <table class="table style-three">
                                        <thead>
                                            <tr class="border-bottom border-gray-500 my-10 py-10">
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-24" colspan="2">
                                                    <div>
                                                        <i class="ph-bold ph-shopping-cart text-main-600 text-lg pe-6"></i>
                                                        Giỏ hàng ( {{ collect($cartData['giohang'])
                                                                        ->filter(function($item) {
                                                                            return $item['thanhtien'] > 0;
                                                                        })
                                                                        ->count() }} sản phẩm )
                                                    </div>
                                                </th>
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Số lượng</th>
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cartData['giohang'] as $item)
                                            @if($item['thanhtien'] > 0)
                                            <tr>
                                                <td class="py-20 px-5">
                                                    <div class="d-flex align-items-center gap-12">
                                                        <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                            class="border border-gray-100 rounded-8 flex-center"
                                                            style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ $item['bienthe']['sanpham']['hinhanhsanpham'][0]['hinhanh'] }}"
                                                                alt="{{ $item['bienthe']['sanpham']['ten'] }}"
                                                                class="w-100 rounded-8">
                                                        </a>
                                                        <div class="table-product__content text-start">
                                                            <div class="flex-align gap-16">
                                                                <div class="flex-align gap-4 mb-5">
                                                                    <span class="text-main-two-600 text-md d-flex"><i
                                                                            class="ph-fill ph-storefront"></i></span>
                                                                    <span class="text-gray-500 text-xs"
                                                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 300px; display: inline-block;"
                                                                        title="{{ $item['bienthe']['sanpham']['thuonghieu']['ten'] }}">{{ $item['bienthe']['sanpham']['thuonghieu']['ten'] }}</span>
                                                                </div>
                                                            </div>
                                                            <h6 class="title text-lg fw-semibold mb-0">
                                                                <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                                    class="link text-line-2"
                                                                    title="{{ $item['bienthe']['sanpham']['ten'] }}"
                                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 450px; display: inline-block;">{{ $item['bienthe']['sanpham']['ten'] }}</a>
                                                            </h6>
                                                            <div class="flex-align gap-16 mb-6">
                                                                <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                                    class="btn bg-gray-50 text-heading text-sm py-6 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                                    {{ $item['bienthe']['loaibienthe']['ten'] }}
                                                                </a>
                                                            </div>
                                                            <div class="product-card__price mb-6">
                                                                @if ($item['bienthe']['sanpham']['giamgia'] > 0)
                                                                    <div class="flex-align gap-4 text-main-two-600 text-sm">
                                                                        <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $item['bienthe']['sanpham']['giamgia'] }}% 
                                                                        <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">{{ number_format($item['bienthe']['giagoc'],'0',',','.') }} đ</span>
                                                                    </div>
                                                                @endif
                                                                <span class="text-heading text-md fw-bold">{{ number_format($item['bienthe']['giadagiam'],'0','.','.')}} đ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="item-id" value="30">
                                                </td>
                                                <td class="py-20 px-5">
                                                    <div class="d-flex rounded-4 overflow-hidden">
                                                        <input type="text"
                                                            class="quantity__input flex-grow-1 border border-start-0 border-end-0 text-center w-32 px-4 py-8 bg-gray-100"
                                                            value="x {{ $item['soluong'] }}" min="1" readonly="">
                                                    </div>
                                                </td>
                                                <td class="py-20 px-5">
                                                    <span class="text-lg h6 mb-0 fw-semibold text-main-600">{{ number_format($item['thanhtien'],0,',','.') }} đ</span>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>

                        @if ($cartData['tongsoquatang'] > 0)
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                            <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                <table class="table style-three">
                                    <thead>
                                        <tr class="border-bottom border-gray-500 my-10 py-10">
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-6" colspan="2">
                                                <i class="ph-bold ph-gift text-main-600 text-lg"></i> Quà tặng nhận được ( {{ $cartData['tongsoquatang'] }} sản phẩm )
                                            </th>
                                            <th class="px-60"></th>
                                            <th class="px-60"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartData['giohang'] as $item)
                                        @if($item['thanhtien'] == 0)
                                        <tr class="">
                                            <td class="py-20 px-5">
                                                <div class="d-flex align-items-center gap-12">
                                                    <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                        class="border border-gray-100 rounded-8 flex-center"
                                                        style="max-width: 100px; max-height: 100px; width: 100%; height: 100%">
                                                        <img src="{{ asset('assets/client') }}/images/thumbs/{{ $item['bienthe']['sanpham']['hinhanhsanpham'][0]['hinhanh'] }}"
                                                            alt="Hộp quà tặng Cao cấp - Ngũ Phúc Luxury tổ yến tinh chế và yến chưng Nest100 cao cấp (kèm túi)"
                                                            class="w-100 rounded-8">
                                                    </a>
                                                    <div class="table-product__content text-start">
                                                        <div class="flex-align gap-16">
                                                            <div class="flex-align gap-4 mb-5">
                                                                <span class="text-main-two-600 text-sm d-flex"><i
                                                                        class="ph-fill ph-storefront"></i></span>
                                                                <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">{{ $item['bienthe']['sanpham']['thuonghieu']['ten'] }}</span>
                                                            </div>
                                                        </div>
                                                        <h6 class="title text-md fw-semibold mb-0">
                                                            <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}" class="link text-line-2 fw-medium"
                                                                title="Hộp quà tặng Cao cấp - Ngũ Phúc Luxury tổ yến tinh chế và yến chưng Nest100 cao cấp (kèm túi)"
                                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $item['bienthe']['sanpham']['ten'] }}</a>
                                                        </h6>
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="{{ route('chi-tiet-san-pham',$item['bienthe']['sanpham']['slug']) }}"
                                                                class="btn bg-gray-50 text-heading text-xs py-6 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                {{ $item['bienthe']['loaibienthe']['ten'] }}
                                                            </a>
                                                        </div>
                                                        <div class="product-card__price mb-6">
                                                            <div class="flex-align gap-4 text-main-two-600 text-xs">
                                                                <span
                                                                    class="text-gray-400 text-sm fw-semibold text-decoration-line-through me-4">{{ number_format($item['bienthe']['giagoc'],'0',',','.') }} đ</span>
                                                                <span
                                                                    class="flex-align gap-4 text-main-two-600 text-xs"><i
                                                                        class="ph-fill ph-seal-percent text-sm"></i> Quà
                                                                    tặng miễn phí</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <div class="d-flex rounded-4 overflow-hidden">
                                                    <input type="text"
                                                        class="quantity__input flex-grow-1 border border-start-0 border-end-0 text-center w-32 px-4 py-8 bg-gray-100"
                                                        value="x {{ $item['soluong'] }}" min="1" readonly="">
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <span class="text-lg h6 mb-0 fw-semibold text-main-600">{{ number_format($item['thanhtien'],'0','.','.') }} đ</span>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20">
                            <div class="flex-align flex-between gap-8 mb-20">
                                <h6 class="text-lg m-0 flex-align gap-4"><i
                                        class="ph-bold ph-map-pin-area text-main-600 text-xl"></i>Người nhận hàng</h6>
                                <a href="#" class="text-xs text-primary-700 flex-align gap-1 fw-normal" style="cursor:pointer;"><i class="ph-bold ph-pencil-simple"></i> Thay đổi</a>
                            </div>
                            @if ($diachiMacDinh)
                            <div class="flex-align flex-wrap">
                                <span class="text-md fw-semibold text-gray-600 border-end border-gray-600 me-8 pe-10">{{ $diachiMacDinh->hoten }}</span>
                                <span class="text-md fw-medium text-gray-600">{{ $diachiMacDinh->sodienthoai }}</span>
                            </div>
                            <div class="flex-align flex-wrap gap-4 mt-10">
                                <span class="text-sm fw-normal text-gray-600"><span
                                        class="text-xs fw-semibold text-white rounded-4 bg-success-400 px-6">Mặc định</span>
                                    {{ $diachiMacDinh->diachi }}, {{ $diachiMacDinh->tinhthanh }}</span>
                            </div>
                            @else
                                <div class="alert alert-warning mb-0">
                                    Vui lòng chọn địa chỉ nhận hàng để tiếp tục. 
                                    <a href="#" class="alert-link">Chọn địa chỉ</a>
                                </div>
                            @endif
                            <input type="hidden" name="id_diachinguoidung" value="{{ $diachiMacDinh->id ?? '' }}">
                            <div class="border border-warning-400 bg-warning-100 px-8 py-4 mt-10 rounded-4 text-warning-900">
                                <span class="text-sm fw-medium flex-align gap-8"><i class="ph-bold ph-warning-circle text-2xl"></i> Phải sử dụng địa chỉ nhận hàng trước sáp nhập</span>
                            </div>
                        </div>
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20 mt-20">
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
                                            Giảm {{ number_format($cartData['appliedVoucher']['giatri'],0,',','.') }} đ
                                        </span>
                                        <span class="text-xs text-gray-500 w-100">
                                            {{ $cartData['appliedVoucher']['magiamgia'] }}
                                        </span>
                                    </div>
                                </span>
                                <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                    <button
                                        class="btn bg-success-600 text-white hover-bg-white border hover-border-success-600 hover-text-success-600 p-6 rounded-4 text-xs"
                                        style="cursor: pointer;" disabled>
                                        Đã chọn
                                    </button>
                                </span>
                            </div>
                            @else
                                <div class="flex-align flex-center gap-8 mt-10 py-10 px-12 rounded-4">
                                <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                    <div class="text-sm d-flex flex-column">
                                        <span class="text-sm text-gray-900 w-100">
                                            Chưa áp dụng voucher nào !
                                        </span>
                                    </div>
                                </span>
                            </div>
                            @endif
                        </div>
                        @php
                            // Lọc ra các sản phẩm MUA (thanhtien > 0)
                            $sanPhamMua = collect($cartData['giohang'])->filter(function($item) {
                                return $item['thanhtien'] > 0;
                            });
                            
                            // Lọc ra các sản phẩm QUÀ TẶNG (thanhtien == 0)
                            $quaTang = collect($cartData['giohang'])->filter(function($item) {
                                return $item['thanhtien'] == 0;
                            });
                        @endphp
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 mt-20">
                            <div class="mb-20">
                                <h6 class="text-lg mb-6 flex-align gap-4"><i
                                        class="ph-bold ph-notepad text-main-600 text-xl"></i>Đơn hàng</h6>
                                <a href="#" class="text-sm text-gray-600 flex-align gap-1 fw-medium" style="cursor:pointer;">
                                    {{ $sanPhamMua->count() }} sản phẩm 
                                    @if ($quaTang->count() > 0)
                                        + {{ $quaTang->count() }} quà
                                    @endif 
                                </a>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Tổng tiền hàng:</span>
                                <span class="text-gray-900 fw-semibold">{{ number_format($cartData['tamtinh'], 0, ',', '.') }} đ</span>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two d-flex flex-column"><span>Phí vận
                                        chuyển:</span>@if ($phivanchuyenModel)
                                    <span class="text-xs">- {{ $phivanchuyenModel->ten }}</span>
                                @endif</span>
                                <span class="text-gray-900 fw-semibold">{{ number_format($phiVanChuyen, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Giảm giá:</span>
                                <span class="text-success-600 fw-semibold"> - {{ number_format($cartData['giamgiaVoucher'], 0, ',', '.') }} đ</span>
                            </div>
                            <div class="border-top border-gray-100 my-10 pt-24">
                                <div class="payment-item">
                                    <div class="form-check common-check common-radio mb-0">
                                        <input class="form-check-input" type="radio" name="phuongthuc" id="phuongthuc1"
                                            checked="Thanh toán khi nhận hàng (COD)">
                                        <label class="form-check-label fw-medium text-neutral-600 text-sm w-100"
                                            for="phuongthuc1">Thanh toán khi nhận hàng (COD)</label>
                                    </div>
                                </div>

                            </div>
                            <div class="border-top border-gray-100 my-20 pt-24">
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 text-lg fw-semibold">Tổng thanh toán:</span>
                                    <span class="text-main-600 text-lg fw-semibold">
                                        {{ number_format($cartData['tong_thanh_toan'], 0, ',', '.') }} đ
                                    </span>
                                </div>
                                <div class="text-end gap-8">
                                    <span class="text-success-600 text-sm fw-normal">Tiết kiệm:</span>
                                    <span class="text-success-600 text-sm fw-normal">
                                        {{ number_format($cartData['tietkiem'], 0, ',', '.') }} đ
                                    </span>
                                </div>
                            </div>
                            <a href="checkout.html" class="btn btn-main py-14 w-100 rounded-8">Đặt hàng</a>
                        </div>
                        <span class="mt-20 w-100">
                            <a href="{{ route('gio-hang') }}" class="text-sm text-main-600 fw-medium flex-align d-flex flex-center transtional-2 link" style="cursor:pointer;">
                                    <i class="ph-bold ph-arrow-fat-lines-left text-main-600 text-md pe-10"></i> <span>Quay lại giỏ hàng</span> 
                                </a>
                        </span>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection