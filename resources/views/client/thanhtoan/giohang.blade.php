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
                            <form action="" method="post" class="">
                                <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                    <table class="table style-three">
                                        <thead>
                                            <tr class="border-bottom border-gray-500 my-10 py-10">
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-24" colspan="2">
                                                    <div>
                                                        <i class="ph-bold ph-shopping-cart text-main-600 text-lg pe-6"></i> Giỏ hàng ( 1 sản phẩm )
                                                    </div>
                                                </th>
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Số lượng</th>
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td class="py-20 px-5">
                                                        <div class="d-flex align-items-center gap-12">
                                                            <form action="" method="post">
                                                                <button type="submit" class="flex-align gap-8 hover-text-danger-600 pe-10">
                                                                    <i class="ph ph-trash text-2xl d-flex"></i>
                                                                    Xóa
                                                                </button>
                                                            </form>
                                                            <a href="" class="border border-gray-100 rounded-8 flex-center" style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                                                                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp" alt="" class="w-100 rounded-8">
                                                            </a>
                                                            <div class="table-product__content text-start">
                                                                <div class="flex-align gap-16">
                                                                    <div class="flex-align gap-4 mb-5">
                                                                        <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                                        <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;" title="CHẤT VIỆT GROUP">CHẤT VIỆT GROUP</span>
                                                                    </div>
                                                                </div>
                                                                <h6 class="title text-lg fw-semibold mb-0">
                                                                    <a href="#" class="link text-line-2" title="Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo</a>
                                                                </h6>
                                                                <div class="flex-align gap-16 mb-6">
                                                                    <a href="#" class="btn bg-gray-50 text-heading text-sm py-6 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                                        Loại hộp vị sữa
                                                                    </a>
                                                                </div>
                                                                <div class="product-card__price mb-6">
                                                                        <div class="flex-align gap-4 text-main-two-600 text-sm">
                                                                            <i class="ph-fill ph-seal-percent text-sm"></i> -10% 
                                                                            <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">100.000 đ</span>
                                                                        </div>
                                                                    <span class="text-heading text-md fw-bold">100.000 đ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="item-id" value="1">
                                                    </td>
                                                    <td class="py-20 px-5">
                                                        <div class="d-flex rounded-4 overflow-hidden">
                                                            <button type="button" class="quantity__minus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                                <i class="ph ph-minus"></i>
                                                            </button>
                                                            <input type="number" name="soluong"  class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4" value="2" min="1">
                                                            <button type="button" class="quantity__plus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                                                                <i class="ph ph-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="py-20 px-5">
                                                        <span class="text-lg h6 mb-0 fw-semibold text-main-600">100.000 đ</span>
                                                    </td>
                                                </tr> 
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                                <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                    <table class="table style-three">
                                        <thead>
                                            <tr class="border-bottom border-gray-500 my-10 py-10">
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-6" colspan="2"><i class="ph-bold ph-gift text-main-600 text-lg"></i> Quà tặng nhận được ( 1 sản phẩm )</th>
                                                <th class="px-60"></th>
                                                <th class="px-60"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td class="py-20 px-5">
                                                    <div class="d-flex align-items-center gap-12">
                                                        <a href="" class="border border-gray-100 rounded-8 flex-center" style="max-width: 100px; max-height: 100px; width: 100%; height: 100%">
                                                            <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp" alt="" class="w-100 rounded-8">
                                                        </a>
                                                        <div class="table-product__content text-start">
                                                            <div class="flex-align gap-16">
                                                                <div class="flex-align gap-4 mb-5">
                                                                    <span class="text-main-two-600 text-sm d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                                    <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">CHẤT VIỆT GROUP</span>
                                                                </div>
                                                            </div>
                                                            <h6 class="title text-md fw-semibold mb-0">
                                                                <a href="#" class="link text-line-2 fw-medium" title="Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo</a>
                                                            </h6>
                                                            <div class="flex-align gap-16 mb-6">
                                                                <a href="#" class="btn bg-gray-50 text-heading text-xs py-6 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                    Loại thường (20 gói x 15g)
                                                                </a>
                                                            </div>
                                                            <div class="product-card__price mb-6">
                                                                <div class="flex-align gap-4 text-main-two-600 text-xs">
                                                                    <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through me-4">340.000 đ</span>
                                                                    <a href="#" class="flex-align gap-4 text-main-two-600 text-xs"><i class="ph-fill ph-seal-percent text-sm"></i> Quà tặng miễn phí</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-20 px-5">
                                                    <div class="d-flex rounded-4 overflow-hidden">
                                                        <input type="hidden" class="quantity__input flex-grow-1 border border-start-0 border-end-0 text-center w-32 px-4 py-4 bg-gray-100" value="1" min="1" name="soluong" readonly>
                                                        <input type="text" class="quantity__input flex-grow-1 border border-start-0 border-end-0 text-center w-32 px-4 py-8 bg-gray-100" value="x 1" min="1" readonly>
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
                                <form action="" method="post">
                                    <div class="flex-align gap-16">
                                        <input type="text" name="magiamgia" class="common-input p-10" placeholder="Nhập mã giảm giá..." value="">
                                    </div>
                                    <button type="submit" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-text-white mt-20 py-10 w-100 rounded-8" style="width: 100px;">
                                        Áp dụng
                                    </button>
                                    <div class="flex-align flex-between gap-8 mt-10 border-dashed border-gray-200 py-10 px-12 rounded-4">
                                        <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                            <i class="ph-bold ph-ticket text-main-600 text-2xl"></i>
                                            <div class="text-sm d-flex flex-column">
                                                <span class="text-sm text-gray-900 w-100">Giảm 50k</span>
                                                <span class="text-xs text-gray-500 w-100">SIEUTHIVINA2025</span>
                                            </div>
                                        </span>
                                        <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                            <input type="radio" name="" id="check" class="d-none">
                                            <label for="check" class="bg-main-600 hover-bg-main-100 text-white hover-text-main-600 p-6 rounded-4">Chọn</label>
                                        </span>
                                    </div>
                                    <div class="flex-align flex-between gap-8 mt-10 border-dashed border-gray-200 py-10 px-12 rounded-4">
                                        <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                            <i class="ph-bold ph-ticket text-main-600 text-2xl"></i>
                                            <div class="text-sm d-flex flex-column">
                                                <span class="text-sm text-gray-900 w-100">Giảm 50k</span>
                                                <span class="text-xs text-gray-500 w-100">THANHVIENMOI</span>
                                            </div>
                                        </span>
                                        <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                            <input type="radio" name="" id="check" class="d-none">
                                            <label for="check" class="bg-main-600 hover-bg-main-100 text-white hover-text-main-600 p-6 rounded-4">Chọn</label>
                                        </span>
                                    </div>
                                </form>
                        </div>
                        <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 mt-20">
                            <div class="mb-20">
                                <h6 class="text-lg mb-6 flex-align gap-4"><i class="ph-bold ph-shopping-cart text-main-600 text-xl"></i>Thông tin giỏ hàng</h6>    
                                <a href="#" class="text-sm text-gray-600 flex-align gap-1 fw-medium" style="cursor:pointer;">1 sản phẩm + 1 quà tặng</a>
                            </div>
                                <div class="mb-20 flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two">Tạm tính:</span>
                                    <span class="text-gray-900 fw-semibold">700.000 đ</span>
                                </div>
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 font-heading-two">Giảm giá:</span>
                                        <span class="text-success-600 fw-semibold"> - 200.000 đ</span>
                                </div>
                            <div class="border-top border-gray-100 my-20 pt-24">
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 text-lg fw-semibold">Tổng giá trị:</span>
                                    <span class="text-main-600 text-lg fw-semibold">
                                        500.000 đ
                                    </span>
                                </div>
                                <div class="text-end gap-8">
                                        <span class="text-success-600 text-sm fw-normal">Tiết kiệm:</span>
                                        <span class="text-success-600 text-sm fw-normal">
                                            200.000 đ
                                        </span>
                                </div>
                            </div>  
                            <a href="#" class="btn btn-main py-14 w-100 rounded-8">Tiến hành thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection