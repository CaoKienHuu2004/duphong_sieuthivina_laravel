@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="product-details pt-40 fix-scale-40">
            <div class="container container-lg">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-10" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="#" method="post" class="row gy-4">
                    <div class="col-xl-9">
                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <div class="product-details__left">
                                    <div class="product-details__thumb-slider rounded-16 p-0">
                                        <div class="">
                                            <div class="product-details__thumb flex-center h-100">
                                                <img class=" rounded-10"
                                                    src="{{asset('assets/client')}}/images/thumbs/{{ $quatang->hinhanh }}"
                                                    alt=""
                                                    style="width:100%; height: 450px; object-fit: cover; object-position: center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="product-details__content">
                                    <div
                                        class="flex-center mb-24 flex-wrap gap-16 bg-color-one rounded-8 py-16 px-24 position-relative z-1 ">
                                        <img src="{{asset('assets/client')}}/images/bg/bg-hotsale.png" alt=""
                                            class="position-absolute inset-block-start-0 inset-inline-start-0 rounded-8 w-100 z-n1 object-fit-cover"
                                            style="height: 60px; object-position: center;">
                                        <div class="flex-align gap-16">
                                            <h6 class="text-white text-md fw-medium m-0 p-0">Thời gian còn lại:</h6>
                                        </div>

                                        <div class="countdown" id="countdown-quatang">
                                            <ul class="countdown-list flex-align flex-wrap">
                                                <li
                                                    class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium w-28 h-28 rounded-4 p-0 flex-center">
                                                    <span class="days"></span>
                                                </li>
                                                <li
                                                    class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium w-28 h-28 rounded-4 p-0 flex-center">
                                                    <span class="hours"></span>
                                                </li>
                                                <li
                                                    class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium w-28 h-28 rounded-4 p-0 flex-center">
                                                    <span class="minutes"></span>
                                                </li>
                                                <li
                                                    class="countdown-list__item text-heading flex-align gap-4 text-sm fw-medium w-28 h-28 rounded-4 p-0 flex-center">
                                                    <span class="seconds"></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h5 class="mb-4">{{ $quatang->tieude }}</h5>
                                    <span class="text-md fst-italic fw-normal text-gray-600">
                                        {{ $quatang->thongtin }}
                                    </span>
                                    <ul class="mt-20">
                                            @if($quatang->dieukiensoluong > $currentCount)
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-30 h-30 bg-danger-100 text-danger-600 text-md flex-center rounded-circle">
                                                    <i class="ph-bold ph-x"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Mua tối thiểu <span class="text-danger-600"> {{ $quatang->dieukiensoluong }} sản phẩm</span> bất kỳ cùng nhà cung cấp
                                                </span>
                                            </li>
                                            @else
                                            <li class="text-gray-400 mb-14 flex-align gap-14 bg-success-50 py-8 px-8 rounded-8">
                                                <span class="w-30 h-30 bg-main-two-600 text-white text-md flex-center rounded-circle">
                                                    <i class="ph-bold ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Mua tối thiểu <span class="text-main-two-600"> {{ $quatang->dieukiensoluong }} sản phẩm</span> bất kỳ cùng nhà cung cấp
                                                </span>
                                            </li>
                                            @endif
                                            @if($quatang->dieukiengiatri > $cartTotalValue)
                                            <li class="text-gray-400 mb-14 flex-align gap-14 ">
                                                <span class="w-30 h-30 bg-main-100 text-danger-600 text-md flex-center rounded-circle">
                                                    <i class="ph-bold ph-x"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Giá trị đơn hàng tối thiểu <span class="text-main-600"> {{ number_format($targetValue, 0, ',', '.') }} đ</span>
                                                </span>
                                            </li>
                                            @else
                                            <li class="text-gray-400 mb-14 flex-align gap-14 bg-success-50 py-8 px-8 rounded-8">
                                                <span class="w-30 h-30 bg-main-two-600 text-white text-md flex-center rounded-circle">
                                                    <i class="ph-bold ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Giá trị đơn hàng tối thiểu <span class="text-main-two-600"> {{ number_format($targetValue, 0, ',', '.') }} đ</span>
                                                </span>
                                            </li>
                                            @endif
                                        </ul>

                                    <span class="mt-10 mb-10 text-gray-700 border-top border-gray-100 d-block"></span>

                                    <span class="flex-align mb-10 mt-10 text-gray-900 text-md fw-medium"><i
                                            class="ph-bold ph-gift text-main-600 text-lg pe-4"></i>Quà tặng bạn nhận
                                        được:</span>
                                    @foreach ( $quatang->sanphamduoctang as $sanphamduoctang)
                                    <div class="d-flex align-items-center gap-12">
                                        <a href="{{ route('chi-tiet-san-pham',$quatang->bienthe->sanpham->slug) }}" class="border border-gray-100 rounded-8 flex-center"
                                            style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ $quatang->bienthe->sanpham->hinhanhsanpham->first()->hinhanh }}"
                                                alt="{{ $sanphamduoctang->sanpham->ten }}" class="w-100 rounded-8">
                                        </a>
                                        <div class="table-product__content text-start">
                                            <h6 class="title text-md fw-semibold mb-0">
                                                <a href="{{ route('chi-tiet-san-pham',$sanphamduoctang->sanpham->slug) }}" class="link text-line-2"
                                                    title="{{ $sanphamduoctang->sanpham->ten }}"
                                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $sanphamduoctang->sanpham->ten }}</a>
                                            </h6>
                                            <div class="flex-align gap-16 mb-6">
                                                <a href="{{ route('chi-tiet-san-pham',$sanphamduoctang->sanpham->slug) }}"
                                                    class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                    {{ $sanphamduoctang->loaibienthe->ten }}
                                                </a>
                                            </div>
                                            <div class="product-card__price mb-6">
                                                <div class="flex-align gap-24">
                                                    <span class="text-heading text-sm fw-medium ">Số lượng: {{ $sanphamduoctang->soluongtang }}</span>
                                                    @if($percent == 100)
                                                    <span class="text-main-two-600 text-sm fw-medium fst-italic">Quà tặng đã được thêm vào giỏ hàng !</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <span class="mt-10 mb-20 text-gray-700 border-top border-gray-100 d-block"></span>

                                    <div class="mt-8">
                                        <div class="flex-align">
                                            <div class="progress w-100 bg-color-three rounded-pill h-20" role="progressbar"
                                                aria-label="Basic example" aria-valuenow="1" aria-valuemin="0"
                                                aria-valuemax="2">
                                                <div class="progress-bar @if ($percent >= 100) bg-main-two-600 @else bg-main-600 @endif rounded-pill text-center"
                                                    style="width: {{ $percent }}%">{{ number_format($percent, 0) }}%</div>
                                            </div>
                                            @if ($percent >= 100)
                                                <i class="ph-bold ph-seal-check text-3xl text-main-two-600"></i>
                                            @endif
                                        </div>
                                        <span class="text-gray-900 text-sm fw-medium">Hoàn thành điều kiện để tăng tiến độ nhận quà</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="product-details__sidebar py-30 px-20 border border-gray-100 rounded-16">
                            <div class="">
                                <h6 for="stock" class="mb-8 text-heading fw-semibold d-block">Nhà cung cấp</h6>
                                <span class="text-xl d-flex">
                                    <i class="ph ph-location"></i>
                                </span>
                            </div>

                            <div class="mt-10">
                                <a href="{{ url('san-pham?thuonghieu=' . $quatang->bienthe->sanpham->thuonghieu->slug) }}"
                                    class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-12 mb-0"
                                    style="justify-content: start;">
                                    <span
                                        class="bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0 p-4"
                                        style="width: 40px; height: 40px;">
                                        <img src="{{ asset('assets/client') }}/images/brands/{{ $quatang->bienthe->sanpham->thuonghieu->logo }}"
                                            alt="{{ $brandName }}" class="w-100">
                                    </span>
                                    <span class="text-sm text-neutral-600"><span class="fw-semibold">{{ $brandName }}</span>
                                    </span>
                                </a>
                            </div>

                            <div class="mt-32">
                                <div class="px-32 py-16 rounded-8 border border-gray-100 flex-between gap-8">
                                    <a href="#" class="d-flex text-main-600 text-28"><i
                                            class="ph-fill ph-chats-teardrop"></i></a>
                                    <span class="h-26 border border-gray-100"></span>

                                    <div class="dropdown on-hover-item">
                                        <button class="d-flex text-main-600 text-28" type="button">
                                            <i class="ph-fill ph-share-network"></i>
                                        </button>
                                        <div
                                            class="on-hover-dropdown common-dropdown border-0 inset-inline-start-auto inset-inline-end-0">
                                            <ul class="flex-align gap-16">
                                                <li>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('chi-tiet-qua-tang', ['slug' => $quatang->slug]) }}"
                                                        class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-facebook-logo"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.twitter.com"
                                                        class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-twitter-logo"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com"
                                                        class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-instagram-logo"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.pinterest.com"
                                                        class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-linkedin-logo"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>

                <div class="my-20">
                    <div class="flex-between flex-wrap gap-2">
                        <h6 class="mb-0 wow fadeInLeft gap-4"
                            style="display:flex; align-items: flex-start; visibility: visible; animation-name: fadeInLeft;">
                            <i class="ph-bold ph-archive text-main-600"></i>
                            <div>Lựa chọn sản phẩm để nhận quà tặng <div class="text-sm text-gray-600 fw-medium">* Lưu ý
                                    điều kiện quà tặng chỉ áp dụng từng sản phẩm</div>
                            </div>
                        </h6>
                        <div class="flex-align gap-16">
                            <div class="flex-align gap-8">
                                <button type="button" id="new-arrival-prev"
                                    class="slick-prev flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1"
                                    style="">
                                    <i class="ph ph-caret-left"></i>
                                </button>
                                <button type="button" id="new-arrival-next"
                                    class="slick-next flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1"
                                    style="">
                                    <i class="ph ph-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if($suggestedProducts->count() > 0)
                        <div class="new-arrival__slider arrow-style-two mt-20">
                            @foreach($suggestedProducts as $item)
                                <div>
                                    <div
                                        class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                                        <a href="{{ route('chi-tiet-san-pham', $item->sanpham->slug) }}"
                                            class="flex-center rounded-8 bg-gray-50 position-relative">
                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ $item->sanpham->hinhanhsanpham->first()->hinhanh }}"
                                                alt="{{ $item->sanpham->ten }}" class="w-100 rounded-top-2">
                                        </a>
                                        <div
                                            class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                                            <div>
                                                <div class="flex-align justify-content-between mt-5">
                                                    <div class="flex-align gap-4 w-100">
                                                        <span class="text-main-600 text-md d-flex"><i
                                                                class="ph-fill ph-storefront"></i></span>
                                                        <a href="{{ url('san-pham?thuonghieu=' . $item->sanpham->thuonghieu->slug) }}"
                                                            class="text-gray-500 text-xs"
                                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                                                            title="{{ $item->sanpham->thuonghieu->ten }}">{{ $item->sanpham->thuonghieu->ten }}</a>
                                                    </div>
                                                </div>
                                                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                                                    <a href="{{ route('chi-tiet-san-pham', $item->sanpham->slug) }}"
                                                        class="link text-line-2" tabindex="0">{{ $item->sanpham->ten }}</a>
                                                </h6>
                                                <div class="flex-align gap-16 mb-6">
                                                    <a href="#"
                                                        class="btn bg-gray-50 text-line-2 text-xs text-gray-900 py-4 px-6 rounded-8 flex-align gap-8 fw-medium">
                                                        {{ $item->loaibienthe->ten }}
                                                    </a>
                                                </div>
                                                <div class="flex-align justify-content-between mt-2">
                                                    <div class="flex-align gap-6">
                                                        <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                                                        <span class="text-xs fw-medium text-gray-500">4.8
                                                            <i class="ph-fill ph-star text-warning-600"></i></span>
                                                    </div>
                                                    <div class="flex-align gap-4">
                                                        <span class="text-xs fw-medium text-gray-500">{{ $item->luotban }}</span>
                                                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-card__price mt-5">
                                                @if($item->sanpham->giamgia > 0)
                                                    <div class="flex-align gap-4 text-main-two-600">
                                                        <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $item->sanpham->giamgia }}%
                                                        <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                                                            {{ number_format($item->giagoc, 0, ',', '.') }} đ
                                                        </span>
                                                    </div>
                                                @endif
                                                <span class="text-heading text-lg fw-semibold">
                                                    {{ number_format($item->giagoc * (100 - $item->sanpham->giamgia) / 100, 0, ',', '.') }}
                                                    đ
                                                </span>
                                            </div>
                                        </div>
                                        <form class="w-100 " action="{{ route('qua-tang.them-gio-hang') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_bienthe" value="{{ $item->id }}">
                                            <input type="hidden" name="soluong" value="1">
                                            <button type="submit"
                                                class="mt-6 rounded-bottom-2 bg-gray-50 text-sm text-gray-900 w-100 hover-bg-main-600 hover-text-white py-6 px-24 flex-center gap-8 fw-medium transition-1"
                                                tabindex="0">
                                                <i class="ph ph-shopping-cart"></i> Thêm vào giỏ hàng
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        @if($percent < 100)
                            <div class="alert alert-warning text-center">
                                Hiện tại chưa có thêm sản phẩm nào khác để gợi ý.
                            </div>
                        @else
                            <div class="alert alert-success text-center mt-20">
                                Chúc mừng bạn đã hoàn thành mục tiêu nhận quà tặng!
                            </div>

                        @endif
                    @endif
                </div>


            </div>
        </section>
        <script>
            function countdownquatang(elementId, endDate) {
                const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;

                const countDown = new Date(endDate).getTime();

                const interval = setInterval(function () {
                    const now = new Date().getTime(),
                        distance = countDown - now;

                    const daysElement = document.querySelector(`#${elementId} .days`);
                    const hoursElement = document.querySelector(`#${elementId} .hours`);
                    const minutesElement = document.querySelector(`#${elementId} .minutes`);
                    const secondsElement = document.querySelector(`#${elementId} .seconds`);

                    if (daysElement && hoursElement && minutesElement && secondsElement) {
                        daysElement.innerText = Math.floor(distance / day);
                        hoursElement.innerText = Math.floor((distance % day) / hour);
                        minutesElement.innerText = Math.floor((distance % hour) / minute);
                        secondsElement.innerText = Math.floor((distance % minute) / second);
                    }

                    //do something later when date is reached
                    if (distance < 0) {
                        const countdownElement = document.querySelector(`#${elementId}`);
                        if (countdownElement) {
                            countdownElement.style.display = "none";
                        }
                        clearInterval(interval);
                    }
                }, 1000);
            }

            countdownquatang('countdown-quatang', '{{ $quatang->ngayketthuc }}');
        </script>
    </div>

@endsection