@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        
        <div class="breadcrumb mb-0 pt-40 bg-main-two-60">
            <div class="container container-lg">
                <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                    <h6 class="mb-0">{{ $title }}</h6>
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
        <section class="shop py-40 pb-0 fix-scale-100">
                <div class="container container-lg">
                    <div class="row">
                        <div class="col-lg-3">
                            <form class="shop-sidebar" action="{{ route('danhsachsanpham') }}" method="get">
                                {{-- @csrf --}}
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
                                                <input class="form-check-input" type="radio" name="danhmuc" id="danhmuc-{{ $danhmuc->id }}" value="{{ $danhmuc->slug }}" onchange="this.form.submit()" {{ (request('danhmuc') == $danhmuc->slug) ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" name="locgia" value="low100" id="low100" onchange="this.form.submit()" 
                                                    {{ request('locgia') == 'low100' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="low100">Dưới 100.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="locgia" value="to200" id="100-200" onchange="this.form.submit()"
                                                    {{ request('locgia') == 'to200' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="100-200">100.000đ - 200.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="locgia" value="to300" id="200-300" onchange="this.form.submit()"
                                                    {{ request('locgia') == 'to300' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="200-300">200.000đ - 300.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="locgia" value="to500" id="300-500" onchange="this.form.submit()"
                                                    {{ request('locgia') == 'to500' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="300-500">300.000đ - 500.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="locgia" value="to700" id="500-700" onchange="this.form.submit()"
                                                    {{ request('locgia') == 'to700' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="500-700">500.000đ - 700.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="locgia" value="to1000" id="700-1000" onchange="this.form.submit()"
                                                    {{ request('locgia') == 'to1000' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="700-1000">700.000đ - 1.000.000đ</label>
                                            </div>
                                        </li>
                                        <li class="mb-24">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="locgia" value="high1000" id="high1000" onchange="this.form.submit()"
                                                    {{ request('locgia') == 'high1000' ? 'checked' : '' }}>
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
                                                    <input class="form-check-input" type="radio" name="thuonghieu" id="thuonghieu{{ $thuonghieu->id }}" value="{{ $thuonghieu->slug }}" onchange="this.form.submit()" {{ (request('thuonghieu') == $thuonghieu->slug) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="thuonghieu{{ $thuonghieu->id }}">{{ $thuonghieu->ten }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="shop-sidebar__box rounded-8 flex-align justify-content-between mb-32">
                                    <a href="{{ route('danhsachsanpham') }}"- class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 w-100">
                                        Xóa bộ lọc
                                    </a>
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
                                    <div class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                                    <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="flex-center rounded-8 bg-gray-50 position-relative">
                                        <img src="{{ asset('assets/client') }}/images/thumbs/{{ $product->hinhanhsanpham->first()->hinhanh }}" alt="{{ $product->ten }}" class="w-100 rounded-top-2">
                                    </a>
                                    <div class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                                        <div>
                                        <h6 class="title text-lg fw-semibold mt-2 mb-2">
                                        <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2" tabindex="0">{{ $product->ten }}</a>
                                        </h6>
                                        <div class="flex-align justify-content-between mt-10">
                                            <div class="flex-align gap-6">
                                            <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                                            <span class="text-xs fw-medium text-gray-500">4.8 
                                                <i class="ph-fill ph-star text-warning-600"></i></span>
                                            </div>
                                            <div class="flex-align gap-4">
                                            <span class="text-xs fw-medium text-gray-500">{{ $product->bienthe_sum_luotban }}</span>
                                            <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                                            </div>
                                        </div>
                                        </div>
                                        
                                        <div class="product-card__price mt-5">
                                            @if ($product->giamgia > 0)
                                                <div class="flex-align gap-4 text-main-two-600">
                                                    <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $product->giamgia }}% 
                                                    <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                                                        {{ number_format($product->bienthe->giagoc, 0, ',', '.') }} đ
                                                    </span>
                                                </div>
                                            @endif
                                        <span class="text-heading text-lg fw-semibold">
                                            {{ number_format($product->giadagiam, 0, ',', '.') }} đ
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
                                <li class="page-item @if ($products->onFirstPage()) d-none @endif">
                                    <a class="page-link h-64 w-64 flex-center text-xxl rounded-8 fw-medium text-neutral-600 border border-gray-100"
                                        href="{{ $products->withQueryString()->previousPageUrl() }}">
                                        <i class="ph-bold ph-arrow-left"></i>
                                    </a>
                                </li>

                                @foreach ($products->withQueryString()->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active">
                                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-white border-red-600 bg-red-600"
                                                href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link h-64 w-64 flex-center text-md rounded-8 fw-medium text-neutral-600 border border-gray-100 hover:bg-gray-100"
                                                href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                                
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
        
            
       
        


    </div>
@endsection