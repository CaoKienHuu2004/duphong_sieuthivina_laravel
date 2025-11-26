@extends('client.layouts.app')

@section('title')
    Thông báo của tôi | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
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
                                    <a href="{{ route('tai-khoan') }}"
                                        class="px-16 py-8 bg-gray-50 rounded-8 flex-between gap-12 mb-0"
                                        style="justify-content: start;">
                                        <span
                                            class="bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0"
                                            style="width: 45px; height: 45px;">
                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ Auth::user()->avatar }}"
                                                alt="{{ Auth::user()->username }}"
                                                class="w-100 h-100 object-fit-cover rounded-circle">
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
                                            <a href="{{ route('tai-khoan') }}"
                                                class="{{ Route::is('tai-khoan') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} px-16 py-8 hover-bg-main-50 hover-text-main-600 rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-user"></i> Thông tin cá nhân</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="mb-6">
                                        <div class="">
                                            <a href="{{ route('trang-chu') }}"
                                                class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-bell-simple-ringing"></i> Thông báo <span
                                                        class="badge bg-main-600 px-6 py-4">!</span></span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="mb-6">
                                        <div class="">
                                            <a href="{{ route('don-hang-cua-toi') }}"
                                                class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('don-hang-cua-toi') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-notepad"></i> Đơn hàng của tôi </span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="mb-6">
                                        <div class="">
                                            <a href="{{ route('so-dia-chi') }}"
                                                class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('so-dia-chi') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-map-pin-area"></i> Sổ địa chỉ</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="mb-6">
                                        <div class="">
                                            <a href="{{ route('trang-chu') }}"
                                                class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-chat-centered-dots"></i> Đánh giá sản phẩm</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="mb-6">
                                        <div class="">
                                            <a href="{{ route('trang-chu') }}"
                                                class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-heart"></i> Sản phẩm yêu thích <span
                                                        class="badge bg-success-600 px-6 py-4">6</span></span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="mb-20">
                                        <div class="">
                                            <a href="{{ route('trang-chu') }}"
                                                class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0"
                                                style="justify-content: start;">
                                                <span class="fw-medium text-md flex-align gap-12"><i
                                                        class="ph-bold ph-headset"></i> Hỗ trợ khách hàng</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>


                            <form action="{{ route('dang-xuat') }}" method="post"
                                class="shop-sidebar__box rounded-8 flex-align justify-content-between mb-32">
                                @csrf
                                <button title="Đăng xuất" type="submit"
                                    class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 w-100 flex-center gap-8">
                                    <i class="ph-bold ph-sign-out"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Sidebar End -->

                    <!-- Content Start -->
                    <div class="col-lg-9">
                        <div class="flex-between gap-16 flex-wrap mb-20 ">
                            <h6 class="mb-0 text-gray-900 flex-align gap-12"><i
                                    class="ph-bold ph-bell-simple-ringing text-main-600"></i>Thông báo của tôi</h6>
                            <div class="position-relative flex-align gap-16 flex-wrap">
                                <button type="button"
                                    class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn">
                                    <i class="ph-bold ph-folder-user"></i>
                                </button>
                            </div>
                        </div>
                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <div class="border border-gray-100 rounded-8 p-16">
                            <div class=" py-10 flex-between flex-align mb-20">
                                <ul class="nav common-tab style-two nav-pills wow fadeInRight m-0" id="pills-tab"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 active"
                                            id="tab-7" data-bs-toggle="pill" data-bs-target="#content-7" type="button"
                                            role="tab" aria-controls="content-7" aria-selected="false">
                                            <i class="ph-bold ph-notepad text-lg"></i> Đơn hàng
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 "
                                            id="tab-1" data-bs-toggle="pill" data-bs-target="#content-1" type="button"
                                            role="tab" aria-controls="content-1" aria-selected="true">
                                            <i class="ph-bold ph-ticket text-lg"></i>Khuyến mãi
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 "
                                            id="tab-11" data-bs-toggle="pill" data-bs-target="#content-11" type="button"
                                            role="tab" aria-controls="content-11" aria-selected="false">
                                            <i class="ph-bold ph-gift text-lg"></i>Quà tặng
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 "
                                            id="tab-6" data-bs-toggle="pill" data-bs-target="#content-6" type="button"
                                            role="tab" aria-controls="content-6" aria-selected="false">
                                            <i class="ph-bold ph-gear text-lg"></i>Hệ thống
                                        </button>
                                    </li>
                                </ul>
                                <a href="#"
                                    class="text-white hover-bg-main-800 text-sm bg-main-600 px-10 py-6 rounded-8 flex-align gap-12"><i
                                        class="ph-bold ph-check"></i>Đánh dấu tất cả là đã đọc</a>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="content-7" role="tabpanel"
                                    aria-labelledby="tab-7" tabindex="0">
                                    <div
                                        class="border border-gray-100 bg-gray-50 box-shadow-sm text-main-900 rounded-4 px-20 py-16 mb-10 flex-align gap-8">
                                        <i class="ph-bold ph-notepad text-main-600 text-4xl"></i>
                                        <div class="w-100">
                                            <div class="flex-align flex-between gap-12">
                                                <span class="text-gray-900 text-lg fw-medium flex-align gap-8">Đơn hàng của
                                                    bạn đã
                                                    bị hủy !</span>
                                                <a href=""
                                                    class="border border-main-600 text-main-600 hover-text-white hover-bg-main-600 px-8 py-4 rounded-4 text-sm">Xem
                                                    chi tiết</a>
                                            </div>
                                            <div class="flex-align gap-12">
                                                <span class="text-gray-900 text-md fw-normal">Mã đơn STV25112631 của bạn đã
                                                    bị hủy,
                                                    vui lòng xem chi tiết.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="border border-gray-100 box-shadow-sm text-main-900 rounded-4 px-20 py-16 mb-10 flex-align gap-8">
                                        <i class="ph-bold ph-notepad text-main-600 text-4xl"></i>
                                        <div class="w-100">
                                            <div class="flex-align flex-between gap-12">
                                                <span class="text-gray-900 text-lg fw-medium flex-align gap-8">Đơn hàng của
                                                    bạn đã
                                                    bị hủy !</span>
                                                <a href="#"
                                                    class="border border-main-600 text-main-600 hover-text-white hover-bg-main-600 px-8 py-4 rounded-4 text-sm">Xem
                                                    chi tiết</a>
                                            </div>
                                            <div class="flex-align gap-12">
                                                <span class="text-gray-900 text-md fw-normal">Mã đơn STV25112631 của bạn đã
                                                    bị hủy,
                                                    vui lòng xem chi tiết.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="content-1" role="tabpanel" aria-labelledby="tab-1"
                                    tabindex="0">
                                    <div
                                        class="border border-gray-100 bg-gray-50 box-shadow-sm text-main-900 rounded-4 px-20 py-16 mb-10 flex-align gap-8">
                                        <i class="ph-bold ph-ticket text-main-600 text-4xl"></i>
                                        <div class="w-100">
                                            <div class="flex-align flex-between gap-12">
                                                <span class="text-gray-900 text-lg fw-medium flex-align gap-8">Ưu đãi khuyến mãi, mua càng nhiều - lời càng to</span>
                                                <a href=""
                                                    class="border border-main-600 text-main-600 hover-text-white hover-bg-main-600 px-8 py-4 rounded-4 text-sm">Xem
                                                    chi tiết</a>
                                            </div>
                                            <div class="flex-align gap-12">
                                                <span class="text-gray-800 text-md fw-normal">Ưu đãi voucher khi mua tối thiểu 2.000.000đ được giảm giá 200.000đ, thêm vào giỏ hàng ngay</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="border border-gray-100 box-shadow-sm text-main-900 rounded-4 px-20 py-16 mb-10 flex-align gap-8">
                                        <i class="ph-bold ph-notepad text-main-600 text-4xl"></i>
                                        <div class="w-100">
                                            <div class="flex-align flex-between gap-12">
                                                <span class="text-gray-900 text-lg fw-medium flex-align gap-8">Đơn hàng của
                                                    bạn đã
                                                    bị hủy !</span>
                                                <a href="#"
                                                    class="border border-main-600 text-main-600 hover-text-white hover-bg-main-600 px-8 py-4 rounded-4 text-sm">Xem
                                                    chi tiết</a>
                                            </div>
                                            <div class="flex-align gap-12">
                                                <span class="text-gray-900 text-md fw-normal">Mã đơn STV25112631 của bạn đã
                                                    bị hủy,
                                                    vui lòng xem chi tiết.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="content-11" role="tabpanel" aria-labelledby="tab-11"
                                    tabindex="0">

                                </div>

                                <div class="tab-pane fade " id="content-6" role="tabpanel" aria-labelledby="tab-6"
                                    tabindex="0">

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection