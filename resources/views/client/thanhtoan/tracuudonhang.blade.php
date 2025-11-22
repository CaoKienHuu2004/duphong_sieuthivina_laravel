@extends('client.layouts.app')

@section('title')
    Tra cứu đơn hàng @if(isset($donhang)) {{ $donhang->madon }} @endif - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="py-20">
            <div class="container container-lg">

                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-8 col-xl-8">

                        <form action="{{ route('xu-ly-tra-cuu-don-hang') }}" method="POST"
                            class="d-flex flex-column gap-8 mb-20 border border-gray-200 rounded-8 px-16 py-16">
                            @csrf
                            <label class="fw-semibold text-lg text-gray-900 pb-2" for="madon">Tra cứu đơn hàng</label>
                            <input type="text" name="madon" id="madon"
                                placeholder="Nhập mã đơn hàng (không bao gồm dấu #)... "
                                class="common-input w-100 border-gray-300 rounded-4 px-16 py-12 text-sm text-gray-900"
                                @if(isset($donhang)) value="{{ $donhang->madon }}" @endif>
                            <button type="submit"
                                class="text-sm bg-main-600 text-white hover-bg-white hover-text-main-900 border hover-border-main-600 rounded-4 px-16 py-12 w-200 transition-1 fw-medium">Tra
                                cứu</button>
                        </form>
                         @if (session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session()->has('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                        @if(isset($donhang))
                        <hr>
                            <div class="row flex-align-center justify-content-center">
                                <div class="col-lg-12">
                                    <div class="border border-gray-200 p-20 rounded-8">
                                        <div class="row border-bottom border-gray-200 pb-16 mb-16">
                                            <div class="col-lg-4 text-sm text-start">
                                                <span class="fw-semibold text-sm text-gray-600">Mã đơn hàng:</span> <span
                                                    class="fst-italic fw-semibold">#{{ $donhang->madon }}</span>
                                            </div>
                                            <div class="col-lg-4 text-sm text-center">
                                                <span class="fw-semibold text-sm text-gray-600">Trạng thái:</span>
                                                <span
                                                    class="fst-italic @if($donhang->trangthai == 'Đã hủy đơn') text-main-600 @elseif($donhang->trangthai == 'Chờ xác nhận') text-warning-600 @elseif($donhang->trangthai == 'Đã giao hàng') text-success-600 @else text-info-600 @endif">{{ $donhang->trangthai }}</span>
                                            </div>
                                            <div class="col-lg-4 text-sm text-end">
                                                <span class="fw-semibold text-sm text-gray-600">Ngày đặt:</span> <span
                                                    class="fst-italic">{{ $donhang->created_at->format('d/m/Y - H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-align gap-8 flex-between">
                                            <span class="text-md text-gray-900 fw-semibold flex-align gap-8 mb-10"><i
                                                    class="ph-bold ph-shopping-cart text-main-600 text-lg"></i> Chi tiết đơn
                                                hàng</span>
                                        </div>
                                        @foreach ($donhang->chitietdonhang as $chitiet)
                                            <div class="py-6 px-5">
                                                @if($chitiet->dongia == 0)<span
                                                    class="flex-align mt-10 mb-4 text-gray-900 text-sm fw-medium"><i
                                                        class="ph-bold ph-gift text-main-600 text-lg pe-4"></i>Quà tặng của
                                                bạn</span>@endif
                                                <div class="d-flex align-items-center gap-12">
                                                    <a href="{{ route('chi-tiet-san-pham', $chitiet->bienthe->sanpham->slug) }}"
                                                        class="border border-gray-100 rounded-8 flex-center"
                                                        style="max-width: 90px; max-height: 90px; width: 100%; height: 100%">
                                                        <img src="{{ asset('assets/client') }}/images/thumbs/{{ $chitiet->bienthe->sanpham->hinhanhsanpham->first()->hinhanh ?? 'default-image.jpg' }}"
                                                            alt="{{ $chitiet->bienthe->sanpham->ten }}" class="w-100 rounded-8">
                                                    </a>
                                                    <div class="text-start w-100">
                                                        <h6 class="title text-md fw-semibold mb-0">
                                                            <a href="#" class="link text-line-2"
                                                                title="{{ $chitiet->bienthe->sanpham->ten }}"
                                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 500px; display: inline-block;">{{ $chitiet->bienthe->sanpham->ten }}</a>
                                                        </h6>
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="#"
                                                                class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                {{ $chitiet->bienthe->loaibienthe->ten }}
                                                            </a>
                                                        </div>
                                                        <div class="product-card__price mb-6">
                                                            <div class="flex-align gap-24">
                                                                <span class="text-heading text-sm fw-medium ">Số lượng:
                                                                    {{ $chitiet->soluong }}</span>
                                                                <span
                                                                    class="text-main-600 text-md fw-semibold">{{ number_format($chitiet->dongia, 0, ',', '.') }}
                                                                    ₫</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" class="item-id" value="{{ $chitiet->id }}">
                                            </div>
                                        @endforeach
                                        <div class="row border-top border-gray-200 pt-16 mt-16">

                                            <div class="col-lg-4 text-sm text-start">
                                                <div class="fw-semibold text-sm text-gray-600 "><span class="pe-10">Phương thức
                                                        vận chuyển:</span></div>
                                                <span class="fw-medium text-gray-900 text-sm"> Giao hàng
                                                    {{ $donhang->phivanchuyen->ten }}</span>
                                            </div>
                                            <div class="col-lg-4 text-sm text-center">

                                            </div>
                                            <div class="col-lg-4 text-sm text-end">
                                                <div class="fw-semibold text-sm text-gray-600 ">Tổng giá trị đơn hàng:</div>
                                                <span
                                                    class="fw-semibold text-main-600 text-lg">{{ number_format($donhang->thanhtien, 0, ',', '.') }}
                                                    ₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
        </section>
    </div>
@endsection