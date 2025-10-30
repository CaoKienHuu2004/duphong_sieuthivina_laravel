@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
         <section class="cart py-40">
            <div class="container container-lg">
                <div class="row gy-4">
                    <div class="col-xl-9 col-lg-8">
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0">
                            <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                <table class="table style-three">
                                    <thead>
                                        <tr class="border-bottom border-gray-500 my-10 py-10">
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-6" colspan="2"><i class="ph-bold ph-shopping-cart text-main-600 text-lg"></i> Giỏ hàng ( 2 sản phẩm )</th>
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Số lượng</th>
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td class="py-20 px-5">
                                                <div class="d-flex align-items-center gap-12">
                                                    <button type="button" class="flex-align gap-8 hover-text-danger-600 pe-10">
                                                        <i class="ph ph-trash text-2xl d-flex"></i>
                                                        Xóa
                                                    </button>
                                                    <a href="" class="border border-gray-100 rounded-8 flex-center" style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                                                        <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp" alt="" class="w-100 rounded-8">
                                                    </a>
                                                    <div class="table-product__content text-start">
                                                        <div class="flex-align gap-16">
                                                            <div class="flex-align gap-4 mb-5">
                                                                <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                                <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">CHẤT VIỆT GROUP</span>
                                                            </div>
                                                        </div>
                                                        <h6 class="title text-lg fw-semibold mb-0">
                                                            <a href="#" class="link text-line-2" title="Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo</a>
                                                        </h6>
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="#" class="product-card__cart btn bg-gray-50 text-heading text-sm py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                                Loại thường (20 gói x 15g)
                                                            </a>
                                                        </div>
                                                        <div class="product-card__price mb-6">
                                                            <div class="flex-align gap-4 text-main-two-600 text-sm">
                                                                <i class="ph-fill ph-seal-percent text-sm"></i> -10% 
                                                                <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">340.000 đ</span>
                                                            </div>
                                                            <span class="text-heading text-md fw-bold">306.000 đ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <div class="d-flex rounded-4 overflow-hidden">
                                                    <button type="button" class="quantity__minus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-minus"></i>
                                                    </button>
                                                    <input type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4" value="1" min="1">
                                                    <button type="button" class="quantity__plus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <span class="text-lg h6 mb-0 fw-semibold text-main-600">306.000 đ</span>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td class="py-20 px-5">
                                                <div class="d-flex align-items-center gap-12">
                                                    <button type="button" class="flex-align gap-8 hover-text-danger-600 pe-10">
                                                        <i class="ph ph-trash text-2xl d-flex"></i>
                                                        Xóa
                                                    </button>
                                                    <a href="" class="border border-gray-100 rounded-8 flex-center" style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                                                        <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp" alt="" class="w-100 rounded-8">
                                                    </a>
                                                    <div class="table-product__content text-start">
                                                        <div class="flex-align gap-16">
                                                            <div class="flex-align gap-4 mb-5">
                                                                <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                                <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">CHẤT VIỆT GROUP</span>
                                                            </div>
                                                        </div>
                                                        <h6 class="title text-lg fw-semibold mb-0">
                                                            <a href="#" class="link text-line-2" title="Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo</a>
                                                        </h6>
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="#" class="product-card__cart btn bg-gray-50 text-heading text-sm py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                                Loại thường (20 gói x 15g)
                                                            </a>
                                                        </div>
                                                        <div class="product-card__price mb-6">
                                                            <div class="flex-align gap-4 text-main-two-600 text-sm">
                                                                <i class="ph-fill ph-seal-percent text-sm"></i> -10% 
                                                                <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">340.000 đ</span>
                                                            </div>
                                                            <span class="text-heading text-md fw-bold">306.000 đ</span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <div class="d-flex rounded-4 overflow-hidden">
                                                    <button type="button" class="quantity__minus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-minus"></i>
                                                    </button>
                                                    <input type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4" value="1" min="1">
                                                    <button type="button" class="quantity__plus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <span class="text-lg h6 mb-0 fw-semibold text-main-600">306.000 đ</span>
                                            </td>
                                        </tr>
                                             
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                            <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                <table class="table style-three">
                                    <thead>
                                        <tr class="border-bottom border-gray-500 my-10 py-10">
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-6" colspan="2"><i class="ph-bold ph-gift text-main-600 text-lg"></i> Quà tặng nhận được ( 1 sản phẩm )</th>
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Số lượng</th>
                                            <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td class="py-20 px-5">
                                                <div class="d-flex align-items-center gap-12">
                                                    <a href="" class="border border-gray-100 rounded-8 flex-center" style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                                                        <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp" alt="" class="w-100 rounded-8">
                                                    </a>
                                                    <div class="table-product__content text-start">
                                                        <div class="flex-align gap-16">
                                                            <div class="flex-align gap-4 mb-5">
                                                                <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                                <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">CHẤT VIỆT GROUP</span>
                                                            </div>
                                                        </div>
                                                        <h6 class="title text-lg fw-semibold mb-0">
                                                            <a href="#" class="link text-line-2" title="Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo</a>
                                                        </h6>
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="#" class="product-card__cart btn bg-gray-50 text-heading text-sm py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                                Loại thường (20 gói x 15g)
                                                            </a>
                                                        </div>
                                                        <div class="product-card__price mb-6">
                                                            <div class="flex-align gap-4 text-main-two-600 text-sm">
                                                                <i class="ph-fill ph-seal-percent text-md"></i> Quà tặng miễn phí
                                                            </div>
                                                            <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">340.000 đ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <div class="d-flex rounded-4 overflow-hidden">
                                                    <button type="button" class=" border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-minus"></i>
                                                    </button>
                                                    <input type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4 bg-gray-100" value="1" min="1" readonly>
                                                    <button type="button" class=" border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                        <i class="ph ph-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="py-20 px-5">
                                                <span class="text-lg h6 mb-0 fw-semibold text-main-600">0 đ</span>
                                            </td>
                                        </tr>
                                             
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-24 py-30 pb-20">
                            <h6 class="text-lg mb-20 flex-align gap-8"><i class="ph-bold ph-ticket text-main-600 text-xl"></i>Áp dụng Voucher</h6>
                            <div class="flex-align gap-16">
                                <input type="text" class="common-input p-10" placeholder="Nhập mã giảm giá...">
                            </div>  
                            <a href="checkout.html" class="btn btn-main mt-20 py-14 w-100 rounded-8">Áp dụng</a>
                        </div>
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-24 py-20 mt-20">
                            <h6 class="text-xl mb-32">Thông tin giỏ hàng</h6>
                            <div class="bg-color-three rounded-8 p-24">
                                <div class="mb-32 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two">Tạm tính:</span>
                                    <span class="text-gray-900 fw-semibold">612.000 đ</span>
                                </div>
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two">Giảm giá:</span>
                                    <span class="text-gray-900 fw-semibold">
                                        <div class="flex-align text-sm text-main-two-600">
                                            <i class="ph-fill ph-seal-percent text-md"></i> -10%
                                            </div>
                                        - 61.200 đ
                                    </span>
                                </div>
                            </div>  
                            <div class="bg-color-three rounded-8 p-24 mt-24">
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 text-xl fw-semibold">Tổng:</span>
                                    <span class="text-gray-900 text-xl fw-semibold">550.800 đ</span>
                                </div>
                            </div>  
                            <a href="checkout.html" class="btn btn-main mt-20 py-14 w-100 rounded-8">Tiến hành thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection