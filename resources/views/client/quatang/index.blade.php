@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <div class="breadcrumb mb-0 pt-40 bg-main-two-60">
            <div class="container container-lg">
                <div class="breadcrumb-wrapper flex-between flex-wrap gap-16">
                    <h6 class="mb-0">Ưu đãi quà tặng</h6>
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
                        <form class="shop-sidebar" action="{{ route('qua-tang') }}" method="get">
                            {{-- @csrf --}}
                            <button type="button"
                                class="shop-sidebar__close d-lg-none d-flex w-32 h-32 flex-center border border-gray-100 rounded-circle hover-bg-main-600 position-absolute inset-inline-end-0 me-10 mt-8 hover-text-white hover-border-main-600">
                                <i class="ph ph-x"></i>
                            </button>
                            <div class="shop-sidebar__box border border-gray-100 rounded-8 p-26 pb-0 mb-32">
                                <h6 class="text-xl border-bottom border-gray-100 pb-16 mb-16">Sắp xếp ưu đãi</h6>
                                <ul class="max-h-540 overflow-y-auto scroll-sm">
                                    <li class="mb-20">
                                        <div class="form-check common-check common-radio">
                                            <input class="form-check-input" type="radio" name="popular" id="popular"
                                                value="popular" onchange="this.form.submit()">
                                            <label class="form-check-label" for="popular">Phổ biến</label>
                                        </div>
                                    </li>
                                    <li class="mb-20">
                                        <div class="form-check common-check common-radio">
                                            <input class="form-check-input" type="radio" name="newest" id="newest"
                                                value="newest" onchange="this.form.submit()">
                                            <label class="form-check-label" for="newest">Mới nhất</label>
                                        </div>
                                    </li>
                                    <li class="mb-20">
                                        <div class="form-check common-check common-radio">
                                            <input class="form-check-input" type="radio" name="expiring" id="expiring"
                                                value="expiring" onchange="this.form.submit()">
                                            <label class="form-check-label" for="expiring">Sắp hết hạn</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop-sidebar__box border border-gray-100 rounded-8 p-26 pb-0 mb-32">
                                <h6 class="text-xl border-bottom border-gray-100 pb-16 mb-24">Nhà cung cấp</h6>
                                <ul class="max-h-540 overflow-y-auto scroll-sm">
                                    @foreach ( $providers as $th)
                                        <li class="mb-16">
                                            <div class="form-check common-check common-radio">
                                                <input class="form-check-input" type="radio" name="provider" id="provider-{{ $th->id }}"
                                                    value="{{ $th->id }}" onchange="this.form.submit()">
                                                <label class="form-check-label" for="provider-{{ $th->id }}">{{ $th->ten }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="shop-sidebar__box rounded-8 flex-align justify-content-between mb-32">
                                    <a href="{{ route('qua-tang') }}" title="Lọc sản phẩm trong bộ lọc của bạn" type="submit" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 w-100">
                                        Xóa bộ lọc
                                    </a>
                                </div>
                            {{-- <div class="shop-sidebar__box rounded-8">
                                <a href="{{ $bannerquangcao->first()->lienket }}">
                                    <img class="rounded-8 w-100"
                                        src="{{ asset('assets/client') }}/images/bg/{{ $bannerquangcao->first()->hinhanh }}"
                                        alt="">
                                </a>
                            </div> --}}
                        </form>
                    </div>
                    <!-- Sidebar End -->

                    <!-- Content Start -->
                    <div class="col-lg-9">
                        <!-- Top Start -->
                        <div class="flex-between gap-16 flex-wrap mb-40 ">
                            <span class="text-gray-900">Hiển thị {{ $quatang->count() }} trên {{ $quatang->total() }} kết quả</span>
                            <div class="position-relative flex-align gap-16 flex-wrap">
                                <button type="button"
                                    class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn">
                                    <i class="ph-bold ph-funnel"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Top End -->

                        <div class="row g-12">
                            @foreach ( $quatang as $item )
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-sm-12 col-md-6 col-xs-12">
                                    <div class="h-100 flex-align gap-4 border border-gray-100 hover-border-main-600 rounded-6 transition-2">
                                        <a href="{{ route('chi-tiet-qua-tang',$item->slug) }}" class="rounded-8 bg-gray-50" style="width:70%;">
                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ $item->hinhanh }}" alt="{{ $item->tieude}}" class="rounded-start-2" style="width: 100%; height:180px; object-fit: cover;">
                                        </a>
                                        <div class=" w-100 h-100 align-items-stretch flex-column justify-content-between d-flex px-10 py-10">
                                            <div class="flex-align gap-4">
                                                <span class="bg-white text-main-600 border border-1 border-gray-100 rounded-circle flex-center text-xl flex-shrink-0" style="width: 30px; height: 30px;">
                                                    <img src="{{ asset('assets/client') }}/images/brands/{{ $item->sanphamduoctang->first()->sanpham->thuonghieu->logo}}" alt="{{ $item->sanphamduoctang->first()->sanpham->thuonghieu->ten}}" class="w-100">
                                                </span>
                                                <a href="{{ url('san-pham?thuonghieu=' . $item->sanphamduoctang->first()->sanpham->thuonghieu->slug) }}" class="text-sm fw-medium text-gray-600">{{ $item->sanphamduoctang->first()->sanpham->thuonghieu->ten}}</a>
                                            </div>
                                            <h6 class="title text-lg fw-semibold mt-2 mb-2">
                                                <a href="{{ route('chi-tiet-qua-tang',$item->slug) }}" class="link text-line-2" tabindex="0">{{ $item->tieude }}</a>
                                            </h6>
                                            <span class="fw-normal fst-italic text-gray-600 text-sm mt-4 text-line-2">{{ $item->thongtin }}</span>
                                            @php
                                                try {
                                                    $ketthucngay = \Carbon\Carbon::parse($item->ngayketthuc);
                                                    $hientai = \Carbon\Carbon::now();
                                                    
                                                    // Kiểm tra xem đã hết hạn chưa
                                                    if ($ketthucngay->gt($hientai)) {
                                                        
                                                        // Sử dụng hàm diff() để Carbon tự tính khoảng cách chính xác (Năm, Tháng, Ngày, Giờ...)
                                                        $diff = $hientai->diff($ketthucngay);
                                                        
                                                        $months = $diff->m + ($diff->y * 12); // Cộng dồn năm vào tháng (nếu thời gian > 1 năm)
                                                        $days = $diff->d;
                                                        $hours = $diff->h;
                                                        $minutes = $diff->i;
                                                        $seconds = $diff->s;

                                                        // Logic hiển thị ưu tiên đơn vị lớn nhất
                                                        if ($months > 0) {
                                                            // Nếu còn trên 1 tháng -> Hiển thị Tháng + Ngày
                                                            $countdownDisplay = "{$months} tháng {$days} ngày";
                                                        } elseif ($days > 0) {
                                                            // Nếu còn trên 1 ngày -> Hiển thị Ngày + Giờ
                                                            $countdownDisplay = "{$days} ngày {$hours} giờ";
                                                        } elseif ($hours > 0) {
                                                            // Nếu còn trên 1 giờ -> Hiển thị Giờ + Phút
                                                            $countdownDisplay = "{$hours} giờ {$minutes} phút";
                                                        } elseif ($minutes > 0) {
                                                            // Nếu còn trên 1 phút -> Hiển thị Phút + Giây
                                                            $countdownDisplay = "{$minutes} phút {$seconds} giây";
                                                        } else {
                                                            // Chỉ còn giây
                                                            $countdownDisplay = "{$seconds} giây";
                                                        }

                                                    } else {
                                                        $countdownDisplay = "Đã Hết Hạn";
                                                    }

                                                } catch (\Exception $e) {
                                                    $countdownDisplay = "Ngày không hợp lệ";
                                                }
                                            @endphp
                                            <div class="flex-align gap-8 p-4 bg-gray-50 rounded-6">
                                                <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                                                <span class="text-gray-500 text-sm">Còn <strong>{{ $countdownDisplay }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination Start -->
                        {{-- @if ($products->lastPage() > 1)
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
                        @endif --}}
                        <!-- Pagination End -->
                    </div>
                    <!-- Content End -->

                </div>
            </div>
        </section>



    </div>
@endsection