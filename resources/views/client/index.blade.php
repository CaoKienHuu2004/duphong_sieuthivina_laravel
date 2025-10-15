@extends('client.layouts.app')

@section('title','Siêu Thị Vina | Sàn thương mại điện tử bán hàng trực tuyến Siêu Thị Vina')

@section('content')

  <div class="page">
      <!-- ============================ Banner Section start =============================== -->
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
                @if ($home_banner_slider->isNotEmpty())
                  @foreach ($home_banner_slider as $banner)
                    <a href="{{ $banner->lienket }}" class="d-flex align-items-center justify-content-between flex-wrap-reverse flex-sm-nowrap gap-32">
                    <img src="{{asset('assets/client')}}/images/bg/{{ $banner->hinhanh }}" alt="{{ $banner->hinhanh }}" class=" d-lg-block d-none rounded-5"
                      style="width: 100%; height: 350px; object-fit: cover;" />
                    <img src="{{asset('assets/client')}}/images/bg/{{ $banner->hinhanh }}" alt="{{ $banner->hinhanh }}" class=" d-block d-lg-none rounded-5"
                      style="width: 100%; height: 300px; object-fit: cover;" />
                  </a>
                  @endforeach
                @else
                  <a href="#" class="d-flex align-items-center justify-content-between flex-wrap-reverse flex-sm-nowrap gap-32">
                    <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class=" d-lg-block d-none rounded-5"
                      style="width: 100%; height: 350px; object-fit: cover;" />
                    <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="shopee-3.jpg" class=" d-block d-lg-none rounded-5"
                      style="width: 100%; height: 300px; object-fit: cover;" />
                  </a>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 mt-20 ps-10 pe-5 d-lg-block d-none">
          <div class="row g-24 me-0">
            @if ($home_banner_event_1)
              <a href="{{ $home_banner_event_1->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_1->hinhanh }}" alt="{{ $home_banner_event_1->hinhanh }}" class="p-0 rounded-5"
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
            @if ($home_banner_event_2)
              <a href="{{ $home_banner_event_2->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_2->hinhanh }}" alt="{{ $home_banner_event_2->hinhanh }}" class="p-0 rounded-5"
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
            @if ($home_banner_event_3)
              <a href="{{ $home_banner_event_3->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_3->hinhanh }}" alt="{{ $home_banner_event_3->hinhanh }}" class="p-0 rounded-5"
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
            @if ($home_banner_event_4)
              <a href="{{ $home_banner_event_4->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_4->hinhanh }}" alt="{{ $home_banner_event_4->hinhanh }}" class="p-0 rounded-5"
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
    <div class="container">
      <!-- ============================ 4 ảnh thumb tĩnh dành cho mobile=============================== -->
        <div class="col-12 col-lg-3 mt-20 d-lg-none d-block">
          <div class="">
            @if ($home_banner_event_1)
              <a href="{{ $home_banner_event_1->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_1->hinhanh }}" alt="{{ $home_banner_event_1->hinhanh }}" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @else
                <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif
          </div>
          <div class=" mt-24">
            @if ($home_banner_event_2)
              <a href="{{ $home_banner_event_2->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_2->hinhanh }}" alt="{{ $home_banner_event_2->hinhanh }}" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
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
            @if ($home_banner_event_3)
              <a href="{{ $home_banner_event_3->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_3->hinhanh }}" alt="{{ $home_banner_event_3->hinhanh }}" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif
          </div>
          <div class=" mt-24">
            @if ($home_banner_event_4)
              <a href="{{ $home_banner_event_4->lienket }}" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/{{ $home_banner_event_4->hinhanh }}" alt="{{ $home_banner_event_4->hinhanh }}" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @else
              <a href="#" class="p-0 m-0">
                <img src="{{asset('assets/client')}}/images/bg/shopee-3.jpg" alt="Thumb" class="p-0 rounded-5"
                  style="width: 100%; object-fit: cover;" />
              </a>
            @endif
          </div>
        </div>
        <!-- ============================endsection ảnh thumb tĩnh dành cho mobile=============================== -->
    </div>
  </div>
  <!-- ============================ Banner Section End =============================== -->

  <!-- ============================ promotional banner Start ========================== -->
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
          @foreach ($danhsachdanhmuc as $dsdm)
            <div class="feature-item text-center wow bounceIn" data-aos="fade-up" data-aos-duration="400">
              <div class="feature-item__thumb rounded-circle">
                <a href="{{ route('trang-chu',$dsdm->slug) }}" class="w-100 h-100 p-10 flex-center">
                  <img src="{{asset('assets/client')}}/images/categories/{{ $dsdm->logo }}" alt="{{ $dsdm->ten }}">
                </a>
              </div>
              <div class="feature-item__content mt-16">
                <h6 class="text-md fw-medium mb-8"><a href="#" class="text-inherit">{{ $dsdm->ten }}</a></h6>
              </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
  <!-- ============================ promotional banner End ========================== -->

  <!-- ========================= Top Selling Products Start ================================ -->
  <section class="top-selling-products pt-20 overflow-hidden fix-scale-30">
    <div class="container container-lg px-0">
      <div class="border border-gray-100 pr-20 p-16 rounded-10 bg-hotsales">
        <div class="section-heading mb-24">
          <div class="flex-between flex-wrap gap-8">
            <h6 class="mb-0 wow fadeInLeft text-white">
              <img src="{{asset('assets/client')}}/images/thumbs/top-deal-sieu-re.png" alt="" class="w-50 py-10 d-lg-block d-none">
              <img src="{{asset('assets/client')}}/images/thumbs/top-deal-sieu-re.png" alt="" class="py-10 d-lg-none d-block" width="70%">
            </h6>
            <div class="flex-align gap-16 wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
              <a href="shop.html"
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
              @foreach ($topDeals as $td)
                <div data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card bg-white hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-10 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 position-relative bg-gray-50 border border-gray-200">
                    @if($td->giamgia > 0)
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Giảm
                      {{ $td->giamgia }}%
                    </span>
                    @endif
                    <div class="w-100">
                      <img src="{{asset('assets/client')}}/images/thumbs/{{ $td->hinhanhsanpham->first()->hinhanh }}" alt="{{ $td->hinhanhsanpham->first()->hinhanh }}" class="rounded-8" style="width: 100%; height: 200px; object-fit: cover;" />
                    </div>
                  </a>
                  <div class="product-card__content w-100  mt-5">


                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4 w-100">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;" title="{{ $td->thuonghieu->ten }}">{{ $td->thuonghieu->ten }}</span>
                      </div>

                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">{{ $td->ten }}</a>
                    </h6>

                    <div class="flex-wrap flex-align justify-content-between mt-5">
                      <div class="flex-align gap-6">
                        <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                        <span class="text-xs fw-medium text-gray-500">nullable <i
                            class="ph-fill ph-star text-warning-600"></i></span>
                      </div>
                      <div class="flex-align gap-4">
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">{{ $td->luotban }}</span>
                      </div>
                    </div>





                    <div class="product-card__price mt-5">
                      <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">
                        {{ number_format($td->giagoc, 0, ',', '.') }} ₫</span>
                      <span class="text-heading text-md fw-semibold">{{ number_format($td->gia_dagiam, 0, ',', '.') }} ₫</span>
                    </div>


                    <!-- <a href="cart.html"
                      class="product-card__cart btn bg-gray-50 text-heading hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-center gap-8 fw-medium"
                      tabindex="0">
                      Thêm <i class="ph ph-shopping-cart"></i>
                    </a> -->
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
  <!-- ========================= Top Selling Products End ================================ -->

  <!-- ========================= Deals Week Start ================================ -->
<section class="deals-weeek pt-10 overflow-hidden fix-scale-30">
    <div class="container container-lg px-0">
        <div class="">
            <div class="section-heading mb-24">
                <div class="flex-between flex-align flex-wrap gap-8 w-100">
                    <h6 class="mb-0 wow fadeInLeft flex-align gap-8"><i class="ph-bold ph-gift text-main-600"></i> Quà tặng</h6>
                    <div class="border-bottom border-2 border-main-600 mb-3 mt-4" style="width: 77%;"></div>
                    <div class="flex-align gap-16 wow fadeInRight">
                        <a href="{{ route('sanpham') }}" class="text-sm fw-semibold text-main-600 hover-text-main-600 hover-text-decoration-underline">Xem tất cả</a>
                        <div class="flex-align gap-8">
                            <button type="button" id="gift-event-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1" >
                                <i class="ph ph-caret-left"></i>
                            </button>
                            <button type="button" id="gift-event-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1" >
                                <i class="ph ph-caret-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gift-event-slider arrow-style-two">
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>
                <div>
                    <div class="product-card p-card border border-gray-100 rounded-16 position-relative transition-2">
                      <a href="">
                      <div class="rounded-16 " style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('assets/client/images/thumbs/keo-ong-xanh-tracybee-propolis-mint-honey-giam-dau-rat-hong-ho-viem-hong-vi-bac-ha-2.webp'); background-size: cover; background-repeat: no-repeat; z-index: 1; background-position: center;">
                          <div class="card-overlay rounded-16 transition-1"></div> </div>
                      <div class="card-content mt-210 p-14 w-100">
                          
                            <div class="title text-white-500 text-lg fw-semibold mt-5 mb-5">
                                <a href="product-details-two.html" class="link text-line-2" style="color: white !important;" tabindex="0">Tặng 1 sản phẩm bất kỳ</a>
                            </div>
                            
                            <div class="flex-align gap-4 bg-gray-50 p-5 rounded-8">
                              <span class="text-main-600 text-md d-flex"><i class="ph-bold ph-timer"></i></span>
                              <span class="text-gray-500 text-xs">Còn lại <strong>2</strong> ngày <strong>11</strong> giờ</span>
                            </div>
                      </div>
                      </a>
                  </div>
                </div>


            </div>
        </div>
    </div>
</section>
<!-- ========================= Deals Week End ================================ -->

  <div class="container container-lg mt-10 mb-70 px-0">
    <div class="row">
      <div class="col-lg-4">
        <div class="rounded-5">
          <a href="#" class="p-0 m-0">
            <img src="{{asset('assets/client')}}/images/bg/shopee-04.webp" alt=""
              class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-10">
          </a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="rounded-5">
          <a href="#" class="p-0 m-0">
            <img src="{{asset('assets/client')}}/images/bg/shopee-06.jpg" alt=""
              class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-10">
          </a>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="rounded-5">
          <a href="#" class="p-0 m-0">
            <img src="{{asset('assets/client')}}/images/bg/shopee-07.jpg" alt=""
              class="banner-img w-100 h-100 object-fit-cover rounded-10 mb-10">
          </a>
        </div>
      </div>
    </div>
  </div>



  <!-- ========================= Trending Products Start ================================ -->
  <section class="trending-productss overflow-hidden mt-10 fix-scale-80">
    <div class="container container-lg px-0">
      <div class="border border-gray-100 p-24 rounded-16">
        <div class="section-heading mb-24">
          <div class="flex-between flex-align flex-wrap gap-8">
            <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-squares-four text-main-600"></i> Danh mục hàng đầu</h6>
            <ul class="nav common-tab style-two nav-pills wow fadeInRight m-0" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600 active" id="pills-all-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                  aria-selected="true">
                  All
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-mobile-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-mobile" type="button" role="tab"
                  aria-controls="pills-mobile" aria-selected="false">
                  Mobile
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-headphone-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-headphone" type="button" role="tab"
                  aria-controls="pills-headphone" aria-selected="false">
                  Headphone
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-usb-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-usb" type="button" role="tab" aria-controls="pills-usb"
                  aria-selected="false">
                  USB
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-camera-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-camera" type="button" role="tab"
                  aria-controls="pills-camera" aria-selected="false">
                  Camera
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-laptop-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-laptop" type="button" role="tab"
                  aria-controls="pills-laptop" aria-selected="false">
                  Laptop
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-accessories-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-accessories" type="button" role="tab"
                  aria-controls="pills-accessories" aria-selected="false">
                  Accessories
                </button>
              </li>
            </ul>
          </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
            tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/sanpham-2.webp" alt="" class="w-100 rounded-8" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <div class="flex-align justify-content-between mt-5">
                      <div class="flex-align gap-4">
                        <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                        <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                      </div>
                      <div class="flex-align gap-4">

                        <!-- <span class="text-xs fw-medium text-gray-500">|</span> -->
                        <span class="text-xs fw-medium text-gray-500">Đã bán</span>
                        <span class="text-xs fw-medium text-gray-500">25k</span>
                      </div>
                    </div>

                    <h6 class="title text-lg fw-semibold mt-5 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Thuốc hoạt huyết Nhất
                        Nhất - tăng cường lưu thông máu lên não</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <span class="text-xs fw-medium text-gray-500">Đánh giá</span>
                      <span class="text-xs fw-medium text-gray-500">4.8 <i
                          class="ph-fill ph-star text-warning-600"></i></span>
                      <!-- <span class="text-xs fw-medium  d-flex"></span> -->
                      <span class="text-xs fw-medium text-gray-500">(17k)</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>




            </div>
          </div>
          <div class="tab-pane fade" id="pills-mobile" role="tabpanel" aria-labelledby="pills-mobile-tab" tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">New</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img3.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-success-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Sold</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img4.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img5.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img6.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-headphone" role="tabpanel" aria-labelledby="pills-headphone-tab"
            tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">New</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img3.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-success-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Sold</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img4.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img5.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img6.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-usb" role="tabpanel" aria-labelledby="pills-usb-tab" tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">New</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img3.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-success-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Sold</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img4.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img5.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img6.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-camera" role="tabpanel" aria-labelledby="pills-camera-tab" tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">New</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img3.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-success-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Sold</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img4.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img5.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img6.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-laptop" role="tabpanel" aria-labelledby="pills-laptop-tab" tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">New</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img3.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-success-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Sold</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img4.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img5.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img6.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-accessories" role="tabpanel" aria-labelledby="pills-accessories-tab"
            tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="400">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-warning-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">New</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="600">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img3.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="800">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-success-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Sold</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img4.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1000">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img5.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
              <div class="col-xxl-2 col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="1200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img6.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100  mt-16">
                    <span class="text-success-600 bg-success-50 text-sm fw-medium py-4 px-8">19%OFF</span>
                    <h6 class="title text-lg fw-semibold my-16">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>
                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>

                    <span
                      class="py-2 px-8 text-xs rounded-pill text-main-two-600 bg-main-two-50 mt-16 fw-normal">Fulfilled
                      by Marketpro</span>

                    <div class="product-card__price mt-16 mb-30">
                      <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                        $28.99</span>
                      <span class="text-heading text-md fw-semibold">$14.99
                        <span class="text-gray-500 fw-normal">/Qty</span>
                      </span>
                    </div>
                    <span class="text-neutral-600 text-xs fw-medium">Delivered by
                      <span class="text-main-600">Aug 02</span></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mx-auto w-100 text-center" data-aos="fade-up" data-aos-duration="200">
            <a href="shop.html"
              class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
              Xem thêm sản phẩm
            </a>
          </div>
      </div>
    </div>
  </section>
  <!-- ========================= Trending Products End ================================ -->
  <div class="container container-lg mt-10 mb-10 px-0">
    <div class="text-center" style="height: 50%;" data-aos="fade-up" data-aos-duration="500">
      <a href="#" class="p-0 m-0 w-100 h-50">
        <img src="{{asset('assets/client')}}/images/bg/shopee-07.jpg" alt="" class="banner-img w-100 h-100 object-fit-cover rounded-10">
      </a>
    </div>
  </div>

  <!-- ========================= Top Selling Products Start ================================ -->
  <section class="top-selling-products overflow-hidden mb-10 fix-scale-30">
    <div class="container container-lg px-0">
      <div class="rounded-16">
        <div class="section-heading mb-24">
          <div class="flex-between flex-wrap gap-8">
            <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-storefront text-main-600"></i> Thương hiệu hàng đầu
            </h6>
            <div class="flex-align gap-16 wow fadeInRight">
              <a href="shop.html"
                class="text-sm fw-semibold text-gray-700 hover-text-main-600 hover-text-decoration-underline">Xem đầy
                đủ</a>
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
          <!-- <div class="col-md-4" data-aos="zoom-in" data-aos-duration="800">
            <div class="position-relative rounded-16 overflow-hidden p-28 z-1 text-center bg-main-100 h-100">
              <div class="py-xl-4">
                <h6 class="mb-8 fw-bold">Polaroid Now+ Gen 2 - White</h6>
                <h6 class="mb-8 fw-bold">
                  Get <span class="text-main-600">35%</span> off
                </h6>
                <a href="cart.html"
                  class="btn text-heading border-white bg-white py-16 px-24 flex-center d-inline-flex rounded-pill gap-8 fw-medium hover-bg-main-600 hover-bg-main-two-600 hover-border-main-two-600 hover-text-white mt-24"
                  tabindex="0">
                  Shop Now <i class="ph ph-shopping-cart text-xl d-flex"></i>
                </a>
              </div>
              <div class="d-md-block d-none mt-36">
                <img src="{{asset('assets/client')}}/images/thumbs/deal-img.png" alt="" />
              </div>
            </div>
          </div> -->
          <div class="col-md-12">
            <div class="top-brand-slider arrow-style-two">
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Cửa Hàng Thương Hiệu TRUNG NHÂN</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/eco.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Công Ty Dược ECO 2020</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
              <div data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card hover-card-shadows h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2 bg-white">
                  <a href="product-details-two.html" class="product-card__thumb flex-center rounded-8 position-relative"
                    style="height: 150px;">
                    <img src="{{asset('assets/client')}}/images/brands/trung-nhan.jpg" alt="" class="w-50 object-fit-cover" />
                  </a>
                  <div class="product-card__content w-100  mt-5">
                    <!-- <div class="flex-align justify-content-center gap-6">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div> -->
                    <h6 class="title text-lg text-center fw-semibold mt-12 mb-8">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Vinamilk chính hãng EST
                        1997</a>
                    </h6>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ========================= Top Selling Products End ================================ -->

  <section class="featured-products overflow-hidden py-10">
    <div class="container container-lg px-0">
      <div class="row g-4 flex-wrap-reverse">
        <div class="col-xxl-8">
          <div class="border border-gray-100 p-24 rounded-16">
            <div class="section-heading mb-24">
              <div class="flex-between flex-wrap gap-8">
                <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-package text-main-600"></i> Sản phẩm hàng đầu</h6>
                <div class="flex-align gap-16 wow fadeInRight">
                  <a href="shop.html"
                    class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">Xem đầy
                    đủ</a>
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
              <div class="col-xxl-6">
                <div class="featured-products__sliders">
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-6">
                <div class="featured-products__sliders">
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-6">
                <div class="featured-products__sliders">
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-6">
                <div class="featured-products__sliders">
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="" data-aos="fade-up" data-aos-duration="800">
                    <div
                      class="mt-24 product-card d-flex gap-16 p-10 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                      <a href="product-details-two.html"
                        class="product-card__thumb flex-center h-unset rounded-8 position-relative w-unset flex-shrink-0 p-24"
                        tabindex="0">
                        <img src="{{asset('assets/client')}}/images/thumbs/product-two-img2.png" alt="" class="w-auto max-w-unset" />
                      </a>
                      <div class="product-card__content w-100  my-20 flex-grow-1">
                        <div class="flex-align gap-4">
                          <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                          <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                        </div>
                        <h6 class="title text-lg fw-semibold mb-12">
                          <a href="product-details-two.html" class="link text-line-2" tabindex="0">iPhone 15 Pro Warp
                            Charge 30W Power Adapter</a>
                        </h6>
                        <div class="flex-align gap-6 mb-12">
                          <span class="text-xs fw-medium text-gray-500">4.8</span>
                          <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                          <span class="text-xs fw-medium text-gray-500">(17k)</span>
                        </div>

                        <div class="product-card__price my-10">
                          <span class="text-gray-400 text-md fw-semibold text-decoration-line-through">
                            400.000 đ</span>
                          <span class="text-heading text-md fw-semibold">300.000 đ
                          </span>
                        </div>

                        <a href="cart.html"
                          class="product-card__cart btn bg-gray-50 text-heading text-md hover-bg-main-600 hover-text-white py-11 px-24 rounded-8 flex-center gap-8 fw-medium"
                          tabindex="0">
                          Thêm <i class="ph ph-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>

        <div class="col-xxl-4">
          <div class="position-relative rounded-16 bg-light-purple overflow-hidden p-28 pb-0 z-1 text-center h-100"
            data-aos="fade-up" data-aos-duration="1000">
            <img src="{{asset('assets/client')}}/images/bg/shopee-09.jfif" alt=""
              class="position-absolute inset-block-start-0 inset-inline-start-0 z-n1 w-100 h-100 cover-img" />

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Super Discount Start -->
  <div class="">
    <div class="container container-lg px-0">
      <div
        class="border border-main-500 bg-main-50 border-dashed rounded-8 py-20 d-flex align-items-center justify-content-evenly">
        <p class="h6 text-main-600 fw-normal">
          Áp dụng mã giảm giá ưu đãi cho
          <a href="#"
            class="fw-bold text-decoration-underline text-main-600 hover-text-decoration-none hover-text-primary-600">
            mọi thành viên</a>
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

  <!-- ========================= Trending Products Start ================================ -->
  <section class="trending-productss pt-60 overflow-hidden">
    <div class="container container-lg px-0">
      <div class="">
        <div class="section-heading mb-24">
          <div class="flex-between flex-wrap gap-8">
            <h6 class="mb-0 wow fadeInLeft"><i class="ph-bold ph-hand-withdraw text-main-600"></i> Có thể bạn quan tâm
            </h6>
            <!-- <ul class="nav common-tab style-two nav-pills wow fadeInRight" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600 active" id="pills-all-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                  aria-selected="true">
                  All
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-mobile-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-mobile" type="button" role="tab"
                  aria-controls="pills-mobile" aria-selected="false">
                  Mobile
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-headphone-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-headphone" type="button" role="tab"
                  aria-controls="pills-headphone" aria-selected="false">
                  Headphone
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-usb-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-usb" type="button" role="tab" aria-controls="pills-usb"
                  aria-selected="false">
                  USB
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-camera-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-camera" type="button" role="tab"
                  aria-controls="pills-camera" aria-selected="false">
                  Camera
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-laptop-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-laptop" type="button" role="tab"
                  aria-controls="pills-laptop" aria-selected="false">
                  Laptop
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link fw-medium text-sm hover-border-main-600" id="pills-accessories-tab"
                  data-bs-toggle="pill" data-bs-target="#pills-accessories" type="button" role="tab"
                  aria-controls="pills-accessories" aria-selected="false">
                  Accessories
                </button>
              </li>
            </ul> -->
          </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab"
            tabindex="0">
            <div class="row g-12">
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-4 col-sm-6 py-10" data-aos="fade-up" data-aos-duration="200">
                <div
                  class="product-card h-100 p-16 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">

                  <a href="product-details-two.html"
                    class="product-card__thumb flex-center rounded-8 bg-gray-50 position-relative">
                    <span
                      class="product-card__badge bg-main-600 px-8 py-4 text-sm text-white position-absolute inset-inline-start-0 inset-block-start-0">Top
                      deal</span>
                    <img src="{{asset('assets/client')}}/images/thumbs/product-two-img1.png" alt="" class="w-auto max-w-unset" />
                  </a>
                  <div class="product-card__content w-100 mt-5">
                    <!--  -->
                    <h6 class="title text-lg fw-semibold my-10">
                      <a href="product-details-two.html" class="link text-line-2" tabindex="0">Instax Mini 12 Instant
                        Film Camera - Green</a>
                    </h6>

                    <div class="flex-align gap-6">
                      <div class="flex-align gap-2">
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                        <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                      </div>
                      <span class="text-xs fw-medium text-gray-500">4.8</span>
                      <span class="text-xs fw-medium text-gray-500">(12K)</span>
                    </div>
                    <div class="flex-align gap-4 my-5">
                      <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                      <span class="text-gray-500 text-xs">Siêu thị Vina</span>
                    </div>

                    <div class="product-card__price mt-10">
                      <div class="flex-align gap-4 text-main-two-600">
                        <i class="ph-fill ph-seal-percent text-xl"></i> -10% <span
                          class="text-gray-400 text-sm fw-semibold text-decoration-line-through">
                          450.000 đ</span>
                      </div>

                      <span class="text-heading text-lg fw-semibold">300.000 đ

                      </span>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mx-auto w-100 text-center" data-aos="fade-up" data-aos-duration="200">
            <a href="shop.html"
              class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 mt-40">
              Xem thêm sản phẩm
            </a>
          </div>

        </div>
      </div>
    </div>
  </section>
  <!-- ========================= Trending Products End ================================ -->
</div>

@endsection

