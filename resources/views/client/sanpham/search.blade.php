@extends('client.layouts.app')

@section('title')
    Tìm kiếm: {{ $keyword }} | Sàn thương mại điện tử bán hàng trực tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        @if($results_count > 0)
        <div class="breadcrumb mb-0 pt-40 bg-main-two-60">
            <div class="container container-lg">
                <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                    <h6 class="mb-0">Tìm kiếm: "{{$keyword}}"</h6>
                    {{-- <ul class="flex-align gap-8 flex-wrap">
                        <li class="text-sm">
                            <a href="index.html" class="text-gray-900 flex-align gap-8 hover-text-main-600">
                                <i class="ph ph-house"></i>
                                Hiển thị tổng số {{$results_count}} kết quả
                            </a>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </div>
        <section class="shop py-40">
                <div class="container container-lg">
                    <div class="row">
                        <div class="col-lg-3">
                            <form class="shop-sidebar" action="" method="post">
                                @csrf
                                <button type="button"
                                    class="shop-sidebar__close d-lg-none d-flex w-32 h-32 flex-center border border-gray-100 rounded-circle hover-bg-main-600 position-absolute inset-inline-end-0 me-10 mt-8 hover-text-white hover-border-main-600">
                                    <i class="ph ph-x"></i>
                                </button>
                                <div class="shop-sidebar__box border border-gray-100 rounded-8 p-26 pb-0 mb-32">
                                    <h6 class="text-xl border-bottom border-gray-100 pb-16 mb-16">Danh mục sản phẩm</h6>
                                    <ul class="max-h-540 overflow-y-auto scroll-sm">
                                        @foreach($danhsachdanhmuc as $danhmuc)
                                        <li class="mb-20">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="danhmuc[]" id="danhmuc-{{ $danhmuc->id }}" value="{{ $danhmuc->id }}">
                                                <label class="form-check-label" for="danhmuc-{{ $danhmuc->id }}">{{ $danhmuc->ten }} ({{ $danhmuc->sanpham_count }})</label>
                                            </div>         
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="shop-sidebar__box border border-gray-100 rounded-8 p-26 pb-0 mb-32">
                                    <h6 class="text-xl border-bottom border-gray-100 pb-16 mb-24">Lọc theo giá tiền</h6>
                                    <ul class="max-h-540 overflow-y-auto scroll-sm">
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="low100" id="low100">
                                                <label class="form-check-label" for="low100">Dưới 100.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="to200" id="100-200">
                                                <label class="form-check-label" for="100-200">100.000đ - 200.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="to300" id="200-300">
                                                <label class="form-check-label" for="200-300">200.000đ - 300.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="to500" id="300-500">
                                                <label class="form-check-label" for="300-500">300.000đ - 500.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="to700" id="500-700">
                                                <label class="form-check-label" for="500-700">500.000đ - 700.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="to1000" id="700-1000">
                                                <label class="form-check-label" for="700-1000">700.000đ - 1.000.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="high1000" id="high1000">
                                                <label class="form-check-label" for="high1000">Trên 1.000.000đ</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="shop-sidebar__box border border-gray-100 rounded-8 p-26 pb-0 mb-32">
                                    <h6 class="text-xl border-bottom border-gray-100 pb-16 mb-24">Lọc theo thương hiệu</h6>
                                    <ul class="max-h-540 overflow-y-auto scroll-sm">
                                        @foreach ($danhsachthuonghieu as $thuonghieu)
                                            <li class="mb-16">
                                                <div class="form-check common-check common-radio">
                                                    <input class="form-check-input" type="radio" name="color" id="thuonghieu{{ $thuonghieu->id }}">
                                                    <label class="form-check-label" for="thuonghieu{{ $thuonghieu->id }}">{{ $thuonghieu->ten }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="shop-sidebar__box rounded-8 flex-align justify-content-between mb-32">
                                    <button title="Lọc sản phẩm trong bộ lọc của bạn" type="submit" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 w-100">
                                        Lọc sản phẩm
                                    </button>
                                </div>
                                <div class="shop-sidebar__box rounded-8">
                                    <a href="{{ $bannerquangcao->first()->lienket }}">
                                        <img class="rounded-8 w-100" src="{{ asset('assets/client') }}/images/bg/{{ $bannerquangcao->first()->hinhanh }}" alt="">
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- Sidebar End -->

                        <!-- Content Start -->
                        <div class="col-lg-9">
                            <!-- Top Start -->
                            <div class="flex-between gap-16 flex-wrap mb-40 ">
                                <span class="text-gray-900">Hiển thị {{ $products->count() }} trên {{ $results_count }} kết quả</span>
                                <div class="position-relative flex-align gap-16 flex-wrap">
                                    <button type="button" class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn">
                                        <i class="ph-bold ph-funnel"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Top End -->

                            <div class="row g-12">
                                @foreach ($products as $product)
                                <div class="col-xxl-3 col-xl-3 col-lg-4 col-xs-6">
                                    <div class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                                        <a href="product-details.html" class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                                            <img src="assets/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset">
                                            <span class="product-card__badge bg-primary-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Best
                                                Sale
                                            </span>
                                        </a>
                                        <div class="product-card__content mt-16">
                                            <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                                <a href="product-details.html" class="link text-line-2" tabindex="0">Taylor Farms
                                                    Broccoli Florets Vegetables</a>
                                            </h6>
                                            <div class="flex-align mb-20 mt-16 gap-6">
                                                <span class="text-xs fw-medium text-gray-500">4.8</span>
                                                <span class="text-xs fw-medium text-warning-600 d-flex">
                                                    <i class="ph-fill ph-star"></i>
                                                </span>
                                                <span class="text-xs fw-medium text-gray-500">(17k)</span>
                                            </div>
                                            <div class="mt-8">
                                                <div class="progress w-100 bg-color-three rounded-pill h-4" role="progressbar" aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-main-two-600 rounded-pill" style="width: 35%"></div>
                                                </div>
                                                <span class="text-gray-900 text-xs fw-medium mt-8">Sold: 18/35</span>
                                            </div>

                                            <div class="product-card__price my-20">
                                                <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                                    $28.99</span>
                                                <span class="text-heading text-md fw-semibold ">$14.99 
                                                    <span class="text-gray-500 fw-normal">/Qty</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                @endforeach
                                
                                
                            </div>

                            <!-- Pagination Start -->
                           @if ($products->lastPage() > 1)
                            <ul class="pagination flex-center flex-wrap gap-16">
                                
                                <!-- Nút Quay lại (Previous) -->
                                <li class="page-item @if ($products->onFirstPage()) d-none @endif">
                                    <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                        href="{{ $products->withQueryString()->previousPageUrl() }}">
                                        <i class="ph-bold ph-arrow-left"></i>
                                    </a>
                                </li>
                                
                                <!-- Vòng lặp các số trang và dấu ba chấm -->
                                @foreach ($products->withQueryString()->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        {{-- Trang hiện tại --}}
                                        <li class="page-item active">
                                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-white border-red-600 bg-red-600"
                                                href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @else
                                        {{-- Các trang khác --}}
                                        <li class="page-item">
                                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100 hover:bg-gray-100"
                                                href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                                
                                <!-- Nút Kế tiếp (Next) -->
                                <li class="page-item @if (!$products->hasMorePages()) d-none @endif">
                                    <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                        href="{{ $products->withQueryString()->nextPageUrl() }}">
                                        <i class="ph-bold ph-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        @endif
                            <!-- Pagination End -->
                        </div>
                        <!-- Content End -->

                    </div>
                </div>
            </section>
        @else
            <div class="breadcrumb mb-0 py-60 bg-main-two-60">
            <div class="container container-lg">
                <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                    <h6 class="mb-0">Không có kết quả cho "{{$keyword}}"</h6>
                    {{-- <ul class="flex-align gap-8 flex-wrap">
                        <li class="text-sm">
                            <a href="index.html" class="text-gray-900 flex-align gap-8 hover-text-main-600">
                                <i class="ph ph-house"></i>
                                Hiển thị tổng số {{$results_count}} kết quả
                            </a>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </div>
        @endif
        


    </div>
@endsection