@extends('client.layouts.app')

@section('title')
    Thanh toán đơn hàng | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="cart py-20">
            <div class="container container-lg">
                <form action="" method="POST" class="row gy-4">
                    <div class="col-xl-7 col-lg-8">
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20">
                            <div class="flex-align flex-between gap-8 mb-20">
                                <h6 class="text-lg m-0 flex-align gap-4">
                                    <i class="ph-bold ph-map-pin-area text-main-600 text-xl"></i>Người nhận hàng</h6>
                                <a href="#" class="text-xs text-primary-700 flex-align gap-1 fw-normal" style="cursor:pointer;"><i class="ph-bold ph-pencil-simple"></i> Thay đổi</a>
                            </div>
                            <div class="flex-align flex-wrap">
                                <span class="text-md fw-semibold text-gray-600 border-end border-gray-600 me-8 pe-10">{{ $diachiMacDinh->hoten }}</span>
                                <span class="text-md fw-medium text-gray-600">{{ $diachiMacDinh->sodienthoai }}</span>
                            </div>
                            <div class="flex-align flex-wrap gap-4 mt-10">
                                <span class="text-sm fw-normal text-gray-600"><span
                                        class="text-xs fw-semibold text-white rounded-4 bg-success-400 px-6 ">Mặc định</span>
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
                                    <table class="table style-three">
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
                                                <td class="py-10 px-5">
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
                                <label for="phuongthuc1" class="w-100 mt-10 border border-gray-100 hover-border-main-600 hover-bg-main-50 py-16 px-12 rounded-4 transition-1" style="cursor:pointer;">
                                    <div class="payment-item">
                                        <div class="form-check common-check common-radio mb-0">
                                            <input class="form-check-input" type="radio" name="phuongthuc" id="phuongthuc{{ $phuongthuc->id }}" value="{{ $phuongthuc->id }}" @if ($phuongthuc->id == 1) checked @endif>
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
                                        <button class="btn bg-success-600 text-white hover-bg-white border hover-border-success-600 hover-text-success-600 p-6 rounded-4 text-xs" style="cursor: pointer;" disabled="">
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
                                <span class="text-success-600 fw-semibold"> - {{ number_format($cartData['giamgiaVoucher'], 0, ',', '.') }} ₫</span>
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
                                        <span class="text-success-600 text-sm fw-normal">Tiết kiệm:</span>
                                        <span class="text-success-600 text-sm fw-normal">
                                            {{ number_format($cartData['tietkiem'], 0, ',', '.') }} ₫
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-main py-14 w-100 rounded-8">Đặt hàng</button>
                        </div>
                        <span class="mt-20 w-100">
                            <a href="{{ route('gio-hang') }}" class="text-sm text-main-600 fw-medium flex-align d-flex flex-center transition-1 link" style="cursor:pointer;">
                                    <i class="ph-bold ph-arrow-fat-lines-left text-main-600 text-md pe-10"></i> <span>Quay lại giỏ hàng</span> 
                                </a>
                        </span>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection