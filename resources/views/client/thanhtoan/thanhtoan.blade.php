@extends('client.layouts.app')

@section('title')
    Thanh toán đơn hàng | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="cart py-40">
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
                                <span class="text-md fw-semibold text-gray-600 border-end border-gray-600 me-8 pe-10">Cao Kiến Hựu</span>
                                <span class="text-md fw-medium text-gray-600">0845381121</span>
                            </div>
                            <div class="flex-align flex-wrap gap-4 mt-10">
                                <span class="text-sm fw-normal text-gray-600"><span
                                        class="text-xs fw-semibold text-white rounded-4 bg-success-400 px-6 ">Mặc định</span>
                                    29/7C, đường số 25-A1 Ngô Quyền, ấp Trường An, xã Trường Tây, thị xã Hòa Thành, Tây Ninh</span>
                            </div>
                            <input type="hidden" name="id_diachinguoidung" value="1">
                            <div class="border border-warning-400 bg-warning-100 px-8 py-4 mt-20 rounded-4 text-warning-900">
                                <span class="text-sm fw-medium flex-align gap-8"><i class="ph-bold ph-warning-circle text-2xl"></i> Phải sử dụng địa chỉ nhận hàng trước sáp nhập</span>
                            </div>
                        </div>
                        
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                                <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                    <table class="table style-three">
                                        <thead>
                                            <tr class=" my-10 py-10">
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-24" colspan="2">
                                                    <div>
                                                        <i class="ph-bold ph-shopping-cart text-main-600 text-lg pe-6"></i>
                                                        Tóm tắt đơn hàng ( 3 sản phẩm )
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <tr>
                                                <td class="py-10 px-5">
                                                    <div class="d-flex align-items-center gap-12">
                                                        <a href="https://sieuthivina.com/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon"
                                                            class="border border-gray-100 rounded-8 flex-center"
                                                            style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                                            <img src="{{asset('assets/client')}}/images/thumbs/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-1.webp"
                                                                alt="Nước yến sào Nest100 lon 190ml - Hộp 5 lon"
                                                                class="w-100 rounded-8">
                                                        </a>
                                                        <div class="table-product__content text-start">
                                                            <h6 class="title text-sm fw-semibold mb-0">
                                                                <a href="https://sieuthivina.com/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon"
                                                                    class="link text-line-2"
                                                                    title="Nước yến sào Nest100 lon 190ml - Hộp 5 lon"
                                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Nước yến sào Nest100 lon 190ml - Hộp 5 lon</a>
                                                            </h6>
                                                            <div class="flex-align gap-16 mb-6">
                                                                <a href="https://sieuthivina.com/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon"
                                                                    class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                    Có đường (190ml/lon)
                                                                </a>
                                                            </div>
                                                            <div class="product-card__price mb-6">
                                                                <div class="flex-align gap-12">
                                                                    <span class="text-heading text-xs fw-medium bg-gray-100 px-6 py-4 rounded-4">x 2</span>
                                                                    <span class="text-main-600 text-sm fw-bold">102.000 đ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="item-id" value="30">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-10 px-5">
                                                    <div class="d-flex align-items-center gap-12">
                                                        <a href="https://sieuthivina.com/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon"
                                                            class="border border-gray-100 rounded-8 flex-center"
                                                            style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                                            <img src="{{asset('assets/client')}}/images/thumbs/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-1.webp"
                                                                alt="Nước yến sào Nest100 lon 190ml - Hộp 5 lon"
                                                                class="w-100 rounded-8">
                                                        </a>
                                                        <div class="table-product__content text-start">
                                                            <h6 class="title text-sm fw-semibold mb-0">
                                                                <a href="https://sieuthivina.com/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon"
                                                                    class="link text-line-2"
                                                                    title="Nước yến sào Nest100 lon 190ml - Hộp 5 lon"
                                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Nước yến sào Nest100 lon 190ml - Hộp 5 lon</a>
                                                            </h6>
                                                            <div class="flex-align gap-16 mb-6">
                                                                <a href="https://sieuthivina.com/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon"
                                                                    class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                    Có đường (190ml/lon)
                                                                </a>
                                                            </div>
                                                            <div class="product-card__price mb-6">
                                                                <div class="flex-align gap-12">
                                                                    <span class="text-heading text-xs fw-medium bg-gray-100 px-6 py-4 rounded-4">x 2</span>
                                                                    <span class="text-main-600 text-sm fw-bold">102.000 đ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="item-id" value="30">
                                                </td>
                                            </tr>
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
                            <label for="phuongthuc1" class="w-100 mt-10 border border-gray-100 py-16 px-12 rounded-4" style="cursor:pointer;">
                                    <div class="payment-item">
                                        <div class="form-check common-check common-radio mb-0">
                                            <input class="form-check-input" type="radio" name="phuongthuc" id="phuongthuc1"
                                                checked="Thanh toán khi nhận hàng (COD)">
                                            <label class="form-check-label fw-medium text-neutral-600 text-sm w-100"
                                                for="phuongthuc1">Thanh toán khi nhận hàng (COD)</label>
                                        </div>
                                    </div>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 pb-20">
                            <h6 class="flex-between flex-align mb-20">
                                <span class="text-lg flex-align gap-8">
                                    <i class="ph-bold ph-ticket text-main-600 text-xl"></i>Áp dụng Voucher
                                </span>
                                <a href="https://sieuthivina.com/gio-hang"
                                    class="text-xs text-primary-700 flex-align gap-1 fw-normal" style="cursor:pointer;">
                                    <i class="ph-bold ph-pencil-simple"></i> Thay đổi
                                </a>
                            </h6>
                            <div class="flex-align flex-between gap-8 mt-10 border-dashed border-gray-200 py-10 px-12 rounded-4">
                                <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                    <i class="ph-bold ph-ticket text-main-600 text-2xl"></i>
                                    <div class="text-sm d-flex flex-column">
                                        <span class="text-sm text-gray-900 w-100">
                                            Giảm 50.000 đ
                                        </span>
                                        <span class="text-xs text-gray-500 w-100">
                                            NEWSTORE50K
                                        </span>
                                    </div>
                                </span>
                                <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                    <button class="btn bg-success-600 text-white hover-bg-white border hover-border-success-600 hover-text-success-600 p-6 rounded-4 text-xs" style="cursor: pointer;" disabled="">
                                        Đã chọn
                                    </button>
                                </span>
                            </div>
                        </div>
                        
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 mt-20">
                            <div class="mb-20">
                                <h6 class="text-lg mb-6 flex-align gap-4"><i
                                        class="ph-bold ph-notepad text-main-600 text-xl"></i>Đơn hàng</h6>
                                <a href="#" class="text-sm text-gray-600 flex-align gap-1 fw-medium" style="cursor:pointer;">
                                    3 sản phẩm + 1 quà tặng
                                     
                                </a>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Tổng tiền hàng:</span>
                                <span class="text-gray-900 fw-semibold">138.000 đ</span>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two d-flex flex-column"><span>Phí vận
                                        chuyển:</span>                                    <span class="text-xs">- Ngoại tỉnh (các vùng lân cận)</span>
                                </span>
                                <span class="text-gray-900 fw-semibold">15.000 đ</span>
                            </div>
                            <div class="flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Giảm giá:</span>
                                <span class="text-success-600 fw-semibold"> - 50.000 đ</span>
                            </div>
                            <div class="border-top border-gray-100 my-20 pt-24">
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 text-lg fw-semibold">Tổng thanh toán:</span>
                                    <span class="text-main-600 text-lg fw-semibold">
                                        103.000 đ
                                    </span>
                                </div>
                                <div class="text-end gap-8">
                                    <span class="text-success-600 text-sm fw-normal">Tiết kiệm:</span>
                                    <span class="text-success-600 text-sm fw-normal">
                                        929.000 đ
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