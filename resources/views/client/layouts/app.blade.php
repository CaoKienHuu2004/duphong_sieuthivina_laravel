<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-sticky-style">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Title -->
  <title>@yield('title')</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" />

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/bootstrap.min.css" />
  <!-- select 2 -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/select2.min.css" />
  <!-- Slick -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/slick.css" />
  <!-- Jquery Ui -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/jquery-ui.css" />
  <!-- animate -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/animate.css" />
  <!-- AOS Animation -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/aos.css" />
  <!-- Main css -->
  <link rel="stylesheet" href="{{asset('assets/client')}}/css/main.css" />
</head>

<body>
  <!--==================== Preloader Start ====================-->
  <div class="preloader">
    <img src="{{asset('assets/client')}}/images/icon/preloader.gif" alt="" />
  </div>
  <!--==================== Preloader End ====================-->

  <!--==================== Overlay Start ====================-->
  <div class="overlay"></div>
  <!--==================== Overlay End ====================-->

  <!--==================== Sidebar Overlay End ====================-->
  <div class="side-overlay"></div>
  <!--==================== Sidebar Overlay End ====================-->

  <!-- ==================== Scroll to Top End Here ==================== -->
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
  <!-- ==================== Scroll to Top End Here ==================== -->

  <!-- ==================== Search Box Start Here ==================== -->
  
  <!-- ==================== Search Box End Here ==================== -->

  <!-- ==================== Mobile Menu Start Here ==================== -->
  <div class="mobile-menu scroll-sm d-lg-none d-block">
    <button type="button" class="close-button">
      <i class="ph ph-x"></i>
    </button>
    <div class="mobile-menu__inner logo">
      <a href="{{ route('trang-chu') }}" class="mobile-menu__logo">
        <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt="Logo" />
      </a>
      <div class="mobile-menu__menu">
        <!-- Nav Menu Start -->
        <ul class="nav-menu flex-align nav-menu--mobile">

          <li class="nav-menu__item">
            <form action="{{ route('tim-kiem') }}" class="position-relative w-100">
              <input type="text"
                name="query"
                class="form-control text-sm fw-medium placeholder-italic shadow-none bg-neutral-30 placeholder-fw-medium placeholder-light py-10 ps-20 pe-60"
                placeholder="{{ $tukhoaplaceholder }}...">
              <button type="submit"
                class="position-absolute top-50 translate-middle-y text-main-600 end-0 me-36 text-xl line-height-1">
                <i class="ph-bold ph-magnifying-glass"></i>
              </button>
            </form>
          </li>
          <li class="nav-menu__item pt-10">
            <a href="#" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-notepad text-main-600"></i> Tra cứu đơn hàng</a>
          </li>



          </li>
          <li class="nav-menu__item">
            <a href="#" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-storefront text-main-600"></i> Truy cập bán hàng</a>
          </li>
          <li class="nav-menu__item">
            <a href="#" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-handshake text-main-600"></i> Đăng ký đối tác</a>
          </li>
          <li class="nav-menu__item">
            <a href="#" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-info text-main-600"></i> Giới thiệu về Siêu Thị Vina</a>
          </li>
          <li class="nav-menu__item">
            <a href="contact.html" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-chat-dots text-main-600"></i> Liên hệ hỗ trợ</a>
          </li>
          @guest
          <li class="nav-menu__item pt-10">
            <a href="javascript:void(0)"
              class="d-flex justify-content-center align-content-around text-center gap-10 fw-medium text-white py-14 px-24 bg-main-600 rounded-pill line-height-1 hover-bg-main-50 hover-text-main-600">
              <span class="d-lg-none d-flex line-height-1"><i class="ph-bold ph-user"></i></span>
              Đăng nhập / Đăng ký
            </a>

          </li>
          @endguest
          @auth
          <li class="on-hover-item nav-menu__item has-submenu pt-10">
            <a href="javascript:void(0)"
              class="d-flex justify-content-center flex-align align-content-around text-center gap-10 fw-medium text-white py-10 px-20 bg-success-600 rounded-pill line-height-1 hover-bg-success-500">
              <span class="d-lg-none d-flex line-height-1"><img src="{{asset('assets/client')}}/images/thumbs/method.png"
                  class="rounded-circle object-fit-cover" style="width: 25px; height: 25px" alt=""></span>
              lyhuu123
            </a>
            <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
              <li class="common-dropdown__item nav-submenu__item">
                <a href="cart.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-heart text-main-600"></i> Yêu thích <span
                    class="badge bg-success-600 rounded-circle">6</span></a>
              </li>
              <li class="common-dropdown__item nav-submenu__item">
                <a href="wishlist.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-user text-main-600"></i> Tài khoản</a>
              </li>
              <li class="common-dropdown__item nav-submenu__item">
                <a href="checkout.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-notepad text-main-600"></i> Đơn hàng của tôi</a>
              </li>
              <li class="common-dropdown__item nav-submenu__item">
                <a href="checkout.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-sign-out text-main-600"></i> Đăng xuất</a>
              </li>

            </ul>
          </li>
          @endauth

        </ul>
        <!-- Nav Menu End -->
      </div>
    </div>
  </div>
  <!-- ==================== Mobile Menu End Here ==================== -->

  <!-- ======================= Middle Top Mobile Start ========================= -->
  <div class="header-top bg-main-600 flex-between py-10 d-block d-lg-none">
    <div class="container container-lg">
      <div class="flex-between gap-8">

        <ul class="header-top__right flex-align flex-wrap gap-16">
          <li class=" d-block on-hover-item text-white-6 flex-shrink-0">
            <button class="category__button flex-align gap-4 text-sm text-white-6 rounded-top">
              <span class="icon text-sm "><i class="ph ph-squares-four"></i></span>
              <span class="">Danh mục</span>
              <!-- <span class="arrow-icon text-sm d-flex"><i class="ph ph-caret-down"></i></span> -->
            </button>

            <div class="responsive-dropdown on-hover-dropdown common-dropdown nav-submenu p-0 submenus-submenu-wrapper">
              <button
                class="close-responsive-dropdown rounded-circle text-xl position-absolute inset-inline-end-0 inset-block-start-0 mt-4 me-8 d-lg-none d-flex">
                <i class="ph ph-x"></i> </button>
              <div class="logo px-16 d-lg-none d-block">
                <a href="{{ route('trang-chu') }}" class="link">
                  <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt="Logo">
                </a>
              </div>
              <ul class="scroll-sm p-0 py-8 w-300 max-h-400 overflow-y-auto">
                @foreach ($danhmuc as $dm)
                  <li class="has-submenus-submenu">
                    <a href="" class="text-gray-600 text-15 py-12 px-16 flex-align gap-4 rounded-0">
                      <span class="text-xl d-flex"><img src="{{asset('assets/client')}}/images/categories/{{ $dm->logo }}" alt="{{ $dm->ten }}" width="70%"></span>
                      <span>{{ $dm->ten }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </li>

        </ul>
        <!-- <div class="text-white text-sm d-flex align-items-center gap-4">
                <img src="{{asset('assets/client')}}/images/icon/track-icon.png" alt="Track Icon">
                <span class="">We deliver to you every day from 7.00 to 23.00</span>
            </div> -->

        <!-- <div class="d-flex align-items-center gap-6 flex-wrap">
                <span class="text-md fw-medium text-white">Until the end of the sale:</span>
                <div class="d-flex align-items-center gap-10" id="countdown25">
                    <div class="d-flex align-items-center gap-4 text-white">
                        <strong class="text-md fw-semibold days">35</strong> 
                        <span class="text-xs">Days</span>
                    </div>
                    <div class="d-flex align-items-center gap-4 text-white">
                        <strong class="text-md fw-semibold hours">14</strong> 
                        <span class="text-xs">Hours</span>
                    </div>
                    <div class="d-flex align-items-center gap-4 text-white">
                        <strong class="text-md fw-semibold minutes">54</strong> 
                        <span class="text-xs">Minutes</span>
                    </div>
                    <div class="d-flex align-items-center gap-4 text-white">
                        <strong class="text-md fw-semibold seconds">28 </strong> 
                        <span class="text-xs">Sec.</span>
                    </div>
                </div>
            </div> -->


        <ul class="header-top__right flex-align justify-content-end flex-wrap gap-16">

          <li class="flex-align">
            <a href="wishlist.html" class="text-white-6 text-sm hover-text-white">
              <i class="ph-bold ph-shopping-cart"></i>
              Giỏ hàng
              <span class="badge bg-success-600 rounded-circle">6</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- ======================= Middle Top End ========================= -->

  <!-- ======================= Middle Top Start ========================= -->
  <div class="header-top bg-main-600 flex-between py-10 d-none d-lg-block pz100">
    <div class="container container-lg">
      <div class="flex-between flex-wrap gap-8">

        <ul class="header-top__right flex-align flex-wrap gap-16">
          <li class="flex-align">
            <a href="" class="text-white-6 text-sm hover-text-white text-center"><i
                class="ph-bold ph-storefront text-white-6"></i> Truy cập bán hàng</a>
          </li>
          <li class="flex-align">
            <a href="" class="text-white-6 text-sm hover-text-white"><i class="ph-bold ph-handshake text-white-6"></i>
              Đăng ký đối tác</a>
          </li>
          <li class="flex-align">
            <a href="" class="text-white-6 text-sm hover-text-white pe-1"><i class="ph-bold ph-info text-white-6"></i>
              Giới thiệu về Siêu Thị Vina </a>
          </li>
          <li class="flex-align">
            <a href="" class="text-white-6 text-sm hover-text-white">
              <i class="ph-bold ph-chat-dots"></i>
              Liên hệ hỗ trợ
            </a>
          </li>

        </ul>
        
        <ul class="header-top__right flex-align flex-wrap gap-16">
          <li class=" d-block on-hover-item text-white-6 flex-shrink-0">
            <button class="category__button flex-align gap-4 text-sm text-white-6 rounded-top">
              <span class="icon text-sm d-md-flex d-none"><i class="ph ph-squares-four"></i></span>
              <span class="d-sm-flex d-none">Danh mục</span>
            </button>

            <div class="responsive-dropdown on-hover-dropdown common-dropdown nav-submenu p-0 submenus-submenu-wrapper">
              <button
                class="close-responsive-dropdown rounded-circle text-xl position-absolute inset-inline-end-0 inset-block-start-0 mt-4 me-8 d-lg-none d-flex">
                <i class="ph ph-x"></i> </button>
              <div class="logo px-16 d-lg-none d-block">
                <a href="{{ route('trang-chu') }}" class="link">
                  <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt="Logo">
                </a>
              </div>
              <ul class="scroll-sm p-0 py-8 w-300 max-h-400 overflow-y-auto">
                @foreach ($danhmuc as $dm)
                  <li class="has-submenus-submenu">
                    <a href="" class="text-gray-600 text-15 py-12 px-16 flex-align gap-4 rounded-0">
                      <span class="text-xl d-flex"><img src="{{asset('assets/client')}}/images/categories/{{ $dm->logo }}" alt="{{ $dm->ten }}" width="70%"></span>
                      <span>{{ $dm->ten }}</span>
                    </a>
                  </li>
                @endforeach
                
                
              </ul>
            </div>

          </li>

          <li class="flex-align">
            <a href="javascript:void(0)" class="text-white-6 text-sm hover-text-white">
              <i class="ph-bold ph-notepad"></i>
              Tra cứu đơn hàng</a>
          </li>

          <li class="flex-align">
            <a href="wishlist.html" class="text-white-6 text-sm hover-text-white">
              <i class="ph-bold ph-shopping-cart"></i>
              Giỏ hàng
              <span class="badge bg-success-600 rounded-circle">6</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- ======================= Middle Top End ========================= -->

  <!-- ======================= Middle Header Two Start ========================= -->
  <header class="header border-bottom border-neutral-40 pt-16 pb-10 pz99">
    <div class="container container-lg">
      <nav class="header-inner flex-between gap-16">
        <!-- Logo Start -->
        <div class="logo">
          <a href="{{ route('trang-chu') }}" class="link">
            <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt="Logo" />
          </a>
        </div>
        <!-- Logo End  -->

        <!-- Menu Start  -->
        <div class="header-menu w-50 d-lg-block d-none">
          
          <div class="mx-20">
            <form action="{{ route('tim-kiem') }}" method="GET" class="position-relative w-100 d-md-block d-none">
              <input type="text"
                class="form-control text-sm fw-normal placeholder-italic shadow-none bg-neutral-30 placeholder-fw-normal placeholder-light py-10 ps-30 pe-60"
                placeholder="{{ $tukhoaplaceholder }}...."
                name="query">
              <button type="submit"
                class="position-absolute top-50 translate-middle-y text-main-600 end-0 me-36 text-xl line-height-1">
                <i class="ph-bold ph-magnifying-glass"></i>
              </button>
            </form>

            <div class="flex-align mt-10 gap-12 title">
              @foreach ($tukhoaphobien as $keyword)
                <a href="{{route('tim-kiem',['query'=>$keyword->tukhoa])}}" class="text-sm link text-gray-600 hover-text-main-600 fst-italic">{{ $keyword->tukhoa }}</a>
              @endforeach
              <!-- <a href="#" class="text-sm link text-gray-600 hover-text-main-600 fst-italic">điện gia dụng</a>
              <a href="#" class="text-sm link text-gray-600 hover-text-main-600 fst-italic">mẹ và bé</a>
              <a href="#" class="text-sm link text-gray-600 hover-text-main-600 fst-italic">móc khóa minecraft</a>
              <a href="#" class="text-sm link text-gray-600 hover-text-main-600 fst-italic">điện nội thất</a> -->
            </div>
          </div>

          <!-- Nav Menu End -->
        </div>
        <!-- Menu End  -->



        <!-- Middle Header Right start -->
        <div class="header-right flex-align">
  
          @guest
          <!-- ============Nút đăng nhập/đăng ký=============== -->
          <ul class="header-top__right style-two style-three flex-align flex-wrap d-lg-block d-none">
            <li class="d-sm-flex d-none">
              <a href="{{ route('login') }}"
                class="d-flex align-content-around gap-10 fw-medium text-main-600 py-14 px-24 bg-main-50 rounded-pill line-height-1 hover-bg-main-600 hover-text-white">
                <span class="d-sm-flex d-none line-height-1"><i class="ph-bold ph-user"></i></span>
                Đăng nhập
              </a>
            </li>
          </ul>
          <!-- ===============Nút đã đăng nhập============= -->
          @endguest
          @auth
          <div
            class="on-hover-item nav-menu__item has-submenu header-top__right style-two style-three flex-align flex-wrap d-lg-block d-none">
            <a href="javascript:void(0)"
              class="d-flex justify-content-center flex-align align-content-around text-center gap-10 fw-medium text-gray-600 py-5 px-10 rounded-pill line-height-1 hover-text-main-600">
              <span class="line-height-1"><img src="{{asset('assets/client')}}/images/thumbs/flag2.png"
                  class="rounded-circle object-fit-cover" style="width: 25px; height: 25px" alt=""></span>
              lyhuu123
            </a>
            <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
              <li class="common-dropdown__item nav-submenu__item">
                <a href="cart.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-heart text-main-600"></i> Yêu thích <span
                    class="badge bg-success-600 rounded-circle">6</span></a>
              </li>
              <li class="common-dropdown__item nav-submenu__item">
                <a href="wishlist.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-user text-main-600"></i> Tài khoản</a>
              </li>
              <li class="common-dropdown__item nav-submenu__item">
                <a href="checkout.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-notepad text-main-600"></i> Đơn hàng của tôi</a>
              </li>
              <li class="common-dropdown__item nav-submenu__item">
                <a href="checkout.html"
                  class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                    class="ph-bold ph-sign-out text-main-600"></i> Đăng xuất</a>
              </li>

            </ul>
          </div>\
          @endauth

          <!-- Dropdown Select End -->
          <button type="button" class="toggle-mobileMenu d-lg-none ms-3n text-gray-800 text-4xl d-flex">
            <i class="ph ph-list"></i>
          </button>
        </div>
        <!-- Middle Header Right End  -->
      </nav>
    </div>
  </header>
  <!-- ======================= Middle Header Two End ========================= -->

  @yield('content')
  

  <!-- ==================== Footer Two Start Here ==================== -->
  <footer class="footer py-10 overflow-hidden">
    <div class="container container-lg">
      <div class="footer-item-two-wrapper d-flex align-items-start flex-wrap">
        <div class="footer-item max-w-275" data-aos="fade-up" data-aos-duration="200">
          <div class="footer-item__logo">
            <a href="{{ route('trang-chu') }}"> <img src="{{asset('assets/client')}}/images/logo/logo_nguyenban.png" alt=""></a>
          </div>
          <p class="mb-24">Trang thương mại điện tử Siêu Thị Vina cung cấp các sản phẩm đa dạng đến với khách hàng và
            đăng ký đối tác với các cửa hàng.
          </p>
          <div class="flex-align gap-16 mb-16">
            <span
              class="w-32 h-32 flex-center rounded-circle border border-gray-100 text-main-two-600 text-md flex-shrink-0"><i
                class="ph-fill ph-phone-call"></i></span>
            <a href="tel:++884911975996" class="text-md text-gray-900 hover-text-main-600">+884 0911 975 996</a>
          </div>
          <div class="flex-align gap-16 mb-16">
            <span
              class="w-32 h-32 flex-center rounded-circle border border-gray-100 text-main-two-600 text-md flex-shrink-0"><i
                class="ph-fill ph-envelope"></i></span>
            <a href="mailto:support24@marketpro.com"
              class="text-md text-gray-900 hover-text-main-600">hotro@sieuthivina.com</a>
          </div>
          <div class="flex-align gap-16 mb-16">
            <span
              class="w-32 h-32 flex-center rounded-circle border border-gray-100 text-main-two-600 text-md flex-shrink-0"><i
                class="ph-fill ph-map-pin"></i></span>
            <span class="text-md text-gray-900 ">No.XXXX Fengshi.rd, Shigang - Taichung, Taiwan</span>
          </div>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="400">
          <h6 class="footer-item__title">Về chúng tôi</h6>
          <ul class="footer-menu">
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Giới thiệu về Siêu thị Vina</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Liên hệ hỗ trợ</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Điều khoản sử dụng</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Chính sách mua hàng</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Chính sách người dùng</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Chính sách cửa hàng</a>
            </li>

          </ul>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="600">
          <h6 class="footer-item__title">Tài khoản</h6>
          <ul class="footer-menu">
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Truy cập tài khoản</a>
            </li>
            <li class="mb-16">
              <a href="contact.html" class="text-gray-600 hover-text-main-600">Lịch sử đơn hàng</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Danh sách yêu thích</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Giỏ hàng của bạn</a>
            </li>

          </ul>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="footer-item__title">Thông tin khác</h6>
          <ul class="footer-menu">
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Danh sách sản phẩm</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-gray-600 hover-text-main-600">Các cửa hàng</a>
            </li>

          </ul>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="1200">
          <h6 class="">Kết nối & theo dõi</h6>
          <p class="mb-16">Truy cập các nền tảng mạng xã hội <br> của chúng tôi.</p>
          <!-- <div class="flex-align gap-8 my-32">
            <a href="https://www.apple.com/store" class="">
              <img src="{{asset('assets/client')}}/images/thumbs/store-img1.png" alt="">
            </a>
            <a href="https://play.google.com/store/apps?hl=en" class="">
              <img src="{{asset('assets/client')}}/images/thumbs/store-img2.png" alt="">
            </a>
          </div> -->

          <ul class="flex-align gap-16">
            <li>
              <a href="https://www.facebook.com"
                class="w-44 h-44 flex-center bg-main-two-50 text-main-two-600 text-xl rounded-8 hover-bg-main-two-600 hover-text-white">
                <i class="ph-fill ph-facebook-logo"></i>
              </a>
            </li>
            <li>
              <a href="https://www.twitter.com"
                class="w-44 h-44 flex-center bg-main-two-50 text-main-two-600 text-xl rounded-8 hover-bg-main-two-600 hover-text-white">
                <i class="ph-fill ph-twitter-logo"></i>
              </a>
            </li>
            <li>
              <a href="https://www.linkedin.com"
                class="w-44 h-44 flex-center bg-main-two-50 text-main-two-600 text-xl rounded-8 hover-bg-main-two-600 hover-text-white">
                <i class="ph-fill ph-instagram-logo"></i>
              </a>
            </li>
            <li>
              <a href="https://www.pinterest.com"
                class="w-44 h-44 flex-center bg-main-two-50 text-main-two-600 text-xl rounded-8 hover-bg-main-two-600 hover-text-white">
                <i class="ph-fill ph-linkedin-logo"></i>
              </a>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </footer>

  <!-- bottom Footer -->
  <div class="bottom-footer bg-color-three py-8">
    <div class="container container-lg">
      <div class="bottom-footer__inner flex-between flex-wrap gap-16 py-16">
        <p class="bottom-footer__text wow fadeInLeftBig">Bản quyền thuộc về Sieuthivina.com </p>
        <div class="flex-align gap-8 flex-wrap wow fadeInRightBig">
          <span class="text-heading text-sm">Hỗ trợ thanh toán</span>
          <img src="{{asset('assets/client')}}/images/thumbs/payment-method.png" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- ==================== Footer Two End Here ==================== -->

  <!-- Jquery js -->
  <script src="{{asset('assets/client')}}/js/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap Bundle Js -->
  <script src="{{asset('assets/client')}}/js/boostrap.bundle.min.js"></script>
  <!-- Bootstrap Bundle Js -->
  <script src="{{asset('assets/client')}}/js/phosphor-icon.js"></script>
  <!-- Select 2 -->
  <script src="{{asset('assets/client')}}/js/select2.min.js"></script>
  <!-- Slick js -->
  <script src="{{asset('assets/client')}}/js/slick.min.js"></script>
  <!-- count down js -->
  <script src="{{asset('assets/client')}}/js/count-down.js"></script>
  <!-- jquery UI js -->
  <script src="{{asset('assets/client')}}/js/jquery-ui.js"></script>
  <!-- wow js -->
  <script src="{{asset('assets/client')}}/js/wow.min.js"></script>
  <!-- AOS Animation -->
  <script src="{{asset('assets/client')}}/js/aos.js"></script>
  <!-- marque -->
  <script src="{{asset('assets/client')}}/js/marque.min.js"></script>
  <!-- marque -->
  <script src="{{asset('assets/client')}}/js/vanilla-tilt.min.js"></script>
  <!-- Counter -->
  <script src="{{asset('assets/client')}}/js/counter.min.js"></script>
  <!-- main js -->
  <script src="{{asset('assets/client')}}/js/main.js"></script>
</body>

</html>