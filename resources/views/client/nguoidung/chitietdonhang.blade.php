@extends('client.layouts.app')

@section('title')
    Mã đơn "{{ $donhang->madon }}" | Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
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
                                        <a href="{{ route('tai-khoan') }}" class="px-16 py-8 bg-gray-50 rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                            <span class="bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0" style="width: 45px; height: 45px;">
                                                <img src="{{ asset('assets/client') }}/images/thumbs/{{ Auth::user()->avatar }}" alt="{{ Auth::user()->username }}" class="w-100 h-100 object-fit-cover rounded-circle">
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
                                                <a href="{{ route('thong-bao') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('thong-bao') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
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
                                                <a href="{{ route('so-dia-chi') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('so-dia-chi') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
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
                            <div class="flex-between gap-16 flex-wrap">
                                <h6 class="mb-0 text-gray-900">Chi tiết đơn hàng</h6>
                                    <div class="position-relative flex-align gap-16 flex-wrap">
                                        <button type="button" class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn">
                                            <i class="ph-bold ph-folder-user"></i>
                                        </button>
                                </div>
                            </div>
                            <div class="flex-between gap-16 flex-wrap">
                                <h6 class="mb-20 text-gray-600 text-md fw-medium flex-align gap-12">Mã đơn: #{{ $donhang->madon }} 
                                    <span class="
                                    @if($donhang->trangthai == 'Đã giao hàng') bg-success-200 text-success-900 @elseif($donhang->trangthai == 'Chờ xác nhận') bg-warning-200 text-warning-900 @elseif($donhang->trangthai == 'Đang giao hàng') bg-info-200 text-info-900 @elseif($donhang->trangthai == 'Đã hủy đơn') bg-danger-200 text-danger-900 @else bg-info-200 text-info-900 @endif p-4 fw-semibold text-sm rounded-4" data-c-tooltop="{{ $donhang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">{{ $donhang->trangthai }}</span>
                                </h6>
                                <div class="flex-align gap-8 mb-20">
                                    <i class="ph-bold ph-clock-countdown text-gray-600 text-md"></i>
                                    <span class="text-gray-600 text-sm fw-normal"><span class="fw-medium">Ngày đặt hàng:</span> {{ $donhang->created_at->format('d/m/Y - H:i') }}</span>
                                </div>
                            </div>
                            
                            @if (session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session()->has('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-lg-4 d-flex flex-column gap-5 p-0 px-6">
                                    <span class="text-lg fw-semibold text-gray-900">Địa chỉ người nhận</span>
                                    <div class="border border-gray-300 rounded-4 py-10 px-10 h-100">
                                        <div class="text-sm fw-semibold text-gray-900">{{ $donhang->nguoinhan }}</div>
                                        <div class="text-sm text-gray-800 mt-5"><span class="fw-medium">Địa chỉ:</span> {{ $donhang->diachinhan }}, {{ $donhang->khuvucgiao }}</div>
                                        <div class="text-sm text-gray-800 mt-5"><span class="fw-medium">Số điện thoại:</span> {{ $donhang->sodienthoai }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex flex-column gap-5 p-0 px-6">
                                    <span class="text-lg fw-semibold text-gray-900">Hình thức vận chuyển</span>
                                    <div class="border border-gray-300 rounded-4 py-10 px-10 h-100">
                                        <div class="text-sm fw-semibold text-gray-900">Giao hàng {{ $donhang->hinhthucvanchuyen }}</div>
                                        <div class="text-sm text-gray-800 mt-5"><span class="fw-medium">Phí vận chuyển:</span> <span class="fst-italic">{{ number_format($donhang->phigiaohang,0,',','.') }} đ</span></div>
                                        <div class="text-sm text-gray-800 mt-5"><span class="fw-medium">Khu vực giao:</span> <span class="fst-italic">{{ $donhang->khuvucgiao }}</span></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex flex-column gap-5 p-0 px-6">
                                    <span class="text-lg fw-semibold text-gray-900">Hình thức thanh toán</span>
                                    <div class="border border-gray-300 rounded-4 py-10 px-10 h-100">
                                        <div class="text-sm fw-semibold text-gray-900">{{ $donhang->hinhthucthanhtoan }}</div>
                                        <div class="text-sm text-gray-800 mt-5"><span class="fw-medium">Trạng thái:</span> <span class="fst-italic @if($donhang->trangthaithanhtoan == 'Chờ thanh toán') text-warning-600 @elseif($donhang->trangthaithanhtoan == 'Đã thanh toán') text-success-600 @elseif($donhang->trangthaithanhtoan == 'Hủy thanh toán') text-main-600 @else text-info-600 @endif">{{ $donhang->trangthaithanhtoan }}</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-12 p-0 px-6">
                                    <div class="border border-gray-300 rounded-4 p-16">
                                        <span class="text-lg text-gray-900 fw-semibold flex-align gap-8 mb-10"><i class="ph-bold ph-shopping-cart text-main-600 text-lg"></i> Chi tiết mua hàng</span>
                                        @foreach ($donhang->chitietdonhang as $chitiet)
                                            <div class="py-6 px-5">
                                                @if($chitiet->dongia == 0)<span class="flex-align mt-10 mb-4 text-gray-900 text-md fw-medium"><i class="ph-bold ph-gift text-main-600 text-lg pe-4"></i>Quà tặng của bạn</span>@endif
                                                <div class="d-flex align-items-center gap-12">
                                                    <a href="#" class="border border-gray-100 rounded-8 flex-center" style="max-width: 90px; max-height: 90px; width: 100%; height: 100%">
                                                        <img src="{{ asset('assets/client') }}/images/thumbs/{{ $chitiet->bienthe->sanpham->hinhanhsanpham->first()->hinhanh }}" alt="{{ $chitiet->tensanpham }}" class="w-100 rounded-8">
                                                    </a>
                                                    <div class="text-start w-100">
                                                        <h6 class="title text-md fw-semibold mb-0">
                                                            <a href="#" class="link text-line-2" title="{{ $chitiet->tensanpham }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $chitiet->tensanpham }}</a>
                                                        </h6>
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="#" class="btn bg-gray-50 text-heading text-sm py-4 px-6 rounded-8 flex-center gap-8 fw-normal">
                                                                {{ $chitiet->tenbienthe }}
                                                            </a>
                                                        </div>
                                                        <div class="product-card__price mb-6">
                                                            <div class="flex-align flex-between gap-24">
                                                                <span class="text-heading text-md fw-medium ">Số lượng:{{ $chitiet->soluong }}</span>
                                                                <span class="text-gray-600 text-md fw-semibold">{{ number_format($chitiet->dongia,0,',','.') }} ₫</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="item-id" value="30">
                                            </div>
                                        @endforeach
                                        <div class="border-top border-1 border-gray-300 pt-16 mt-16">
                                            <div class="flex-between gap-8 mb-8">
                                                <span class="text-md text-gray-700"></span>
                                                <div class="flex-align flex-between gap-24" style="width: 22%">
                                                    <span class="text-md text-gray-700">Tạm tính:</span>
                                                    <span class="text-md text-gray-900 fw-semibold">{{ number_format($donhang->tamtinh,0,',','.') }} ₫</span>
                                                </div>
                                            </div>
                                            <div class="flex-between gap-8 mb-8">
                                                <span class="text-md text-gray-700"></span>
                                                <div class="flex-align flex-between gap-24" style="width: 22%">
                                                    <span class="text-md text-gray-700">Phí giao hàng:</span>
                                                    <span class="text-md text-info-900 fw-semibold" title="{{ $donhang->hinhthucvanchuyen }}">{{ number_format($donhang->phigiaohang,0,',','.') }} ₫</span>
                                                </div>
                                            </div>
                                            @if($donhang->magiamgia != null)
                                            <div class="flex-between gap-8 mb-10">
                                                <span class="text-md text-gray-700"></span>
                                                <div class="flex-align flex-between gap-24" style="width: 22%">
                                                    <span class="text-md text-gray-700">Giảm giá:</span>
                                                    <span class="text-md text-success-600 fw-semibold" title="{{ $donhang->mavoucher }}">- {{ number_format($donhang->giagiam,0,',','.') }} ₫</span>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="flex-between gap-8">
                                                <span class="text-md text-gray-700"></span>
                                                <div class="flex-align gap-24">
                                                    <span class="text-xl text-gray-900 fw-bold">Tổng tiền:</span>
                                                    <span class="text-xl text-main-600 fw-bold">{{ number_format($donhang->thanhtien,0,',','.') }} ₫</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-align flex-between gap-12 mt-10">
                                        <a href="{{ route('don-hang-cua-toi') }}" class="text-main-600 text-md fw-medium flex-align gap-8 mt-10 "><i class="ph-bold ph-arrow-fat-lines-left text-main-600 text-md"></i>Quay lại đơn hàng của tôi</a>
                                         @if($donhang->trangthai == 'Chờ xác nhận' || $donhang->trangthai == 'Chờ thanh toán')
                                            
                                            <div class="flex-align gap-12">
                                                @if ($donhang->trangthaithanhtoan === 'Chờ thanh toán')
                                                    <a href="{{ route('dat-hang-thanh-cong', ['madon' => $donhang->madon]) }}"
                                                    class="fw-medium text-main-600 text-md border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                                    <i class="ph-bold ph-credit-card"></i> Quay lại thanh toán</a>
                                                @endif
                                                <form action="{{ route('huy-don-hang') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id_donhang" value="{{ $donhang->id }}">
                                                <button type="submit" class="fw-medium text-main-600 text-md border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                                    <i class="ph-bold ph-trash"></i> Hủy đơn</button>
                                            </form>
                                            </div>
                                            @else
                                                    <span class="fw-medium text-main-300 text-md border border-main-300 px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                                        <i class="ph-bold ph-trash"></i> Hủy đơn hàng</span>
                                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
@endsection