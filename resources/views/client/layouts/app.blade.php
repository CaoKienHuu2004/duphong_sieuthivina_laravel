<!DOCTYPE html>
<html lang="en" class="color-two font-exo header-sticky-style">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Mua sắm online thả ga tại Siêu Thị Vina. Đa dạng ngành hàng, giá tốt mỗi ngày, giao hàng nhanh chóng trên toàn quốc. Trải nghiệm ngay!">
  <meta name="keywords" content="Siêu thị Vina, Siêu Thị Vina, Mua sắm, Quà tặng">
  <meta name="robots" content="index, follow">

  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:type" content="" />
  <meta property="og:title" content="@yield('title')" />
  <meta property="og:description" content="Mua sắm online thả ga tại Siêu Thị Vina. Đa dạng ngành hàng, giá tốt mỗi ngày, giao hàng nhanh chóng trên toàn quốc. Trải nghiệm ngay!" />
  <meta property="og:image" content="{{ asset('assets/client/images/bg/Gemini_Generated_Image_l0fe8ml0fe8ml0fe.png') }}" />

  <!-- Title -->
  <title>@yield('title')</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{asset('assets/client')}}/images/logo/icon_nguyenban.png" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
  

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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  {{--
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-K0PMTZKMC1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-K0PMTZKMC1');
  </script>
</head>

<body>
  <!--==================== Preloader Start ====================-->
  {{-- <div class="preloader">
    <img src="{{asset('assets/client')}}/images/icon/preloader.gif" alt="" />
  </div> --}}
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
              <input type="text" name="query"
                class="form-control text-sm fw-medium placeholder-italic shadow-none bg-neutral-30 placeholder-fw-medium placeholder-light py-10 ps-20 pe-60"
                placeholder="{{ $tukhoaplaceholder }}..." required>
              <button type="submit"
                class="position-absolute top-50 translate-middle-y text-main-600 end-0 me-36 text-xl line-height-1">
                <i class="ph-bold ph-magnifying-glass"></i>
              </button>
            </form>
          </li>
          @guest
            <li class="av-menu__item pt-10">
              <a href="{{ route('dang-ky') }}" class="nav-menu__link text-heading-two hover-text-main-600"><i
                  class="ph-bold ph-user text-main-600"></i>
                Đăng ký thành viên</a>
            </li>
          @endguest
          <li class="nav-menu__item">
            <a href="{{ route('tra-cuu-don-hang') }}" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-notepad text-main-600"></i> Tra cứu đơn hàng</a>
          </li>



          </li>
          {{-- <li class="nav-menu__item">
            <a href="#" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-storefront text-main-600"></i> Truy cập bán hàng</a>
          </li>
          <li class="nav-menu__item">
            <a href="#" class="nav-menu__link text-heading-two hover-text-main-600"><i
                class="ph-bold ph-handshake text-main-600"></i> Đăng ký đối tác</a>
          </li> --}}
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
              <a href="{{ route('login') }}"
                class="d-flex justify-content-center align-content-around text-center gap-10 fw-medium text-white py-14 px-24 bg-main-600 rounded-pill line-height-1 hover-bg-main-50 hover-text-main-600">
                <span class="d-lg-none d-flex line-height-1"><i class="ph-bold ph-user"></i></span>
                Đăng nhập
              </a>

            </li>
          @endguest
          @auth
            <li class="on-hover-item nav-menu__item has-submenu pt-10">
              <a href="#"
                class="d-flex justify-content-center flex-align align-content-around text-center gap-10 fw-medium text-white py-10 px-20 bg-success-600 rounded-pill line-height-1 hover-bg-success-500">
                <span class="d-lg-none d-flex line-height-1"><img
                    src="{{asset('assets/client')}}/images/thumbs/{{Auth::user()->avatar}}"
                    class="rounded-circle object-fit-cover" style="width: 25px; height: 25px" alt=""></span>
                {{ Auth::user()->hoten }}
              </a>
              <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                <li class="common-dropdown__item nav-submenu__item">
                  <a href="{{ route('tai-khoan') }}"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                      class="ph-bold ph-user text-main-two-600"></i> Tài khoản</a>
                </li>
                @if(Auth::check() && Auth::user()->vaitro === 'admin')
                  <li class="common-dropdown__item nav-submenu__item">
                    <a href="{{ route('quan-tri-vien.trang-chu') }}"
                      class="common-dropdown__link nav-submenu__link text-sm text-heading-two bg-warning-100 hover-bg-neutral-100"><i
                        class="ph-bold ph-app-window text-main-two-600"></i> Truy cập quản trị</a>
                  </li>
                @endif
                <li class="common-dropdown__item nav-submenu__item">
                  <a href="{{ route('don-hang-cua-toi') }}"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                      class="ph-bold ph-notepad text-main-two-600"></i> Đơn hàng của tôi</a>
                </li>
                <li class="common-dropdown__item nav-submenu__item">
                  <a href="cart.html"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                      class="ph-bold ph-heart text-main-two-600"></i> Yêu thích <span
                      class="badge bg-success-600 rounded-circle">0</span></a>
                </li>
                <li class="common-dropdown__item nav-submenu__item">
                  <form action="{{ route('dang-xuat') }}" method="post"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                    @csrf
                    <button type="submit" class="">
                      <i class="ph-bold ph-sign-out text-main-600"></i> Đăng xuất</button>
                  </form>
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
                    <a href="{{ url('san-pham?danhmuc=' . $dm->slug) }}"
                      class="text-gray-600 text-15 py-12 px-16 flex-align gap-4 rounded-0">
                      <span class="text-xl d-flex text-main-two-600">
                        
                        <img src="{{asset('assets/client')}}/images/categories/{{ $dm->logo }}"
                          alt="{{ $dm->ten }}" width="70%"></span>
                      <span>{{ $dm->ten }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </li>

        </ul>
        <ul class="header-top__right flex-align justify-content-end flex-wrap gap-16">

          <li class="flex-align">
            <a href="{{route('gio-hang')}}" class="text-white-6 text-sm hover-text-white">
              <i class="ph-bold ph-shopping-cart"></i>
              Giỏ hàng
              <span class="badge bg-success-600 rounded-circle">{{ count($giohangsession) }}</span>
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
          {{-- <li class="flex-align">
            <a href="" class="text-white-6 text-sm hover-text-white text-center"><i
                class="ph-bold ph-storefront text-white-6"></i> Truy cập bán hàng</a>
          </li>
          <li class="flex-align">
            <a href="" class="text-white-6 text-sm hover-text-white"><i class="ph-bold ph-handshake text-white-6"></i>
              Đăng ký đối tác</a>
          </li> --}}
          @guest
            <li class="flex-align">
              <a href="{{ route('dang-ky') }}" class="text-white-6 text-sm text-white hover-text-white"><i
                  class="ph-bold ph-user text-white"></i>
                Đăng ký thành viên</a>
            </li>
          @endguest

          <li class="flex-align">
            <a href="" class="text-white text-sm hover-text-white pe-1"><i class="ph-bold ph-info text-white"></i>
              Giới thiệu về Siêu Thị Vina </a>
          </li>
          <li class="flex-align">
            <a href="" class="text-white text-sm hover-text-white">
              <i class="ph-bold ph-chat-dots"></i>
              Liên hệ hỗ trợ
            </a>
          </li>

        </ul>

        <ul class="header-top__right flex-align flex-wrap gap-16">
          <li class=" d-block on-hover-item text-white-6 flex-shrink-0">
            <button class="category__button flex-align gap-4 text-sm text-white rounded-top">
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
                    <a href="{{ url('san-pham?danhmuc=' . $dm->slug) }}"
                      class="text-gray-600 text-15 py-12 px-16 flex-align gap-4 rounded-0">
                      <span class="text-xl d-flex"><img src="{{asset('assets/client')}}/images/categories/{{ $dm->logo }}"
                          alt="{{ $dm->ten }}" width="70%"></span>
                      <span>{{ $dm->ten }}</span>
                    </a>
                  </li>
                @endforeach


              </ul>
            </div>

          </li>

          <li class="flex-align">
            <a href="{{ route('tra-cuu-don-hang') }}" class="text-white text-sm hover-text-white">
              <i class="ph-bold ph-notepad"></i>
              Tra cứu đơn hàng</a>
          </li>

          <li class="flex-align">
            <a href="{{route('gio-hang')}}" class="text-white text-sm hover-text-white">
              <i class="ph-bold ph-shopping-cart"></i>
              Giỏ hàng
              <span class="badge bg-main-two-600 rounded-4 px-6 py-4">@auth{{ count($giohangauth) }}@endauth @guest
                {{ count($giohangsession) }}
              @endguest</span>
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
                placeholder="{{ $tukhoaplaceholder }}...." name="query" required>
              <button type="submit"
                class="position-absolute top-50 translate-middle-y text-main-600 end-0 me-36 text-xl line-height-1">
                <i class="ph-bold ph-magnifying-glass"></i>
              </button>
            </form>

            <div class="flex-align mt-10 gap-12 title">
              @foreach ($tukhoaphobien as $keyword)
                <a href="{{route('tim-kiem', ['query' => $keyword->tukhoa])}}"
                  class="text-sm link text-gray-600 hover-text-main-600 fst-italic">{{ $keyword->tukhoa }}</a>
              @endforeach
            </div>
          </div>
        </div>

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
              <a href="{{ route('tai-khoan') }}"
                class="d-flex justify-content-center flex-align align-content-around text-center gap-10 fw-medium text-gray-600 py-5 px-10 rounded-pill line-height-1 hover-text-main-600">
                <span class="line-height-1"><img src="{{asset('assets/client')}}/images/thumbs/{{Auth::user()->avatar}}"
                    class="rounded-circle object-fit-cover" style="width: 35px; height: 35px" alt=""></span>
                {{ Auth::user()->hoten }}
              </a>
              <ul class="on-hover-dropdown common-dropdown nav-submenu scroll-sm">
                <li class="common-dropdown__item nav-submenu__item">
                  <a href="{{ route('tai-khoan') }}"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                      class="ph-bold ph-user text-main-two-600"></i> Tài khoản</a>
                </li>
                @if(Auth::check() && Auth::user()->vaitro === 'admin')
                  <li class="common-dropdown__item nav-submenu__item">
                    <a href="{{ route('quan-tri-vien.trang-chu') }}"
                      class="common-dropdown__link nav-submenu__link text-heading-two bg-warning-100 hover-bg-neutral-100"><i
                        class="ph-bold ph-app-window text-main-600"></i> Truy cập quản trị</a>
                  </li>
                @endif
                <li class="common-dropdown__item nav-submenu__item">
                  <a href="{{ route('don-hang-cua-toi') }}"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                      class="ph-bold ph-notepad text-main-two-600"></i> Đơn hàng của tôi</a>
                </li>
                <li class="common-dropdown__item nav-submenu__item">
                  <a href="cart.html"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100"><i
                      class="ph-bold ph-heart text-main-two-600"></i> Yêu thích <span
                      class="badge bg-main-two-600 rounded-circle">0</span></a>
                </li>
                <li class="common-dropdown__item nav-submenu__item">
                  <form action="{{ route('dang-xuat') }}" method="post"
                    class="common-dropdown__link nav-submenu__link text-heading-two hover-bg-neutral-100">
                    @csrf
                    <button type="submit" class="">
                      <i class="ph-bold ph-sign-out text-danger-600"></i> Đăng xuất</button>
                  </form>

                </li>

              </ul>
            </div>
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
  

  <button id="chatbot-toggler">
      <span class="material-symbols-outlined">mode_comment</span>
      <span class="material-symbols-rounded">close</span>
    </button>

    <div class="chatbot-popup">
      <!-- Chatbot Header -->
      <div class="chat-header bg-main-600">
        <div class="header-info">
          <svg 
            class="chatbot-logo"
            xmlns="http://www.w3.org/2000/svg"
            width="50"
            height="50"
            viewBox="0 0 1024 1024"
          >
            <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
            ></path>
          </svg>

          <h3 class="logo-text mb-0">Trợ lý Siêu Thị Vina</h3>
        </div>
        <button id="close-chatbot"
        class="material-symbols-rounded"><i class="ph ph-x text-2xl"></i></button>
      </div>

      <!-- Chatbot Body -->
      <div class="chat-body">
        <div class="message bot-message">
          <svg 
            class="bot-avatar"
            xmlns="http://www.w3.org/2000/svg"
            width="50"
            height="50"
            viewBox="0 0 1024 1024"
          >
          <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
            ></path>
          </svg>
          <div class="message-text">
            Xin chào bạn 👋 <br />
            Mình có thể giúp gì cho bạn nhỉ ? ^_^
          </div>
        </div>
      </div>
      

      <!-- Chatbot Footer -->
      <div class="chat-footer">
        <form action="#" class="chat-form">
          <textarea placeholder="Nhập tin nhắn..." class="message-input" style="height: 47px !important" required></textarea>
          <div class="chat-controls">
            <button type="submit" id="send-message" class="material-symbols-rounded"><i class="ph ph-paper-plane-right"></i></button>
          </div>
        </form>
      </div>
    </div>

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap");

      #chatbot-toggler {
        position: fixed;
        bottom: 90px;
        right: 25px;
        height: 64px;
        width: 65px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 50%;
        background: #ff6a00;
        transition: all 0.2s ease;
      }

      body.show-chatbot #chatbot-toggler {
        transform: rotate(90deg);
      }

      #chatbot-toggler span {
        color: #fff;
        position: absolute;
      }

      body.show-chatbot #chatbot-toggler span:first-child, #chatbot-toggler span:last-child{
        opacity: 0;
      }

      body.show-chatbot #chatbot-toggler span:last-child{
        opacity: 1;
      }

      .chatbot-popup {
        position: fixed;
        right: 25px;
        bottom: 160px;
        width: 350px;
        background: #fff;
        overflow: hidden;
        border-radius: 15px;
        opacity: 0;
        transform: scale(0.2);
        transform-origin: bottom right;
        pointer-events: none;
        box-shadow: 0 0 128px rgba(0, 0, 0, 0.1), 0 32px 64px -48px rgba(0, 0, 0, 0.5);
        transition: all 0.1s ease;
        z-index: 9999;
      }

      body.show-chatbot .chatbot-popup {
        opacity: 1;
        pointer-events: auto;
          transform: scale(1);
      }

      .chat-header {
        display: flex;
        align-items: center;
        background: #ff6a00;
        padding: 15px 22px;
        justify-content: space-between;
      }

      .chat-header .header-info {
        display: flex;
        gap: 10px;
        align-items: center;
      }

      .header-info .chatbot-logo {
        height: 35px;
        width: 35px;
        padding: 6px;
        fill: #007f80;
        flex-shrink: 0;
        background: #fff;
        border-radius: 50%;
      }

      .header-info .logo-text {
        color: #fff;
        font-size: 1.31rem;
        font-weight: 600;
      }

      .chat-header #close-chatbot {
        border: none;
        color: #fff;
        height: 40px;
        width: 40px;
        font-size: 1.9rem;
        margin-right: -10px;
        cursor: pointer;
        border-radius: 50%;
        background: none;
        transition: 0.2s ease;
      }

      .chat-body {
        padding: 25px 22px;
        display: flex;
        gap: 20px;
        height: 350px;
        margin-bottom: 82px;
        overflow-y: auto;
        flex-direction: column;
        scrollbar-width: thin;
        scrollbar-color: #ccccf5 transparent;
        
      }

      .chat-body .message {
        display: flex;
        gap: 11px;
        align-items: center;
      }

      .chat-body .bot-message .bot-avatar {
        height: 35px;
        width: 35px;
        padding: 6px;
        fill: #fff;
        flex-shrink: 0;
        margin-bottom: 2px;
        align-self: flex-end;
        background: #007f80;
        border-radius: 50%;
      }

      .chat-body .user-message {
        flex-direction: column;
        align-items: flex-end;
      }

      .chat-body .message .message-text {
        padding: 12px 16px;
        max-width: 75%;
        font-size: 0.95rem;
        background: #f2f2ff;
      }

      .chat-body .bot-message.thinking .message-text {
        padding: 2px 16px;
      }

      .chat-body .bot-message .message-text {
        background-color: #f2f2ff;
        border-radius: 13px 13px 13px 3px;
      }

      .chat-body .user-message .message-text {
        color: #fff;
        background-color: #ff6a00;
        border-radius: 13px 13px 3px 13px;
      }

      .chat-body .bot-message .thinking-indicator {
        display: flex;
        gap: 4px;
        padding-block: 15px;
      }

      .chat-body .bot-message .thinking-indicator .dot:nth-child(1) {
        animation-delay: 0.2s;
      }

      .chat-body .bot-message .thinking-indicator .dot:nth-child(2) {
        animation-delay: 0.3s;
      }

      .chat-body .bot-message .thinking-indicator .dot:nth-child(3) {
        animation-delay: 0.4s;
      }

      .chat-body .bot-message .thinking-indicator .dot {
        height: 7px;
        width: 7px;
        opacity: 0.7;
        border-radius: 50%;
        background: #007f80;
        animation: dotPulse 1.8s ease-in-out infinite;
      }

      @keyframes dotPulse {
        0%,
        44% {
          transform: translateY(0);
        }

        28% {
          opacity: 0.4;
          transform: translateY(-4px);
        }

        44% {
          opacity: 0.2;
        }
      }

      .chat-footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        background: white;
        padding: 15px 22px 20px;
      }

      .chat-footer .chat-form {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 32px;
        outline: 1px solid #cccce5;
      }

      .chat-footer .chat-form:focus-within {
        outline: 2px solid #007f80;
      }

      .chat-form .message-input {
        border: none;
        outline: none;
        height: 47px;
        width: 100%;
        resize: none;
        max-height: 180px;
        white-space: pre-line;
        font-size: 1rem;
        padding: 13px;
        border-radius: inherit;
        scrollbar-width: thin;
        scrollbar-color: transparent transparent;
      }

      .chat-form .message-input::hover {
        scrollbar-color: #ccccf5 transparent;
      }

      .chat-form .chat-controls {
        display: flex;
        height: 47px;
        gap: 3px;
        align-items: center;
        align-self: flex-end;
        padding-right: 6px;
      }

      .chat-form .chat-controls button {
        height: 35px;
        width: 35px;
        border: none;
        font-size: 1.15rem;
        cursor: pointer;
        color: #ff6a00;
        background: none;
        border-radius: 50%;
        transition: 0.2s ease;
      }

      .chat-form .chat-controls #send-message {
        color: #fff;
        display: none;
        background: #ff6a00;
      }

      .chat-form .message-input:valid ~ .chat-controls #send-message {
        display: block;
      }

      .chat-form .chat-controls #send-message:hover {
        background: #007f80;
      }

      .chat-form .chat-controls button:hover {
        background: #f1f1f1;
      }

      .chat-body .user-message .attachment {
        width: 50%;
        margin-top: -7px;
        border-radius: 13px 3px 13px 3px;
      }

      em-emoji-picker {
        position: absolute;
        left: 50%;
        top: -337px;
        width: 100%;
        max-width: 350px;
        max-height: 330px;
        visibility: hidden;
        transform: translateX(-50%);
      }

      body.show-emoji-picker em-emoji-picker {
        visibility: visible;
      }
      /* Responsive for mobile screen */
      @media screen and (max-width: 600px) {
        .chatbot-popup {
          width: 100%;
          right: 0;
          bottom: 0;
          border-radius: 0;
          height: 100%;
        }

        .chat-header .header-info .logo-text {
          font-size: 1.1rem;
        }

        .chat-body {
          height: 100%;
          margin-bottom: 0;
        }

        .chat-body .message .message-text {
          max-width: 85%;
        }

        .chat-footer .chat-form {
          border-radius: 0;
          border-radius: 25px;
        }

        .chat-footer .chat-form .message-input {
          border-radius: 0;
        }

        .chat-footer .chat-form .chat-controls {
          padding-right: 10px;
        }

        .chat-footer .chat-form .chat-controls button {
          height: 40px;
          width: 40px;
        }
      } 
    </style>

    <script>
    const chatBody = document.querySelector(".chat-body");
    const messageInput = document.querySelector(".message-input");
    const sendMessageButton = document.querySelector("#send-message");
    const fileInput = document.querySelector("#file-input");
    const chatbotToggler = document.querySelector("#chatbot-toggler");
    const closeChatbot = document.querySelector("#close-chatbot");

    // Biến lưu dữ liệu người dùng
    const userData = {
        message: null,
        file: null // Hiện tại backend chỉ xử lý text, file sẽ tính sau
    };

    const initialInputHeight = messageInput.scrollHeight;

    // Tạo phần tử tin nhắn HTML
    const createMessageElement = (content, ...classes) => {
        const div = document.createElement("div");
        div.classList.add("message", ...classes);
        div.innerHTML = content;
        return div;
    };

    // Hàm gọi API về Laravel Backend
    const generateBotResponse = async (incomingMessageDiv) => {
        const messageElement = incomingMessageDiv.querySelector(".message-text");

        try {
            // Lấy CSRF Token từ thẻ meta để Laravel cho phép gửi request
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Gửi tin nhắn đến Route API của Laravel (/api/chat)
            const response = await fetch('/api/v1/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    message: userData.message
                })
            });

            const data = await response.json();

            if (!response.ok) throw new Error(data.message || "Lỗi kết nối Server");

            // Hiển thị câu trả lời từ Laravel (data.reply)
            // Thay thế các ký tự xuống dòng \n bằng thẻ <br> để đẹp hơn
            const formattedReply = data.reply.replace(/\n/g, '<br>');
            messageElement.innerHTML = formattedReply;

        } catch (error) {
            console.error(error);
            messageElement.innerText = "Xin lỗi, hệ thống đang bận. Vui lòng thử lại sau.";
            messageElement.style.color = "#ff0000";
        } finally {
            incomingMessageDiv.classList.remove("thinking");
            chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
        }
    };

    // Xử lý khi người dùng gửi tin nhắn
    const handleOutgoingMessage = (e) => {
        e.preventDefault();
        userData.message = messageInput.value.trim();
        if(!userData.message) return; // Không gửi nếu rỗng

        messageInput.value = "";
        messageInput.style.height = `${initialInputHeight}px`; // Reset chiều cao input

        // 1. Hiển thị tin nhắn của người dùng lên màn hình
        const messageContent = `<div class="message-text"></div>`;
        const outgoingMessageDiv = createMessageElement(messageContent, "user-message");
        outgoingMessageDiv.querySelector(".message-text").textContent = userData.message;
        chatBody.appendChild(outgoingMessageDiv);
        chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });

        // 2. Hiển thị trạng thái Bot đang suy nghĩ (loading...)
        setTimeout(() => {
            const botHtml = `
            <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"></path>
            </svg>
            <div class="message-text">
                <div class="thinking-indicator">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>`;
            
            const incomingMessageDiv = createMessageElement(botHtml, "bot-message", "thinking");
            chatBody.appendChild(incomingMessageDiv);
            chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
            
            // 3. Gọi hàm xử lý backend
            generateBotResponse(incomingMessageDiv);
        }, 600);
    };

    // Xử lý sự kiện nhấn Enter
    messageInput.addEventListener("keydown", (e) => {
        const userMessage = e.target.value.trim();
        // Sửa lỗi chính tả innerWidth và logic Enter
        if (e.key === "Enter" && userMessage && !e.shiftKey && window.innerWidth > 768) {
            handleOutgoingMessage(e);
        }
    });

    // Tự động chỉnh độ cao khung nhập liệu
    messageInput.addEventListener("input", () => {
        messageInput.style.height = `47px`;
        messageInput.style.height = `${messageInput.scrollHeight}px`;
        
        // Sửa lỗi selector thiếu dấu chấm (.)
        const chatForm = document.querySelector(".chat-form");
        if(chatForm) {
            chatForm.style.borderRadius = messageInput.scrollHeight > initialInputHeight ? "15px" : "32px";
        }
    });

    // Khởi tạo Emoji Picker
    // Kiểm tra xem thư viện đã load chưa để tránh lỗi
    if (typeof EmojiMart !== 'undefined') {
        const picker = new EmojiMart.Picker({
            theme: "light",
            skinTonePosition: "none",
            preview: "none",
            onEmojiSelect: (emoji) => {
                const { selectionStart: start, selectionEnd: end } = messageInput;
                messageInput.setRangeText(emoji.native, start, end, "end");
                messageInput.focus();
            },
            onClickOutside: (e) => {
                if (e.target.id === "emoji-picker") {
                    document.body.classList.toggle("show-emoji-picker");
                } else {
                    document.body.classList.remove("show-emoji-picker");
                }
            }
        });
        document.querySelector(".chat-form").appendChild(picker);
    }

    // Gán sự kiện click cho các nút
    sendMessageButton.addEventListener("click", (e) => handleOutgoingMessage(e));
    
    // Tạm thời tắt tính năng upload ảnh vì backend chưa xử lý
    // document.querySelector("#file-upload").addEventListener("click", () => fileInput.click());

    chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
    closeChatbot.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
    
    // Nút emoji toggle
    const emojiBtn = document.querySelector("#emoji-picker");
    if(emojiBtn) {
        emojiBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            document.body.classList.toggle("show-emoji-picker");
        });
    }
</script>


  <!-- ==================== Footer Two Start Here ==================== -->
  <footer class="footer pt-30 overflow-hidden border-top fix-scale-20 bg-main-two-600 text-white">
    <div class="container container-lg">
      <div class="footer-item-two-wrapper d-flex align-items-start flex-between flex-wrap gap-12">
        <div class="footer-item max-w-275" data-aos="fade-up" data-aos-duration="200">
          <div class="footer-item__logo">
            <a href="{{ route('trang-chu') }}"> <img src="{{asset('assets/client')}}/images/logo/logo_amban.png"
                alt=""></a>
          </div>
          <p class="mb-24 text-white">Trang thương mại điện tử Siêu Thị Vina cung cấp các sản phẩm đa dạng đến với khách hàng
          </p>
          <div class="flex-align gap-16 mb-16">
            <span
              class="text-white w-32 h-32 flex-center rounded-circle border border-gray-100 text-main-two-600 text-md flex-shrink-0"><i
                class="ph-fill ph-phone-call text-white"></i></span>
            <a href="tel:+886911975996" class="text-md  hover-text-main-600 text-white">+886 0911 975 996</a>
          </div>
          <div class="text-white flex-align gap-16 mb-16">
            <span
              class="w-32 h-32 flex-center rounded-circle border border-gray-100 text-main-two-600 text-md flex-shrink-0"><i
                class="ph-fill ph-envelope text-white"></i></span>
            <a href="mailto:support@sieuthivina.com"
              class="text-md hover-text-main-600 text-white">support@sieuthivina.com</a>
          </div>
          <div class="flex-align gap-16 mb-16">
            <span
              class="w-32 h-32 flex-center rounded-circle border border-gray-100 text-main-two-600 text-md flex-shrink-0"><i
                class="ph-fill ph-map-pin text-white"></i></span>
            <span class="text-md text-white ">801/2A Phạm Thế Hiển, Phường Chánh Hưng, TP.HCM</span>
          </div>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="400">
          <h6 class="footer-item__title text-white">Về chúng tôi</h6>
          <ul class="footer-menu">
            <li class="mb-16">
              <a href="shop.html" class="text-white hover-text-main-600">Giới thiệu về Siêu thị Vina</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-white hover-text-main-600">Liên hệ hỗ trợ</a>
            </li>
            <li class="mb-16">
              <a href="{{ url('/dieu-khoan') }}" class="text-white hover-text-main-600">Điều khoản sử dụng</a>
            </li>
            <li class="mb-16">
              <a href="{{ url('/chinh-sach-mua-hang') }}" class="text-white hover-text-main-600">Chính sách mua
                hàng</a>
            </li>
            <li class="mb-16">
              <a href="{{ url('/chinh-sach-nguoi-dung') }}" class="text-white hover-text-main-600">Chính sách người
                dùng</a>
            </li>

          </ul>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="600">
          <h6 class="footer-item__title text-white">Tài khoản</h6>
          <ul class="footer-menu">
            <li class="mb-16">
              <a href="{{ route('tai-khoan') }}" class="text-white hover-text-main-600">Truy cập tài khoản</a>
            </li>
            <li class="mb-16">
              <a href="contact.html" class="text-white hover-text-main-600">Lịch sử đơn hàng</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-white hover-text-main-600">Danh sách yêu thích</a>
            </li>
            <li class="mb-16">
              <a href="{{route('gio-hang')}}" class="text-white hover-text-main-600">Giỏ hàng của bạn</a>
            </li>

          </ul>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="footer-item__title text-white">Thông tin khác</h6>
          <ul class="footer-menu">
            <li class="mb-16">
              <a href="shop.html" class="text-white hover-text-main-600">Danh sách sản phẩm</a>
            </li>
            <li class="mb-16">
              <a href="shop.html" class="text-white hover-text-main-600">Các cửa hàng</a>
            </li>

          </ul>
        </div>

        <div class="footer-item" data-aos="fade-up" data-aos-duration="1200">
          <h6 class="text-white">Kết nối & theo dõi</h6>
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
              <a href="https://www.facebook.com/sieuthivina"
                class="w-44 h-44 flex-center border border-white text-white text-xl rounded-8 hover-bg-main-600 hover-text-white hover-border-white">
                <i class="ph-fill ph-facebook-logo"></i>
              </a>
            </li>
            <li>
              <a href="https://www.twitter.com"
                class="w-44 h-44 flex-center border border-white text-white text-xl rounded-8 hover-bg-main-600 hover-text-white hover-border-white">
                <i class="ph-fill ph-twitter-logo"></i>
              </a>
            </li>
            <li>
              <a href="https://www.linkedin.com"
                class="w-44 h-44 flex-center border border-white text-white text-xl rounded-8 hover-bg-main-600 hover-text-white hover-border-white">
                <i class="ph-fill ph-instagram-logo"></i>
              </a>
            </li>
            <li>
              <a href="https://www.pinterest.com"
                class="w-44 h-44 flex-center border border-white text-white text-xl rounded-8 hover-bg-main-600 hover-text-white hover-border-white">
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

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  @yield('scripts')
</body>

</html>