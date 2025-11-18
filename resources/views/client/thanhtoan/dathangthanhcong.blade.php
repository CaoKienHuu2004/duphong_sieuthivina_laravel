@extends('client.layouts.app')

@section('title')
    Đặt hàng thành công | STV25111009142 |Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="mt-20 mb-10">
            <div class="container container-lg">
                <div class="text-center mb-20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#2ABC79" viewBox="0 0 256 256"><path d="M176.49,95.51a12,12,0,0,1,0,17l-56,56a12,12,0,0,1-17,0l-24-24a12,12,0,1,1,17-17L112,143l47.51-47.52A12,12,0,0,1,176.49,95.51ZM236,128A108,108,0,1,1,128,20,108.12,108.12,0,0,1,236,128Zm-24,0a84,84,0,1,0-84,84A84.09,84.09,0,0,0,212,128Z"></path></svg>
                    <h6 class="mt-10 mb-6">Bạn đã đặt hàng thành công !</h6>
                    <span class="flex-align gap-4 justify-content-center text-md text-gray-700">Siêu Thị Vina đã nhận được đơn hàng của bạn và sớm giao hàng đến tận tay bạn <i class="ph-bold ph-smiley-wink text-2xl text-warning-600"></i></span>
                </div>
                <div class="row flex-align-center justify-content-center">
                    <div class="col-lg-9">
                        <div class="border border-gray-200 p-20 rounded-8">
                            <div class="row border-bottom border-gray-200 pb-16 mb-16">
                                <div class="col-lg-4 text-sm text-start">
                                    <span class="fw-semibold text-sm text-gray-600">Mã đơn hàng:</span> <span class="fst-italic fw-semibold">#{{ $donhang->madon }}</span>
                                </div>
                                <div class="col-lg-4 text-sm text-center">
                                    <span class="fw-semibold text-sm text-gray-600">Trạng thái đơn hàng:</span> <span class="fst-italic text-info-600">{{ $donhang->trangthai }}</span>
                                </div>
                                <div class="col-lg-4 text-sm text-end">
                                    <span class="fw-semibold text-sm text-gray-600">Ngày đặt:</span> <span class="fst-italic">{{ $donhang->created_at->format('d/m/Y - H:i') }}</span>
                                </div>
                            </div>
                            <div class="flex-align gap-8 flex-between">
                                <span class="text-md text-gray-900 fw-semibold flex-align gap-8 mb-10"><i class="ph-bold ph-shopping-cart text-main-600 text-lg"></i> Chi tiết đơn hàng</span>
                                <a href="{{ $donhang->madon }}" class="fw-semibold text-sm text-gray-600 hover-text-main-600 transition-1 flex-align gap-4 mb-0 pb-0"><i class="ph-bold ph-notepad"></i> Xem chi tiết</a>
                            </div>
                                @foreach ($donhang->chitietdonhang as $chitiet)
                                        <div class="py-6 px-5">
                                            @if($chitiet->dongia == 0)<span class="flex-align mt-10 mb-4 text-gray-900 text-sm fw-medium"><i class="ph-bold ph-gift text-main-600 text-lg pe-4"></i>Quà tặng của bạn</span>@endif
                                            <div class="d-flex align-items-center gap-12">
                                                <a href="#" class="border border-gray-100 rounded-8 flex-center" style="max-width: 90px; max-height: 90px; width: 100%; height: 100%">
                                                    <img src="{{ asset('assets/client') }}/images/thumbs/{{ $chitiet->bienthe->sanpham->hinhanhsanpham->first()->hinhanh ?? 'default-image.jpg' }}" alt="{{ $chitiet->bienthe->sanpham->ten }}" class="w-100 rounded-8">
                                                </a>
                                                <div class="text-start w-100">
                                                    <h6 class="title text-md fw-semibold mb-0">
                                                        <a href="#" class="link text-line-2" title="{{ $chitiet->bienthe->sanpham->ten }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $chitiet->bienthe->sanpham->ten }}</a>
                                                    </h6>
                                                    <div class="flex-align gap-16 mb-6">
                                                        <a href="#" class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                            {{ $chitiet->bienthe->loaibienthe->ten }}
                                                        </a>
                                                    </div>
                                                    <div class="product-card__price mb-6">
                                                        <div class="flex-align gap-24">
                                                            <span class="text-heading text-sm fw-medium ">Số lượng: {{ $chitiet->soluong }}</span>
                                                            <span class="text-main-600 text-md fw-semibold">{{ number_format($chitiet->dongia,0,',','.') }} ₫</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="item-id" value="{{ $chitiet->id }}">
                                        </div>
                                    @endforeach
                                <div class="row border-top border-gray-200 pt-16 mt-16">
                                    
                                    <div class="col-lg-4 text-sm text-start">
                                        <div class="fw-semibold text-sm text-gray-600 "><span class="pe-10">Phương thức vận chuyển:</span></div>
                                        <span class="fw-medium text-gray-900 text-sm"> Giao hàng {{ $donhang->phivanchuyen->ten }}</span>
                                    </div>
                                    <div class="col-lg-4 text-sm text-center">
                                        
                                    </div>
                                    <div class="col-lg-4 text-sm text-end">
                                        <div class="fw-semibold text-sm text-gray-600 ">Tổng giá trị đơn hàng:</div>
                                        <span class="fw-semibold text-main-600 text-lg">{{ number_format($donhang->thanhtien,0,',','.') }} ₫</span>
                                        @if($donhang->magiamgia != null)
                                        <div class="fw-semibold text-success-600 text-xs"><span class="text-gray-600">Giảm giá voucher:</span> -{{ number_format($donhang->magiamgia->giatri,0,',','.') }} ₫</div>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <div class="flex-align flex-between gap-12 mb-20">
                                        <a href="{{ route('danhsachsanpham') }}" class="text-main-600 hover-text-gray-900 text-md fw-medium flex-align gap-8 mt-10 "><i class="ph-bold ph-arrow-fat-lines-left text-md"></i>Tiếp tục mua sắm</a>
                                        <a href="{{ route('don-hang-cua-toi') }}" class="text-main-600 hover-text-gray-900 text-md fw-medium flex-align gap-8 mt-10 ">Xem đơn hàng của tôi<i class="ph-bold ph-arrow-fat-lines-right text-md"></i></a>
                                    </div>
                    </div>
            </div>
        </section>
    </div>
@endsection