@extends('client.layouts.app')

@section('title')
    Thêm địa chỉ giao hàng | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
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
                            <h6 class="mb-0 text-gray-900">Thêm địa chỉ giao hàng</h6>
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
                            <form action="{{ route('luu-dia-chi') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-24">
                                        <label for="hoten" class="text-neutral-900 text-md mb-8 fw-medium">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="placeholder-italic py-12 px-18 text-sm common-input"
                                            id="hoten" name="hoten"
                                            placeholder="Nhập họ và tên"
                                            value="{{ old('hoten') }}">

                                            <div class="text-danger text-sm mt-4">Lỗi</div>
                                    </div>
                                    <div class="col-md-6 mb-24">
                                        <label for="sodienthoai" class="text-neutral-900 text-md mb-8 fw-medium">Số điện thoại<span class="text-danger">*</span></label>
                                        <input type="tel" class="placeholder-italic py-12 px-18 text-sm common-input"
                                            id="sodienthoai" name="sodienthoai"
                                            placeholder="Nhập số điện thoại"
                                            value="{{ old('sodienthoai') }}">

                                            <div class="text-danger text-sm mt-4">Lỗi</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-24">
                                        <label for="diachi" class="text-neutral-900 text-md mb-8 fw-medium">Địa chỉ <span class="text-danger">*</span></label>
                                        <input type="text" class="placeholder-italic py-12 px-18 text-sm common-input"
                                            id="diachi" name="diachi"
                                            placeholder="Nhập địa chỉ giao hàng"
                                            value="{{ old('diachi') }}">

                                            <div class="text-danger text-sm mt-4">Lỗi</div>
                                    </div>
                                    <div class="col-md-6 mb-24">
                                        <label for="hoten" class="text-neutral-900 text-md mb-8 fw-medium">Tỉnh thành <span class="text-danger">*</span></label>
                                        <select class="placeholder-italic common-input py-11 px-14 text-sm" id="tinhthanh" name="tinhthanh">
                                            <option disabled selected>-- Chọn tỉnh thành --</option>
                                            @foreach ($tinhThanhs as $tinh)
                                                <option value="{{ $tinh['name'] }}" {{ old('tinhthanh') == $tinh['name'] ? 'selected' : '' }}>{{ $tinh['name'] }}</option>
                                            @endforeach
                                        </select>
                                        
                                        <div class="text-danger text-sm mt-4">Lỗi</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-24">
                                        <div class="form-check common-check">
                                            <input class="form-check-input" type="checkbox" id="default" name="trangthai" value="Mặc định" {{ old('trangthai') ? 'checked' : '' }}>
                                            <label class="form-check-label flex-grow-1" for="default">Đặt địa chỉ làm mặc định <span class="fst-italic text-xs text-gray-600 fw-normal">(Địa chỉ sẽ được đặt mặc định cho việc thanh toán và giao hàng của bạn)</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-24">
                                        <button type="submit" class="btn btn-main py-14 px-40">Thêm địa chỉ mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection