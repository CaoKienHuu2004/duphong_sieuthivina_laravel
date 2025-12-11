@extends('client.layouts.app')

@section('title', 'Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina')

@php
  $sliderBanner = $banner['home_banner_slider'] ?? null;
  $eventBanner1 = $banner['home_banner_event_1'] ?? null;
  $eventBanner2 = $banner['home_banner_event_2'] ?? null;
  $eventBanner3 = $banner['home_banner_event_3'] ?? null;
  $eventBanner4 = $banner['home_banner_event_4'] ?? null;

  $promotionBanner1 = $banner['home_banner_promotion_1'] ?? null;
  $promotionBanner2 = $banner['home_banner_promotion_2'] ?? null;
  $promotionBanner3 = $banner['home_banner_promotion_3'] ?? null;

  $adsBanner = $banner['home_banner_ads'] ?? null;
  $productBanner = $banner['home_banner_product'] ?? null;
@endphp

@section('content')

  <div class="page d-none d-lg-block">
    <!-- ============================ BANNER start =============================== -->
    <div class="banner-two fix-scale-20">
      <div class="container container-lg px-0">
        <div class="row g-20">
          <div class="col-lg-6">
            <div class="banner-two-wrapper d-flex align-items-start">
              <div
                class="banner-item-two-wrapper rounded-5 overflow-hidden position-relative arrow-center flex-grow-1 mb-0 mt-20 ms-0">
                <div class="flex-align">
                  <button type="button" id="banner-prev"
                    class="slick-prev flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1 slick-arrow">
                    <i class="ph-bold ph-caret-left"></i>
                  </button>
                  <button type="button" id="banner-next"
                    class="slick-next flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1 slick-arrow">
                    <i class="ph-bold ph-caret-right"></i>
                  </button>
                </div>

                <div class="banner-item-two__slider">
                  @if(isset($banner['home_banner_slider']) && $banner['home_banner_slider']->isNotEmpty())
                    @foreach ($banner['home_banner_slider'] as $banner)
                      <a href="{{ $banner->lienket }}"
                        class="d-flex align-items-center justify-content-between flex-wrap-reverse flex-sm-nowrap gap-32">
                        <img src="{{asset('assets/client')}}/images/bg/{{ $banner->hinhanh }}" alt="{{ $banner->hinhanh }}"
                          class=" d-lg-block d-none rounded-5" style="width: 100%; height: 350px; object-fit: cover;" />
                        <img src="{{asset('assets/client')}}/images/bg/{{ $banner->hinhanh }}" alt="{{ $banner->hinhanh }}"
                          class=" d-block d-lg-none rounded-5" style="width: 100%; height: 300px; object-fit: cover;" />
                      </a>
                    @endforeach
                  @else
                    <a href="#"
                      class="d-flex align-items-center justify-content-between flex-wrap-reverse flex-sm-nowrap gap-32">
                      <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg"
                        class=" d-lg-block d-none rounded-5" style="width: 100%; height: 350px; object-fit: cover;" />
                      <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg"
                        class=" d-block d-lg-none rounded-5" style="width: 100%; height: 300px; object-fit: cover;" />
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 mt-20 ps-10 pe-5 d-lg-block d-none">
            <div class="row g-24 me-0">

              @if(!empty($eventBanner1))
                <a href="{{ $eventBanner1->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner1->hinhanh }}"
                    alt="{{ $eventBanner1->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
            <div class="row g-24 mt-10 me-0">

              @if(isset($eventBanner2))
                <a href="{{ $eventBanner2->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner2->hinhanh }}"
                    alt="{{ $eventBanner2->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
          </div>
          <div class="col-12 col-lg-3 mt-20 px-5 d-lg-block d-none">
            <div class="row g-24 ms-0 w-100">

              @if(isset($eventBanner3))
                <a href="{{ $eventBanner3->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner3->hinhanh }}"
                    alt="{{ $eventBanner3->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
            <div class="row g-24 mt-10 ms-0 w-100">

              @if(isset($eventBanner4))
                <a href="{{ $eventBanner4->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner4->hinhanh }}"
                    alt="{{ $eventBanner4->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
          </div>
        </div>
      </div>
      <!-- ============================ 4 ảnh thumb tĩnh dành cho mobile=============================== -->
      <div class="container">
        <div class="col-12 col-lg-3 mt-20 d-lg-none d-block">
          <div class="">

            @if(isset($eventBanner1))
              <a href="{{ $eventBanner1->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner1->hinhanh }}"
                  alt="{{ $eventBanner1->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
          <div class=" mt-24">

            @if(isset($eventBanner2))
              <a href="{{ $eventBanner2->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner2->hinhanh }}"
                  alt="{{ $eventBanner2->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-2.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
        </div>
        <div class="col-12 col-lg-3 mt-20 pe-0  d-lg-none d-block">
          <div class="">

            @if(isset($eventBanner3))
              <a href="{{ $eventBanner3->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner3->hinhanh }}"
                  alt="{{ $eventBanner3->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
          <div class=" mt-24">

            @if(isset($eventBanner4))
              <a href="{{ $eventBanner4->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner4->hinhanh }}"
                  alt="{{ $eventBanner4->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
        </div>
      </div>
      <!-- ============================endsection ảnh thumb tĩnh dành cho mobile=============================== -->
    </div>
    <!-- ============================ BANNER End =============================== -->

    <!-- ============================ DANH MỤC Start ========================== -->
    <div class="feature mt-10 fix-scale-20 " id="featureSection">
      <div class="container container-lg px-0">
        <div class="position-relative arrow-center">
          <div class="flex-align">
            <button type="button" id="feature-item-wrapper-prev"
              class="slick-prev slick-arrow flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
              <i class="ph ph-caret-left"></i>
            </button>
            <button type="button" id="feature-item-wrapper-next"
              class="slick-next slick-arrow flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
              <i class="ph ph-caret-right"></i>
            </button>
          </div>
          <div class="feature-item-wrapper">
            @foreach ($alldanhmuc as $dsdm)
              <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="400">
                <div class="feature-item__thumb rounded-circle">
                  <a href="{{ url('san-pham?danhmuc=' . $dsdm->slug) }}" class="w-100 h-100 p-10 flex-center">
                    <img src="{{asset('assets/client')}}/images/categories/{{ $dsdm->logo }}" alt="{{ $dsdm->ten }}">
                  </a>
                </div>
                <div class="feature-item__content mt-16">
                  <h6 class="text-md fw-medium mb-8"><a href="{{ url('san-pham?danhmuc=' . $dsdm->slug) }}"
                      class="text-inherit">{{ $dsdm->ten }}</a></h6>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
    <!-- ============================ DANH MỤC End ========================== -->

    <!-- ========================= TOP DEALS * SIÊU RẺ ================================ -->
    <section class="top-selling-products pt-20 overflow-hidden fix-scale-30">
      <div class="container container-lg px-0">
        <div class="border border-gray-100 pr-20 p-16 rounded-10 bg-hotsales">
          <div class="section-heading mb-24">
            <div class="flex-between flex-wrap gap-8">
              <h6 class="mb-0 wow fadeInLeft text-white">
                <img src="{{asset('assets/client')}}/images/thumbs/top-deal-sieu-re.png" alt=""
                  class="w-50 py-10 d-lg-block d-none">
                <img src="{{asset('assets/client')}}/images/thumbs/top-deal-sieu-re.png" alt=""
                  class="py-10 d-lg-none d-block" width="70%">
              </h6>
              <div class="flex-align gap-16 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                <a href="{{ url('san-pham?sortby=topdeals') }}"
                  class="text-sm fw-semibold text-white hover-text-gray-100 hover-text-decoration-underline">Xem tất
                  cả</a>
                <div class="flex-align gap-4">
                  <button type="button" id="top-selling-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle text-xl text-white hover-text-white transition-1 w-50">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="top-selling-next"
                    class="slick-next slick-arrow flex-center rounded-circle text-xl text-white hover-text-white transition-1 w-50">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-12">
            <div class="col-md-12">
              <div class="top-selling-product-slider arrow-style-two">
                @foreach ($topdeals as $td)
                  <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="product-card bg-white hover-card-shadows h-100 rounded-10 position-relative transition-2">

                      <a href="{{ route('chi-tiet-san-pham', $td->slug) }}"
                        class="thumbhover flex-center rounded-10 position-relative bg-gray-50 w-100">
                        @if($td->giamgia > 0)
                          <span
                            class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Giảm
                            {{ $td->giamgia }}%
                          </span>
                        @endif
                        <div class="w-100">
                          <img src="{{asset('assets/client')}}/images/thumbs/{{ $td->hinhanhsanpham->first()->hinhanh }}"
                            alt="{{ $td->hinhanhsanpham->first()->hinhanh }}" class=""
                            style="width: 100%; height: 210px; object-fit: cover; border-top-left-radius:10px; border-top-right-radius:10px;" />
                        </div>
                      </a>
                      <div class="product-card__content w-100 px-16 pb-16 mt-5">
                        <div class="flex-align justify-content-between mt-5">
                          <div class="flex-align gap-4 w-100">
                            <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                            <a href="{{ url('san-pham?thuonghieu=' . $td->thuonghieu->slug) }}"
                              class="text-gray-500 text-xs"
                              style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                              title="{{ $td->thuonghieu->ten }}">{{ $td->thuonghieu->ten }}</a>
                          </div>
                        </div>
                        <h6 class="title text-lg fw-semibold mt-5 mb-8">
                          <a href="{{ route('chi-tiet-san-pham', $td->slug) }}" class="link text-line-2"
                            tabindex="0">{{ $td->ten }}</a>
                        </h6>
                        <div class="flex-wrap flex-align justify-content-between mt-5">
                          <div class="flex-align gap-6">
                            <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                            <span class="text-xs fw-medium text-gray-500">nullable
                              <i class="ph-fill ph-star text-warning-600"></i></span>
                          </div>
                          <div class="flex-align gap-4">
                            <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                            <span class="text-xs fw-medium text-gray-500">{{ $td->bienthe_sum_luotban }}</span>
                          </div>
                        </div>
                        <div class="product-card__price mt-5">
                          <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">
                            {{ number_format($td->bienthe->giagoc, 0, ',', '.') }} ₫</span>
                          <span class="text-heading text-md fw-semibold">{{ number_format($td->giadagiam, 0, ',', '.') }}
                            ₫</span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= TOP DEALS * SIÊU RẺ End ================================ -->

    <!-- ========================= QUÀ TẶNG ================================ -->
    <section class="deals-weeek pt-10 overflow-hidden fix-scale-30">
      <div class="container container-lg px-0">
        <div class="">
          <div class="section-heading mb-24">
            <div class="flex-between flex-align flex-wrap gap-8 w-100">
              <h6 class="mb-0 wow fadeInLeft flex-align gap-8"><i class="ph-bold ph-gift text-main-600"></i> Quà tặng</h6>
              <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 77%;"></div>
              <div class="flex-align gap-16 wow fadeInRight">
                <a href="{{ route('qua-tang') }}"
                  class="text-sm fw-semibold text-main-600 hover-text-main-600 hover-text-decoration-underline">Xem tất
                  cả</a>
                <div class="flex-align gap-8">
                  <button type="button" id="gift-event-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="gift-event-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div class="gift-event-slider arrow-style-two">
            @if ($quatang->isNotEmpty())
              @foreach ($quatang as $qt)
                @php
                  try {
                    $ketthucngay = \Carbon\Carbon::parse($qt->ngayketthuc);
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
                <div>
                  <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                    <a href="{{ route('chi-tiet-qua-tang',$qt->slug) }}">
                      <div class="rounded-16 "
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/{{ $qt->hinhanh }}'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                        <div class="card-overlay rounded-16 transition-1"></div>
                      </div>
                      <div class="card-content mt-210 p-14 w-100">

                        <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                          <a href="{{ route('chi-tiet-qua-tang',$qt->slug) }}" class="link text-line-2" style="color: white !important;"
                            tabindex="0">{{ $qt->tieude }}</a>
                        </div>

                        <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                          <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                          <span class="text-gray-500 text-xs">Còn lại <strong>{{ $countdownDisplay }}</strong></span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              @endforeach
            @endif



          </div>
        </div>
      </div>
    </section>
    <!-- ========================= QUÀ TẶNG End ================================ -->

    <div class="container container-lg mt-10 mb-70 px-0">
      <div class="row">
        <div class="col-lg-4">
          <div class="rounded-5">
            @if($promotionBanner1)
              <a href="{{ $promotionBanner1->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $promotionBanner1->hinhanh }}" alt=""
                  class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-10">
              </a>
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <div class="rounded-5">
            @if($promotionBanner2)
              <a href="{{ $promotionBanner2->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $promotionBanner2->hinhanh }}" alt=""
                  class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-10">
              </a>
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <div class="rounded-5">
            @if($promotionBanner3)
              <a href="{{ $promotionBanner3->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $promotionBanner3->hinhanh }}" alt=""
                  class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-10">
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- ========================= DANH MỤC HÀNG ĐẦU ================================ -->
    <section class="trending-productss overflow-hidden mt-10 fix-scale-80">
      <div class="container container-lg px-0">
        <div class="border border-gray-100 p-24 rounded-8">
          <div class="section-heading mb-24">
            <div class="flex-between flex-align flex-wrap gap-8">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-squares-four text-main-600"></i> Danh mục hàng đầu</h6>
              <ul class="nav common-tab style-two nav-pills wow fadeInRight m-0" id="pills-tab" role="tablist">
                @if($danhsachdmhangdau->isNotEmpty())
                  @foreach($danhsachdmhangdau as $key => $danhmuc)
                    <li class="nav-item" role="presentation">
                      <button class="nav-link fw-medium text-sm border border-main-two-600 hover-text-main-600 hover-border-main-600 {{$loop->first ? 'active' : '' }}"
                        id="tab-{{ $danhmuc->id }}" data-bs-toggle="pill" data-bs-target="#content-{{ $danhmuc->id }}"
                        type="button" role="tab" aria-controls="content-{{ $danhmuc->id }}"
                        aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                        {{ $danhmuc->ten}}
                      </button>
                    </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            @if($sanphamthuocdanhmuc->isNotEmpty())
              @foreach ($sanphamthuocdanhmuc as $categoryId => $products)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $categoryId }}"
                  role="tabpanel" aria-labelledby="tab-{{ $categoryId }}" tabindex="0">
                  <div class="row g-12">
                    @foreach ($products as $product)
                      <div class="col-xxl-2 col-xl-3 col-lg-4 col-xs-6">
                        <div
                          class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                          <a href="{{ route('chi-tiet-san-pham', $product->slug) }}"
                            class="flex-center rounded-8 bg-gray-50 position-relative">
                            <img src="{{ asset('assets/client/images/thumbs/' . $product->hinhanhsanpham->first()->hinhanh) }}"
                              alt="{{ $product->ten }}" class="w-100 rounded-top-2" />
                          </a>
                          <div
                            class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                            <div>
                              <h6 class="title text-lg fw-semibold mt-2 mb-2">
                                <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2"
                                  tabindex="0">{{ $product->ten }}</a>
                              </h6>
                              <div class="flex-align justify-content-between mt-2">
                                <div class="flex-align gap-6">
                                  <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                                  <span class="text-xs fw-medium text-gray-500">4.8
                                    <i class="ph-fill ph-star text-warning-600"></i></span>
                                </div>
                                <div class="flex-align gap-4">
                                  <span
                                    class="text-xs fw-medium text-gray-500">{{ number_format($product->product_total_sales) }}</span>
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
                  <div class="mx-auto w-100 text-center">
                    <a href="{{ url('san-pham?sortby=top-' . $danhsachdmhangdau->firstWhere('id', $categoryId)->slug) }}"
                      class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
                      Xem thêm sản phẩm
                    </a>
                  </div>
                </div>

              @endforeach
            @else
              <div class="w-100 text-center py-10">
                <p class="text-lg text-gray-500">Hiện không có sản phẩm nào thuộc các danh mục hàng đầu đang được hiển thị.
                </p>
              </div>
            @endif


          </div>
        </div>
      </div>
    </section>
    <!-- ========================= DANH MỤC HÀNG ĐẦU End ================================ -->

    <div class="container container-lg mt-10 mb-10 px-0">
      <div class="text-center" style="height: 50%;" data-aos="fade-up" data-aos-duration="500">
        @if (isset($adsBanner))
          <a href="{{ $adsBanner->lienket }}" class="p-0 m-0 w-100 h-50">
            <img src="{{asset('assets/client')}}/images/bg/{{ $adsBanner->hinhanh }}" alt=""
              class="banner-img w-100 h-100 object-fit-cover rounded-10">
          </a>
        @endif

      </div>
    </div>

    <!-- ========================= THƯƠNG HIỆU HÀNG ĐẦU ================================ -->
    <section class="top-selling-products overflow-hidden mb-10 fix-scale-30">
      <div class="container container-lg px-0">
        <div class="rounded-16">
          <div class="section-heading mb-24">
            <div class="flex-between flex-wrap">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-storefront text-main-600"></i> Thương hiệu hàng đầu
              </h6>
              <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 70%;"></div>
              <div class="flex-align gap-16 wow fadeInRight">
                <a href="shop.html"
                  class="text-sm fw-semibold text-gray-700 hover-text-main-600 hover-text-decoration-underline">
                  Xem đầy đủ
                </a>
                <div class="flex-align gap-8">
                  <button type="button" id="top-brand-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="top-brand-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-12">
            <div class="col-md-12">
              <div class="top-brand-slider arrow-style-two">
                @if ($topbrands->isNotEmpty())
                  @foreach ($topbrands as $topbrand)
                    <div data-aos="fade-up" data-aos-duration="200">
                      <div
                        class="product-card hover-card-shadows h-100 p-5 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white  justify-content-center">
                        <a href="{{ $topbrand->slug }}" class="product-card__thumb flex-center rounded-8 position-relative"
                          style="height: 120px;">
                          <img src="{{asset('assets/client')}}/images/brands/{{ $topbrand->logo }}"
                            alt="{{ $topbrand->logo }}" class="object-fit-cover" style="width: 60%;" />
                        </a>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= THƯƠNG HIỆU HÀNG ĐẦU End ================================ -->

    <section class="featured-products overflow-hidden py-10 fix-scale-30">
      <div class="container container-lg px-0">
        <div class="row g-4 flex-wrap-reverse">
          <div class="col-xxl-9">
            <div>
              <div class="section-heading mb-24">
                <div class="flex-between flex-wrap gap-2">
                  <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-package text-main-600"></i> Sản phẩm hàng đầu</h6>
                  <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 55%;"></div>
                  <div class="flex-align gap-16 wow fadeInRight">
                    <a href="{{ url('san-pham?sortby=sanphamhangdau') }}"
                      class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">
                      Xem tất cả
                    </a>
                    <div class="flex-align gap-8">
                      <button type="button" id="featured-products-prev"
                        class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                        <i class="ph ph-caret-left"></i>
                      </button>
                      <button type="button" id="featured-products-next"
                        class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                        <i class="ph ph-caret-right"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row gy-4 featured-product-slider">
                @foreach ($topproducts->chunk(2) as $product)
                  <div class="col-xxl-6">
                    <div class="featured-products__sliders">
                      @foreach ($product as $sp)
                        <div class="" data-aos="fade-up" data-aos-duration="800">
                          <div
                            class="mt-24 product-card d-flex gap-16 p-0 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="{{ route('chi-tiet-san-pham', $sp->slug) }}"
                              class="flex-center rounded-8 position-relative w-unset flex-shrink-0 " tabindex="0">
                              <img
                                src="{{ asset('assets/client') }}/images/thumbs/{{ $sp->hinhanhsanpham->first()->hinhanh }}"
                                alt="{{ $sp->hinhanhsanpham->first()->hinhanh }}" class="rounded-start-4"
                                style="width: 180px; height: 180px; object-fit: cover;" />
                            </a>
                            <div
                              class="product-card__content w-100 mt-20 mb-10 flex-grow-1 pe-10 align-items-stretch flex-column justify-content-between d-flex">
                              <div>
                                <div class="flex-align gap-4 mb-5">
                                  <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                  <span class="text-gray-500 text-xs"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 200px; display: inline-block;">{{ $sp->thuonghieu->ten }}</span>
                                </div>
                                <h6 class="title text-lg fw-semibold mb-5">
                                  <a href="{{ route('chi-tiet-san-pham', $sp->slug) }}" class="link text-line-2"
                                    title="iPhone 15 Pro Warp Charge 30W Power Adapter">
                                    {{ $sp->ten }}
                                  </a>
                                </h6>
                                <div class="flex-wrap flex-align justify-content-between">
                                  <div class="flex-align gap-6">
                                    <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                                    <span class="text-xs fw-medium text-gray-500">4.5 <i
                                        class="ph-fill ph-star text-warning-600"></i></span>
                                  </div>
                                  <div class="flex-align gap-4">
                                    <span class="text-xs fw-medium text-gray-500">{{ $sp->bienthe_sum_luotban }}</span>
                                    <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                                  </div>
                                </div>
                              </div>
                              <div class="product-card__price mt-5">
                                @if ($sp->giamgia > 0)
                                  <div class="flex-align gap-4 text-main-two-600">
                                    <i class="ph-fill ph-seal-percent text-sm"></i> {{ $sp->giamgia }}%
                                    <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                                      {{ number_format($sp->bienthe->giagoc, 0, ',', '.') }} đ
                                    </span>
                                  </div>
                                @endif
                                <span class="text-heading text-lg fw-semibold">
                                  {{ number_format($sp->giadagiam, 0, ',', '.') }} đ
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @endforeach


              </div>
            </div>
          </div>

          <div class="col-xxl-3">
            <div class="position-relative rounded-16 bg-light-purple overflow-hidden p-28 pb-0 z-1 text-center h-100"
              data-aos="fade-up" data-aos-duration="1000">
              @if (isset($productBanner))
                <a href="{{ $productBanner->lienket }}" class="p-0 m-0 w-100 h-100">
                  <img src="{{ asset('assets/client') }}/images/bg/{{ $productBanner->hinhanh }}"
                    alt="{{ $productBanner->hinhanh }}"
                    class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 cover-img" />
                </a>
              @endif

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- MÃ GIẢM GIÁ -->
    <div class="">
      <div class="container container-lg px-0">
        <div
          class="border border-main-500 bg-main-50 border-dashed rounded-8 py-20 d-flex align-items-center justify-content-evenly">
          <p class="h6 text-main-600 fw-normal">
            Áp dụng mã giảm giá ưu đãi cho
            <a href="#"
              class="fw-bold text-decoration-underline text-main-600 hover-text-decoration-none hover-text-primary-600">
              thành viên mới</a>
          </p>
          <div class="position-relative">
            <button
              class="copy-coupon-btn px-32 py-10 text-white text-uppercase bg-main-600 rounded-pill border-0 hover-bg-main-800">
              SIEUTHIVINA2025
              <i class="ph ph-file-text text-lg line-height-1"></i>
            </button>
            <span
              class="copy-text bg-main-600 text-white fw-normal position-absolute px-16 py-6 rounded-pill bottom-100 start-50 translate-middle-x min-w-max mb-8 text-xs"></span>
          </div>
          <p class="text-md text-main-600 fw-normal">
            Áp dụng giảm giá đến
            <span class="fw-bold text-main-600">20% </span> tổng giá trị mỗi đơn hàng
          </p>
        </div>
      </div>
    </div>
    <!-- Super Discount End -->

    <!-- ========================= HÀNG MỚI CHÀO SÂN ================================ -->
    <section class="trending-productss pt-16 overflow-hidden fix-scale-100">
      <div class="container container-lg px-0">
        <div class="">
          <div class="section-heading mb-24">
            <div class="flex-between flex-wrap gap-2">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-waving text-main-600"></i> Hàng mới chào sân
              </h6>
              <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 80%;"></div>
            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
              tabindex="0">
              <div class="row g-12">
                @foreach ($hangmoichaosan as $product)
                  <div class="col-xxl-2 col-xl-3 col-lg-4 col-xs-6">
                    <div
                      class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                      <a href="{{ route('chi-tiet-san-pham', $product->slug) }}"
                        class="flex-center rounded-8 bg-gray-50 position-relative">
                        <img src="{{ asset('assets/client/images/thumbs/' . $product->hinhanhsanpham->first()->hinhanh) }}"
                          alt="{{ $product->ten }}" class="w-100 rounded-top-2" />
                      </a>
                      <div
                        class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                        <div>
                          <div class="flex-align justify-content-between mt-5">
                            <div class="flex-align gap-4 w-100">
                              <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                              <span class="text-gray-500 text-xs"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                                title="{{ $product->thuonghieu->ten }}">{{ $product->thuonghieu->ten }}</span>
                            </div>
                          </div>
                          <h6 class="title text-lg fw-semibold mt-2 mb-2">
                            <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2"
                              tabindex="0">{{ $product->ten }}</a>
                          </h6>
                          <div class="flex-align justify-content-between mt-2">
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
                                {{ number_format($product->bienthe->giagoc, 0, ',', '.')}} đ
                              </span>
                            </div>
                          @endif
                          <span class="text-heading text-lg fw-semibold">
                            {{ number_format($product->giadagiam, 0, ',', '.')}} đ
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="mx-auto w-100 text-center" data-aos="fade-up" data-aos-duration="200">
              <a href="{{ url('san-pham?sortby=latest') }}"
                class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
                Xem thêm sản phẩm
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- ========================= HÀNG MỚI CHÀO SÂN End ================================ -->

    <!-- ========================= CÓ THỂ BẠN YÊU THÍCH ================================ -->
    <section class="trending-productss pt-16 overflow-hidden fix-scale-80">
      <div class="container container-lg px-0">
        <div class="">
          <div class="section-heading mb-24">
            <div class="flex-between flex-wrap gap-2">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-withdraw text-main-600"></i> Được quan tâm nhiều
                nhất
              </h6>
              <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 75%;"></div>

            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
              tabindex="0">
              <div class="row g-12">
                @foreach ($likeProducts as $product)
                  <div class="col-xxl-2 col-xl-3 col-lg-4 col-xs-6">
                    <div
                      class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                      <a href="{{ route('chi-tiet-san-pham', $product->slug) }}"
                        class="flex-center rounded-8 bg-gray-50 position-relative">
                        <img src="{{ asset('assets/client/images/thumbs/' . $product->hinhanhsanpham->first()->hinhanh) }}"
                          alt="{{ $product->ten }}" class="w-100 rounded-top-2" />
                      </a>
                      <div
                        class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                        <div>
                          <div class="flex-align justify-content-between mt-5">
                            <div class="flex-align gap-4 w-100">
                              <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                              <span class="text-gray-500 text-xs"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                                title="{{ $product->thuonghieu->ten }}">{{ $product->thuonghieu->ten }}</span>
                            </div>
                          </div>
                          <h6 class="title text-lg fw-semibold mt-2 mb-2">
                            <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2"
                              tabindex="0">{{ $product->ten }}</a>
                          </h6>
                          <div class="flex-align justify-content-between mt-2">
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
                                {{ number_format($product->bienthe->giagoc, 0, ',', '.')}} đ
                              </span>
                            </div>
                          @endif
                          <span class="text-heading text-lg fw-semibold">
                            {{ number_format($product->giadagiam, 0, ',', '.')}} đ
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="mx-auto w-100 text-center" data-aos="fade-up" data-aos-duration="200">
              <a href="{{ url('san-pham?sortby=quantamnhieunhat') }}"
                class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
                Xem thêm sản phẩm
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container container-lg px-0">
        <div class="section-heading mb-24">
          <div class="flex-between flex-wrap gap-2">
            <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-withdraw text-main-600"></i> Nhiều bài viết cần bạn
              khám phá
            </h6>
            <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 71%;"></div>

          </div>
        </div>
        <div class="row gy-4">
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= CÓ THỂ BẠN YÊU THÍCH end ================================ -->
  </div>




  <div class="page d-block d-lg-none">
    <!-- ============================ BANNER start =============================== -->
    <div class="banner-two fix-scale-20">
      <div class="container container-lg px-0">
        <div class="row g-20">
          <div class="col-lg-6 w-100">
            <div class="banner-two-wrapper d-flex align-items-start">
              <div
                class="banner-item-two-wrapper rounded-5 overflow-hidden position-relative arrow-center flex-grow-1 mb-0 mt-20 ms-0 w-100">
                <div class="flex-align">
                  <button type="button" id="banner-mobile-prev"
                    class="slick-prev flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1 slick-arrow">
                    <i class="ph-bold ph-caret-left"></i>
                  </button>
                  <button type="button" id="banner-mobile-next"
                    class="slick-next flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1 slick-arrow">
                    <i class="ph-bold ph-caret-right"></i>
                  </button>
                </div>

                <div class="banner-item-mobile__slider">
                  @if(isset($sliderBanner) && $sliderBanner->isNotEmpty())
                    @foreach ($sliderBanner as $banner)
                      <a href="{{ $banner->lienket }}"
                        class="d-flex align-items-center justify-content-between flex-wrap-reverse flex-sm-nowrap gap-32 w-100">
                        <img src="{{asset('assets/client')}}/images/bg/{{ $banner->hinhanh }}" alt="{{ $banner->hinhanh }}"
                          class=" d-block d-lg-none rounded-5" style="width: 100%; height: 300px; object-fit: cover;" />
                      </a>
                    @endforeach
                  @else
                    <a href="#"
                      class="d-flex align-items-center justify-content-between flex-wrap-reverse flex-sm-nowrap gap-32">
                      <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg"
                        class=" d-block d-lg-none rounded-5" style="width: 100%; height: 300px; object-fit: cover;" />
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-3 mt-20 ps-10 pe-5 d-lg-block d-none">
            <div class="row g-24 me-0">

              @if(!empty($eventBanner1))
                <a href="{{ $eventBanner1->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner1->hinhanh }}"
                    alt="{{ $eventBanner1->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
            <div class="row g-24 mt-10 me-0">

              @if(isset($eventBanner2))
                <a href="{{ $eventBanner2->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner2->hinhanh }}"
                    alt="{{ $eventBanner2->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
          </div>
          <div class="col-12 col-lg-3 mt-20 px-5 d-lg-block d-none">
            <div class="row g-24 ms-0 w-100">

              @if(isset($eventBanner3))
                <a href="{{ $eventBanner3->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner3->hinhanh }}"
                    alt="{{ $eventBanner3->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
            <div class="row g-24 mt-10 ms-0 w-100">

              @if(isset($eventBanner4))
                <a href="{{ $eventBanner4->lienket }}" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner4->hinhanh }}"
                    alt="{{ $eventBanner4->hinhanh }}" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @else
                <a href="#" class="p-0 m-0">
                  <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class="p-0 rounded-5"
                    style="width: 100%; height: 170px; object-fit: cover;" />
                </a>
              @endif

            </div>
          </div>
        </div>
      </div>
      <!-- ============================ 4 ảnh thumb tĩnh dành cho mobile=============================== -->
      <div class="container">
        <div class="col-12 col-lg-3 mt-20 d-lg-none d-block">
          <div class="">

            @if(isset($eventBanner1))
              <a href="{{ $eventBanner1->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner1->hinhanh }}"
                  alt="{{ $eventBanner1->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
          <div class=" mt-24">

            @if(isset($eventBanner2))
              <a href="{{ $eventBanner2->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner2->hinhanh }}"
                  alt="{{ $eventBanner2->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-2.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
        </div>
        <div class="col-12 col-lg-3 mt-20 pe-0  d-lg-none d-block">
          <div class="">

            @if(isset($eventBanner3))
              <a href="{{ $eventBanner3->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner3->hinhanh }}"
                  alt="{{ $eventBanner3->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
          <div class=" mt-24">

            @if(isset($eventBanner4))
              <a href="{{ $eventBanner4->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $eventBanner4->hinhanh }}"
                  alt="{{ $eventBanner4->hinhanh }}" class="p-0 rounded-5" style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif

          </div>
        </div>
      </div>
      <!-- ============================endsection ảnh thumb tĩnh dành cho mobile=============================== -->
    </div>
    <!-- ============================ BANNER End =============================== -->

    <!-- ============================ DANH MỤC Start ========================== -->
    <div class="feature mt-30 fix-scale-40 " id="featureSection">
      <div class="container container-lg px-0">
        <div class="position-relative arrow-center">
          <div class="flex-align">
            <button type="button" id="feature-item-mobile-wrapper-prev"
              class="slick-prev slick-arrow flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
              <i class="ph ph-caret-left"></i>
            </button>
            <button type="button" id="feature-item-mobile-wrapper-next"
              class="slick-next slick-arrow flex-center rounded-circle bg-white text-xl hover-bg-main-600 hover-text-white transition-1">
              <i class="ph ph-caret-right"></i>
            </button>
          </div>
          <div class="feature-item-mobile-wrapper">
            @foreach ($alldanhmuc as $dsdm)
              <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="400">
                <div class="feature-item__thumb rounded-circle">
                  <a href="{{ url('san-pham?danhmuc=' . $dsdm->slug) }}" class="w-100 h-100 p-10 flex-center">
                    <img src="{{asset('assets/client')}}/images/categories/{{ $dsdm->logo }}" alt="{{ $dsdm->ten }}">
                  </a>
                </div>
                <div class="feature-item__content mt-16">
                  <h6 class="text-xs fw-medium mb-8"><a href="{{ url('san-pham?danhmuc=' . $dsdm->slug) }}"
                      class="text-inherit">{{ $dsdm->ten }}</a></h6>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </div>
    </div>
    <!-- ============================ DANH MỤC End ========================== -->

    <!-- ========================= TOP DEALS * SIÊU RẺ ================================ -->
    <section class="top-selling-products pt-20 overflow-hidden fix-scale-30">
      <div class="container container-lg px-0">
        <div class="pr-20 py-16 px-0 bg-hotsales">
          <div class="section-heading mb-24 px-10">
            <div class="flex-between gap-8">
              <h6 class="mb-0 wow fadeInLeft text-white">
                <img src="{{asset('assets/client')}}/images/thumbs/top-deal-sieu-re.png" alt=""
                  class="py-10 d-lg-none d-block" width="75%">
              </h6>
              <div class="flex-align gap-16 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                <div class="flex-align gap-4">
                  <button type="button" id="top-selling-mobile-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle text-xl text-white hover-text-white transition-1 w-50">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="top-selling-mobile-next"
                    class="slick-next slick-arrow flex-center rounded-circle text-xl text-white hover-text-white transition-1 w-50">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-12">
            <div class="col-md-12">
              <div class="top-selling-product-mobile-slider arrow-style-two">
                @foreach ($topdeals as $td)
                  <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="product-card bg-white hover-card-shadows h-100 rounded-10 position-relative transition-2">

                      <a href="{{ route('chi-tiet-san-pham', $td->slug) }}"
                        class="thumbhover flex-center rounded-10 position-relative bg-gray-50 w-100">
                        @if($td->giamgia > 0)
                          <span
                            class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Giảm
                            {{ $td->giamgia }}%
                          </span>
                        @endif
                        <div class="w-100">
                          <img src="{{asset('assets/client')}}/images/thumbs/{{ $td->hinhanhsanpham->first()->hinhanh }}"
                            alt="{{ $td->hinhanhsanpham->first()->hinhanh }}" class=""
                            style="width: 100%; height: 150px; object-fit: cover; border-top-left-radius:10px; border-top-right-radius:10px;" />
                        </div>
                      </a>
                      <div class="product-card__content w-100 px-12 pb-16 mt-5">
                        <div class="flex-align justify-content-between mt-5">
                          <div class="flex-align gap-4 w-100">
                            <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                            <span class="text-gray-500 text-xs"
                              style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                              title="{{ $td->thuonghieu->ten }}">{{ $td->thuonghieu->ten }}</span>
                          </div>
                        </div>
                        <h6 class="title text-lg fw-semibold mt-5 mb-8">
                          <a href="{{ route('chi-tiet-san-pham', $td->slug) }}" class="link text-line-2"
                            tabindex="0">{{ $td->ten }}</a>
                        </h6>
                        <div class="flex-wrap flex-align justify-content-between mt-5">
                          <div class="flex-align gap-6">
                            <span class="text-xs fw-medium text-gray-500 flex-align gap-4"><i
                                class="ph-fill ph-star text-warning-600 text-sm "></i> 4,7 (12)</span>
                          </div>
                          <div class="flex-align gap-4">
                            <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                            <span class="text-xs fw-medium text-gray-500">{{ $td->bienthe_sum_luotban }}</span>
                          </div>
                        </div>
                        <div class="product-card__price mt-5">
                          <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">
                            {{ number_format($td->bienthe->giagoc, 0, ',', '.') }} ₫</span>
                          <div class="text-heading text-md fw-semibold">{{ number_format($td->giadagiam, 0, ',', '.') }} ₫
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= TOP DEALS * SIÊU RẺ End ================================ -->

    <!-- ========================= QUÀ TẶNG ================================ -->
    <section class="deals-weeek mt-40 overflow-hidden fix-scale-30">
      <div class="container container-lg">
        <div class="">
          <div class="section-heading mb-24">
            <div class="flex-between flex-align gap-4 w-100">
              <h6 class="mb-0  wow fadeInLeft flex-align gap-8"><i class="ph-bold ph-gift text-main-600"></i> Quà tặng
              </h6>
              <div class="flex-align gap-16 wow fadeInRight">
                <div class="flex-align gap-8">
                  <button type="button" id="gift-event-mobile-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="gift-event-mobile-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="border-bottom border-2 border-main-600 mb-3 mt-4 pt-5" style="width: 100%;"></div>
          </div>

          <div class="gift-event-mobile-slider arrow-style-two">
            @if ($quatang->isNotEmpty())
              @foreach ($quatang as $qt)
                @php
                  try {
                    $ketthucngay = \Carbon\Carbon::parse($qt->ngayketthuc);
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
                <div>
                  <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                    <a href="">
                      <div class="rounded-16 "
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/{{ $qt->hinhanh }}'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                        <div class="card-overlay rounded-16 transition-1"></div>
                      </div>
                      <div class="card-content mt-130 p-14 w-100">

                        <div class="title text-white-500 text-md fw-semibold mt-5 mb-5">
                          <a href="#" class="link text-line-2" style="color: white !important;"
                            tabindex="0">{{ $qt->tieude }}</a>
                        </div>

                        <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                          <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                          <span class="text-gray-500 text-xs">Còn lại <strong>{{ $countdownDisplay }}</strong></span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              @endforeach
            @endif



          </div>
        </div>
      </div>
    </section>
    <!-- ========================= QUÀ TẶNG End ================================ -->

    <div class="container container-lg mt-40 mb-40">
      <div class="row">
        <div class="col-lg-4">
          <div class="rounded-5">
            @if($promotionBanner1)
              <a href="{{ $promotionBanner1->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $promotionBanner1->hinhanh }}" alt=""
                  class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-14">
              </a>
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <div class="rounded-5">
            @if($promotionBanner2)
              <a href="{{ $promotionBanner2->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $promotionBanner2->hinhanh }}" alt=""
                  class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-14">
              </a>
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <div class="rounded-5">
            @if($promotionBanner3)
              <a href="{{ $promotionBanner3->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $promotionBanner3->hinhanh }}" alt=""
                  class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-14">
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- ========================= DANH MỤC HÀNG ĐẦU ================================ -->
    <section class="trending-products overflow-hidden fix-scale-80">
      <div class="container container-lg">
        <div class="border border-gray-100 py-24 px-10 rounded-8">
          <div class="section-heading mb-24">
            <div class="flex-between flex-align flex-wrap gap-8">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-squares-four text-main-600"></i> Danh mục hàng đầu</h6>
              <ul class="nav common-tab style-two nav-pills wow fadeInRight m-0" id="pills-tab" role="tablist">
                @if($danhsachdmhangdau->isNotEmpty())
                  @foreach($danhsachdmhangdau as $key => $danhmuc)
                    <li class="nav-item" role="presentation">
                      <button class="nav-link fw-medium text-sm hover-border-main-600 {{$loop->first ? 'active' : '' }}"
                        id="tab-{{ $danhmuc->id }}-mobile" data-bs-toggle="pill"
                        data-bs-target="#content-{{ $danhmuc->id }}-mobile" type="button" role="tab"
                        aria-controls="content-{{ $danhmuc->id }}-mobile" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                        {{ $danhmuc->ten}}
                      </button>
                    </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            @if($sanphamthuocdanhmuc->isNotEmpty())
              @foreach ($sanphamthuocdanhmuc as $categoryId => $products)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $categoryId }}-mobile"
                  role="tabpanel" aria-labelledby="tab-{{ $categoryId }}-mobile" tabindex="0">
                  <div class="row g-12">
                    @foreach ($products as $product)
                      <div class="col-xxl-2 col-xl-3 col-lg-4 col-xs-6">
                        <div
                          class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                          <a href="{{ route('chi-tiet-san-pham', $product->slug) }}"
                            class="flex-center rounded-8 bg-gray-50 position-relative">
                            <img src="{{ asset('assets/client/images/thumbs/' . $product->hinhanhsanpham->first()->hinhanh) }}"
                              alt="{{ $product->ten }}" class="w-100 rounded-top-2" />
                          </a>
                          <div
                            class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                            <div>
                              <h6 class="title text-lg fw-semibold mt-2 mb-2">
                                <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2"
                                  tabindex="0">{{ $product->ten }}</a>
                              </h6>
                              <div class="flex-align justify-content-between mt-2">
                                <div class="flex-align gap-6">
                                  <span class="text-xs fw-medium text-gray-500">4.8
                                    <i class="ph-fill ph-star text-warning-600"></i></span>
                                </div>
                                <div class="flex-align gap-4">
                                  <span
                                    class="text-xs fw-medium text-gray-500">{{ number_format($product->product_total_sales) }}</span>
                                  <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                                </div>
                              </div>
                            </div>

                            <div class="product-card__price mt-5">
                              @if ($product->giamgia > 0)
                                <div class="flex-align gap-4 text-main-two-600 text-sm">
                                  <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $product->giamgia }}%
                                  <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                                    {{ number_format($product->bienthe->giagoc, 0, ',', '.') }} đ
                                  </span>
                                </div>
                              @endif

                              <div class="text-heading text-md fw-semibold">
                                {{ number_format($product->giadagiam, 0, ',', '.') }} đ
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="mx-auto w-100 text-center">
                    <a href="{{ url('san-pham?sortby=top-' . $danhsachdmhangdau->firstWhere('id', $categoryId)->slug) }}"
                      class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
                      Xem thêm sản phẩm
                    </a>
                  </div>
                </div>

              @endforeach
            @else
              <div class="w-100 text-center py-10">
                <p class="text-lg text-gray-500">Hiện không có sản phẩm nào thuộc các danh mục hàng đầu đang được hiển thị.
                </p>
              </div>
            @endif


          </div>
        </div>
      </div>
    </section>
    <!-- ========================= DANH MỤC HÀNG ĐẦU End ================================ -->

    <div class="container container-lg mt-40 mb-40">
      <div class="text-center" style="height: 50%;" data-aos="fade-up" data-aos-duration="500">
        @if (isset($adsBanner))
          <a href="{{ $adsBanner->lienket }}" class="p-0 m-0 w-100 h-50">
            <img src="{{asset('assets/client')}}/images/bg/{{ $adsBanner->hinhanh }}" alt=""
              class="banner-img w-100 h-100 object-fit-cover rounded-10">
          </a>
        @endif

      </div>
    </div>

    <!-- ========================= THƯƠNG HIỆU HÀNG ĐẦU ================================ -->
    <section class="top-selling-products overflow-hidden mb-10 fix-scale-30">
      <div class="container container-lg">
        <div class="rounded-16">
          <div class="section-heading mb-24">
            <div class="flex-between">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-storefront text-main-600"></i> Thương hiệu hàng đầu
              </h6>
              {{-- <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 60%;"></div> --}}
              <div class="flex-align gap-16 wow fadeInRight">
                <div class="flex-align gap-8">
                  <button type="button" id="top-brand-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="top-brand-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-12">
            <div class="col-md-12">
              <div class="top-brand-slider arrow-style-two">
                @if ($topbrands->isNotEmpty())
                  @foreach ($topbrands as $topbrand)
                    <div data-aos="fade-up" data-aos-duration="200">
                      <div
                        class="product-card hover-card-shadows h-100 p-5 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white justify-content-center">
                        <a href="{{ $topbrand->slug }}" class="product-card__thumb flex-center rounded-8 position-relative"
                          style="height: 120px;">
                          <img src="{{asset('assets/client')}}/images/brands/{{ $topbrand->logo }}"
                            alt="{{ $topbrand->logo }}" class="object-fit-cover" style="width: 50%;" />
                        </a>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= THƯƠNG HIỆU HÀNG ĐẦU End ================================ -->

    <!-- ========================= SẢN PHẨM HÀNG ĐẦU ================================ -->
    <section class="sanphamhangdau pt-20 overflow-hidden fix-scale-30 pb-40 ">
      <div class="container container-lg px-0">
        <div class="pr-20 py-16 px-0">
          <div class="section-heading mb-24 px-10">
            <div class="flex-between flex-wrap gap-2">
              <h6 class="mb-0 wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft;"><i
                  class="ph-bold ph-package text-main-600"></i> Sản phẩm hàng đầu</h6>
              <div class="flex-align gap-16 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                <div class="flex-align gap-8">
                  <button type="button" id="sphd-prev"
                    class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                    <i class="ph ph-caret-left"></i>
                  </button>
                  <button type="button" id="sphd-next"
                    class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-neutral-600 text-xl hover-bg-neutral-600 hover-text-white transition-1">
                    <i class="ph ph-caret-right"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="border-bottom border-2 border-main-600 mb-3 mt-4 pt-5" style="width: 100%;"></div>
          </div>
          <div class="row g-12">
            <div class="col-md-12">
              <div class="san-pham-hang-dau-slider arrow-style-two">
                @foreach ($topproducts as $td)
                  <div data-aos="fade-up" data-aos-duration="1000">
                    <div
                      class="product-card border border-gray-100 bg-white hover-card-shadows h-100 rounded-10 position-relative transition-2">

                      <a href="{{ route('chi-tiet-san-pham', $td->slug) }}"
                        class="thumbhover flex-center rounded-10 position-relative bg-gray-50 w-100">
                        @if($td->giamgia > 0)
                          <span
                            class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Giảm
                            {{ $td->giamgia }}%
                          </span>
                        @endif
                        <div class="w-100">
                          <img src="{{asset('assets/client')}}/images/thumbs/{{ $td->hinhanhsanpham->first()->hinhanh }}"
                            alt="{{ $td->hinhanhsanpham->first()->hinhanh }}" class=""
                            style="width: 100%; height: 150px; object-fit: cover; border-top-left-radius:10px; border-top-right-radius:10px;" />
                        </div>
                      </a>
                      <div class="product-card__content w-100 px-12 pb-16 mt-5">
                        <div class="flex-align justify-content-between mt-5">
                          <div class="flex-align gap-4 w-100">
                            <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                            <span class="text-gray-500 text-xs"
                              style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                              title="{{ $td->thuonghieu->ten }}">{{ $td->thuonghieu->ten }}</span>
                          </div>
                        </div>
                        <h6 class="title text-lg fw-semibold mt-5 mb-8">
                          <a href="{{ route('chi-tiet-san-pham', $td->slug) }}" class="link text-line-2"
                            tabindex="0">{{ $td->ten }}</a>
                        </h6>
                        <div class="flex-wrap flex-align justify-content-between mt-5">
                          <div class="flex-align gap-6">
                            <span class="text-xs fw-medium text-gray-500 flex-align gap-4"><i
                                class="ph-fill ph-star text-warning-600 text-sm "></i> 4,7 (12)</span>
                          </div>
                          <div class="flex-align gap-4">
                            <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                            <span class="text-xs fw-medium text-gray-500">{{ $td->bienthe_sum_luotban }}</span>
                          </div>
                        </div>
                        <div class="product-card__price mt-5">
                          <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">
                            {{ number_format($td->bienthe->giagoc, 0, ',', '.') }} ₫</span>
                          <div class="text-heading text-md fw-semibold">{{ number_format($td->giadagiam, 0, ',', '.') }} ₫
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= SẢN PHẨM HÀNG ĐẦU End ================================ -->

    <!-- MÃ GIẢM GIÁ -->
    <div class="">
      <div class="container container-lg">
        <div class="border border-main-500 bg-main-50 border-dashed rounded-8 py-20 px-10 flex-center flex-wrap gap-12">
          <p class="h6 text-main-600 fw-normal">Super discount for your <a href="javascript:void(0)"
              class="fw-bold text-decoration-underline text-main-600 hover-text-decoration-none hover-text-primary-600 ">first
              purchase</a> </p>
          <div class="position-relative">
            <button
              class="copy-coupon-btn px-32 py-10 text-white text-uppercase bg-main-600 rounded-pill border-0 hover-bg-main-800">
              FREE25BAC
              <i class="ph ph-file-text text-lg line-height-1"></i>
            </button>
            <span
              class="copy-text bg-main-600 text-white fw-normal position-absolute px-16 py-6 rounded-pill bottom-100 start-50 translate-middle-x min-w-max mb-8 text-xs"
              style="display: none;">Copied</span>
          </div>
          <p class="text-md text-main-600 fw-normal">Use discount code to get <span class="fw-bold text-main-600">20%
            </span> discount for any item</p>
        </div>
      </div>
    </div>
    <!-- Super Discount End -->

    <!-- ========================= HÀNG MỚI CHÀO SÂN ================================ -->
    <section class="trending-productss pt-40 overflow-hidden fix-scale-100">
      <div class="container container-lg overflow-hidden">
        <div class="">
          <div class="section-heading mb-24">
            <div class="flex-between flex-wrap gap-2">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-waving text-main-600"></i> Hàng mới chào sân
              </h6>
              <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 80%;"></div>
            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
              tabindex="0">
              <div class="row g-12">
                @foreach ($hangmoichaosan as $product)
                  <div class="col-xxl-2 col-xl-3 col-lg-4 col-xs-6">
                    <div
                      class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                      <a href="{{ route('chi-tiet-san-pham', $product->slug) }}"
                        class="flex-center rounded-8 bg-gray-50 position-relative">
                        <img src="{{ asset('assets/client/images/thumbs/' . $product->hinhanhsanpham->first()->hinhanh) }}"
                          alt="{{ $product->ten }}" class="w-100 rounded-top-2" />
                      </a>
                      <div
                        class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                        <div>
                          <div class="flex-align justify-content-between mt-5">
                            <div class="flex-align gap-4 w-100">
                              <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                              <span class="text-gray-500 text-xs"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                                title="{{ $product->thuonghieu->ten }}">{{ $product->thuonghieu->ten }}</span>
                            </div>
                          </div>
                          <h6 class="title text-lg fw-semibold mt-2 mb-2">
                            <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2"
                              tabindex="0">{{ $product->ten }}</a>
                          </h6>
                          <div class="flex-align justify-content-between mt-2">
                            <div class="flex-align gap-6">
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
                            <div class="flex-align gap-4 text-main-two-600 text-sm">
                              <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $product->giamgia }}%
                              <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                                {{ number_format($product->bienthe->giagoc, 0, ',', '.')}} đ
                              </span>
                            </div>
                          @endif
                          <div class="text-heading text-md fw-semibold">
                            {{ number_format($product->giadagiam, 0, ',', '.')}} đ
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="mx-auto w-100 text-center" data-aos="fade-up" data-aos-duration="200">
              <a href="{{ url('san-pham?sortby=latest') }}"
                class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
                Xem thêm sản phẩm
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- ========================= HÀNG MỚI CHÀO SÂN End ================================ -->

    <!-- ========================= CÓ THỂ BẠN YÊU THÍCH ================================ -->
    <section class="trending-productss pt-40 overflow-hidden fix-scale-80">
      <div class="container container-lg overflow-hidden">
        <div class="">
          <div class="section-heading mb-24">
            <div class="flex-between flex-wrap gap-2">
              <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-withdraw text-main-600"></i> Được quan tâm nhiều
                nhất
              </h6>
              <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 75%;"></div>

            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
              tabindex="0">
              <div class="row g-12">
                @foreach ($likeProducts as $product)
                  <div class="col-xxl-2 col-xl-3 col-lg-4 col-xs-6">
                    <div
                      class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                      <a href="{{ route('chi-tiet-san-pham', $product->slug) }}"
                        class="flex-center rounded-8 bg-gray-50 position-relative">
                        <img src="{{ asset('assets/client/images/thumbs/' . $product->hinhanhsanpham->first()->hinhanh) }}"
                          alt="{{ $product->ten }}" class="w-100 rounded-top-2" />
                      </a>
                      <div
                        class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                        <div>
                          <div class="flex-align justify-content-between mt-5">
                            <div class="flex-align gap-4 w-100">
                              <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                              <span class="text-gray-500 text-xs"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;"
                                title="{{ $product->thuonghieu->ten }}">{{ $product->thuonghieu->ten }}</span>
                            </div>
                          </div>
                          <h6 class="title text-lg fw-semibold mt-2 mb-2">
                            <a href="{{ route('chi-tiet-san-pham', $product->slug) }}" class="link text-line-2"
                              tabindex="0">{{ $product->ten }}</a>
                          </h6>
                          <div class="flex-align justify-content-between mt-2">
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
                            <div class="flex-align gap-4 text-main-two-600 text-sm">
                              <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $product->giamgia }}%
                              <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                                {{ number_format($product->bienthe->giagoc, 0, ',', '.')}} đ
                              </span>
                            </div>
                          @endif
                          <div class="text-heading text-md fw-semibold">
                            {{ number_format($product->giadagiam, 0, ',', '.')}} đ
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="mx-auto w-100 text-center" data-aos="fade-up" data-aos-duration="200">
              <a href="{{ url('san-pham?sortby=quantamnhieunhat') }}"
                class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
                Xem thêm sản phẩm
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container container-lg overflow-hidden mb-20">
        <div class="section-heading mb-24">
          <div class="flex-between flex-wrap gap-2">
            <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-withdraw text-main-600"></i> Nhiều bài viết cần bạn
              khám phá
            </h6>
            <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 71%;"></div>

          </div>
        </div>
        <div class="row gy-4">
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-3 col-xl-3 col-sm-6 col-xs-6">
            <div class="border border-gray-100 hover-border-main-600 rounded-6 transition-1">
              <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                class="flex-center rounded-8 bg-gray-50 position-relative">
                <img src="{{ asset('assets/client') }}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp"
                  alt="" class="w-100 rounded-top-2" style="height: 230px; object-fit: cover;" />
              </a>
              <div
                class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}" class="link text-line-2" tabindex="0">Ưu đãi cùng
                    Siêu
                    Thị Vina, xem ngày đừng chờ đợi nhé</a>
                </h6>
                <div class="flex-align justify-content-between mt-2">
                  <div class="flex-align gap-6">
                    <span class="text-xs fw-medium text-gray-500"><i class="ph-bold ph-calendar-blank"></i>
                      25/06/2025</span>
                  </div>

                </div>
                <span class="mt-10 text-gray-600 text-sm fw-normal">
                  Mô tả ngắn về bài viết để thu hút người đọc quan tâm và nhấp vào xem chi tiết...
                </span>
                <div class="flex-align gap-12 mt-10">
                  <a href="{{ route('chi-tiet-bai-viet', 'slug') }}"
                    class="text-sm fw-semibold text-main-600 hover-text-decoration-underline transition-1">
                    Đọc thêm <i class="ph-bold ph-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ========================= CÓ THỂ BẠN YÊU THÍCH end ================================ -->
  </div>

@endsection