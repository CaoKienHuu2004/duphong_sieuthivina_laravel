@extends('client.layouts.app')

@section('title')
    Đơn hàng của tôi | Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="shop py-40">
                <div class="container container-lg">
                    <div class="row">
                        <div class="col-lg-3">
                        <div class="shop-sidebar">
                                <button type="button"
                                    class="shop-sidebar__close d-lg-none d-flex w-32 h-32 flex-center border border-gray-100 rounded-circle hover-bg-main-600 position-absolute inset-inline-end-0 me-10 mt-8 hover-text-white hover-border-main-600">
                                    <i class="ph ph-x"></i>
                                </button>
                                <div class="shop-sidebar__box border border-gray-100 rounded-8 p-16 pb-0 mb-20">
                                    <div class="border-bottom border-gray-100 pb-16 mb-16">
                                        <a href="http://127.0.0.1:8000/san-pham?thuonghieu=chat-viet-group" class="px-16 py-8 bg-gray-50 rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                            <span class="bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0" style="width: 45px; height: 45px;">
                                                <img src="{{ asset('assets/client') }}/images/thumbs/{{ Auth::user()->avatar }}" alt="{{ Auth::user()->username }}" class="w-100 rounded-circle">
                                            </span>
                                            <div class="flex-column d-flex">
                                                <span class="text-xs text-neutral-600">
                                                    <span class="fw-medium">{{ Auth::user()->username }}</span> 
                                                </span>
                                                <span class="text-md text-neutral-600">
                                                    <span class="fw-semibold">{{ Auth::user()->hoten }}</span> 
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    <ul class="max-h-540 overflow-y-auto scroll-sm">
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('tai-khoan') }}" class="{{ Route::is('tai-khoan') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} px-16 py-8 hover-bg-main-50 hover-text-main-600 rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-user"></i> Thông tin cá nhân</span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-bell-simple-ringing"></i> Thông báo <span class="badge bg-main-600 px-6 py-4">!</span></span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('don-hang-cua-toi') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('don-hang-cua-toi') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-notepad"></i> Đơn hàng của tôi </span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-map-pin-area"></i> Sổ địa chỉ</span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-chat-centered-dots"></i> Đánh giá sản phẩm</span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-heart"></i> Sản phẩm yêu thích <span class="badge bg-success-600 px-6 py-4">6</span></span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-20">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-headset"></i> Hỗ trợ khách hàng</span> 
                                                </a>
                                            </div>        
                                        </li>
                                    </ul>
                                </div>
                                
                                
                                <form action="{{ route('dang-xuat') }}" method="post" class="shop-sidebar__box rounded-8 flex-align justify-content-between mb-32">
                                    @csrf
                                    <button title="Đăng xuất" type="submit" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 w-100 flex-center gap-8">
                                       <i class="ph-bold ph-sign-out"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Sidebar End -->

                        <!-- Content Start -->
                        <div class="col-lg-9">
                            <!-- Top Start -->
                            <div class="flex-between gap-16 flex-wrap mb-20 ">
                                <h6 class="mb-0 text-gray-900">Đơn hàng của tôi</h6>
                                <div class="position-relative flex-align gap-16 flex-wrap">
                                    <button type="button" class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn">
                                        <i class="ph-bold ph-folder-user"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Top End -->

                            <div class="row g-12">
                                <section class="trending-productss overflow-hidden mt-10 fix-scale-80">
                                    <div class="border border-gray-100 p-24 rounded-8">
                                        <div class="section-heading mb-24">
                                        <div class="flex-between flex-align flex-wrap gap-8">
                                            <ul class="nav common-tab style-two nav-pills m-0" id="pills-tab" role="tablist" style="visibility: visible;">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 active" id="tab-7" data-bs-toggle="pill" data-bs-target="#content-7" type="button" role="tab" aria-controls="content-7" aria-selected="true">
                                                        <i class="ph-bold ph-clock-countdown"></i> Đang xác nhận
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600" id="tab-1" data-bs-toggle="pill" data-bs-target="#content-1" type="button" role="tab" aria-controls="content-1" aria-selected="false" tabindex="-1">
                                                        <i class="ph-bold ph-package"></i> Đang đóng gói
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 " id="tab-11" data-bs-toggle="pill" data-bs-target="#content-11" type="button" role="tab" aria-controls="content-11" aria-selected="false" tabindex="-1">
                                                        <i class="ph-bold ph-truck"></i>Đang giao hàng
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 " id="tab-6" data-bs-toggle="pill" data-bs-target="#content-6" type="button" role="tab" aria-controls="content-6" aria-selected="false" tabindex="-1">
                                                        <i class="ph-bold ph-check-fat"></i>Đã giao hàng
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 " id="tab-4" data-bs-toggle="pill" data-bs-target="#content-4" type="button" role="tab" aria-controls="content-4" aria-selected="false" tabindex="-1">
                                                        <i class="ph-bold ph-prohibit"></i>Đã hủy
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        </div>

                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade active show" id="content-7" role="tabpanel" aria-labelledby="tab-7" tabindex="0">
                                                
                                                <div class="border border-gray-200 p-14 rounded-4 my-10">
                                                    <div class="d-flex flex-align flex-between">
                                                        <div class="flex-align gap-12">
                                                            <span class="fw-semibold text-gray-900 text-md">Đơn hàng #STV2025110912341</span>
                                                        </div>
                                                        <div class="flex-align gap-12">
                                                            <span class="fw-medium text-xs text-gray-700 bg-gray-100 px-6 py-4 rounded-4 flex-align gap-8"><i class="ph-bold ph-clock-countdown"></i> Đang xác nhận</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-align flex-between mb-10">
                                                        <div class="flex-align gap-8">
                                                            <span class="fw-semibold text-sm text-gray-600">Đặt ngày 09/11/2025 - 12:24</span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="py-14 px-5">
                                                        <div class="d-flex align-items-center gap-12">
                                                            <a href="http://127.0.0.1:8000/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon" class="border border-gray-100 rounded-8 flex-center" style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                                                <img src="http://127.0.0.1:8000/assets/client/images/thumbs/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-1.webp" alt="Nước yến sào Nest100 lon 190ml - Hộp 5 lon" class="w-100 rounded-8">
                                                            </a>
                                                            <div class="table-product__content text-start">
                                                                <h6 class="title text-sm fw-semibold mb-0">
                                                                    <a href="http://127.0.0.1:8000/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon" class="link text-line-2" title="Nước yến sào Nest100 lon 190ml - Hộp 5 lon" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Nước yến sào Nest100 lon 190ml - Hộp 5 lon</a>
                                                                </h6>
                                                                <div class="flex-align gap-16 mb-6">
                                                                    <a href="http://127.0.0.1:8000/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon" class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                        Có đường (190ml/lon)
                                                                    </a>
                                                                </div>
                                                                <div class="product-card__price mb-6">
                                                                    <div class="flex-align gap-24">
                                                                        <span class="text-heading text-sm fw-medium ">Số lượng: 1</span>
                                                                        <span class="text-main-600 text-md fw-bold">51.000 ₫</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="item-id" value="30">
                                                    </div>
                                                    <div class="py-14 px-5">
                                                        <div class="d-flex align-items-center gap-12">
                                                            <a href="http://127.0.0.1:8000/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon" class="border border-gray-100 rounded-8 flex-center" style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                                                <img src="http://127.0.0.1:8000/assets/client/images/thumbs/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon-1.webp" alt="Nước yến sào Nest100 lon 190ml - Hộp 5 lon" class="w-100 rounded-8">
                                                            </a>
                                                            <div class="table-product__content text-start">
                                                                <h6 class="title text-sm fw-semibold mb-0">
                                                                    <a href="http://127.0.0.1:8000/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon" class="link text-line-2" title="Nước yến sào Nest100 lon 190ml - Hộp 5 lon" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Nước yến sào Nest100 lon 190ml - Hộp 5 lon</a>
                                                                </h6>
                                                                <div class="flex-align gap-16 mb-6">
                                                                    <a href="http://127.0.0.1:8000/san-pham/nuoc-yen-sao-nest100-lon-190ml-hop-5-lon" class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                        Có đường (190ml/lon)
                                                                    </a>
                                                                </div>
                                                                <div class="product-card__price mb-6">
                                                                    <div class="flex-align gap-24">
                                                                        <span class="text-heading text-sm fw-medium ">Số lượng: 1</span>
                                                                        <span class="text-main-600 text-md fw-bold">51.000 ₫</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" class="item-id" value="30">
                                                    </div>
                                                    <div class="d-flex flex-align flex-between">
                                                        <div class="flex-align gap-12">
                                                            <span class="fw-semibold text-sm text-gray-600"></span>
                                                        </div>
                                                        <div class="flex-align gap-12">
                                                            <span class="fw-medium text-sm">Tổng giá trị</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-align flex-between">
                                                        <div class="flex-align gap-12">
                                                            <span class="fw-semibold text-sm text-gray-600">
                                                                <div class="flex-align gap-12">
                                                                    <button class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8"><i class="ph-bold ph-trash"></i> Hủy đơn hàng</button>
                                                                    {{-- <div class="fw-medium text-main-400 text-sm border border-main-400 px-8 py-4 rounded-4 transition-1 flex-align gap-8"><i class="ph-bold ph-trash"></i> Hủy đơn hàng</div> --}}
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div class="flex-align gap-12">
                                                            <span class="fw-bold text-main-600 text-lg">220.000 đ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="tab-pane fade" id="content-1" role="tabpanel" aria-labelledby="tab-1" tabindex="0">
                                                    
                                            </div>
                                                
                                            <div class="tab-pane fade " id="content-11" role="tabpanel" aria-labelledby="tab-11" tabindex="0">
                                                
                                            </div>
                                                
                                            <div class="tab-pane fade " id="content-6" role="tabpanel" aria-labelledby="tab-6" tabindex="0">
                                                    
                                                    
                                            </div>
                                                
                                            <div class="tab-pane fade " id="content-4" role="tabpanel" aria-labelledby="tab-4" tabindex="0">
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
@endsection