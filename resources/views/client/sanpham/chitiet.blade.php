@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

{{-- Sử dụng Tailwind CSS cho giao diện --}}
@section('styles')
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .variant-radio:checked + label {
            border-color: #EF4444; /* red-500 */
            box-shadow: 0 0 0 2px #FECACA; /* red-200 shadow */
        }
    </style> -->
@endsection

{{-- Khởi tạo biến JavaScript để lưu trữ thông tin biến thể --}}
@php
    $variantsData = [];
    $sanpham->bienthe->each(function($bienthe) use (&$variantsData) {
        $variantsData[$bienthe->id] = [
            'name' => $bienthe->loaibienthe->ten,
            'original_price' => number_format($bienthe->giagoc, 0, ',', '.'),
            'sale_price' => number_format($bienthe->giadagiam, 0, ',', '.'),
            'is_sale' => $bienthe->is_sale,
        ];
    });
    $initialVariant = $sanpham->bienthe->first();
@endphp

@section('content')
    <div class="page">
        <section class="product-details pt-40 fix-scale-40">
            <div class="container container-lg">
                <form action="#" class="row gy-4">
                    <div class="col-xl-9">
                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <div class="product-details__left">
                                    <div class="product-details__thumb-slider rounded-16 p-0">
                                        @foreach ($sanpham->hinhanhsanpham as $hasp)
                                            <div class="">
                                                <div class="product-details__thumb flex-center h-100">
                                                    <img class=" rounded-10" src="{{asset('assets/client')}}/images/thumbs/{{ $hasp->hinhanh }}" alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-24">
                                        <div class="product-details__images-slider">
                                            @foreach ($sanpham->hinhanhsanpham as $hasp)
                                                <div>
                                                    <div class="max-w-120 max-h-120 h-100 flex-center rounded-16">
                                                        <img class="rounded-10" src="{{asset('assets/client')}}/images/thumbs/{{ $hasp->hinhanh }}" alt="">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="product-details__content">
                                    
                                    {{-- <div class="flex-center mb-24 flex-wrap gap-16 bg-color-one rounded-8 py-16 px-24 position-relative z-1 ">
                                        <img src="{{asset('assets/client')}}/images/bg/details-offer-bg.png" alt="" class="position-absolute inset-block-start-0 inset-inline-start-0 rounded-8 h-100  z-n1 object-fit-cover">
                                        <div class="flex-align gap-16">
                                            <span class="text-white text-sm">Special Offer:</span>
                                        </div>
                                        <div class="countdown" id="countdown11">
                                            <ul class="countdown-list flex-align flex-wrap">
                                                <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="days"></span></li>
                                                <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="hours"></span></li>
                                                <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="minutes"></span></li>
                                                <li class="countdown-list__item text-heading flex-align gap-4 text-xs fw-medium w-28 h-28 rounded-4 border border-main-600 p-0 flex-center"><span class="seconds"></span></li>
                                            </ul>
                                        </div>
                                        <span class="text-white text-xs">Remains untill the end of the offer</span>
                                    </div> --}}
                                    
                                    <h5 class="mb-12">{{ $sanpham->ten }}</h5>
                                    <div class="flex-align flex-wrap gap-12">
                                        @foreach ( $sanpham->danhmuc as $dm)
                                            <a href="{{ url('san-pham?danhmuc='.$dm->slug) }}" class="btn btn-main rounded-8 py-6 px-8 text-sm">{{ $dm->ten }}</a>
                                        @endforeach
                                        
                                    </div>
                                    <div class="flex-align flex-wrap gap-12 mt-10">
                                        <div class="flex-align gap-4 flex-wrap">
                                            <div class="flex-align gap-8">
                                                <span class="text-xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                            </div>
                                            <span class="text-md fw-medium text-neutral-600">4.7 </span>
                                            <span class="text-sm fw-medium text-gray-500">(21,676)</span>
                                        </div>
                                        
                                        @if($sanpham->bienthe->sum('luotban') > 0)
                                            <span class="text-md fw-medium text-gray-500">|</span>
                                            <div class="flex-align gap-8">
                                                <span class="text-md fw-medium text-neutral-600">Lượt bán: </span>
                                                <span class="text-md fw-medium text-gray-500">{{ $sanpham->bienthe->sum('luotban') }}</span>
                                            </div>
                                        @endif
                                        @if($sanpham->luotxem > 0)
                                        <span class="text-md fw-medium text-gray-500">|</span>
                                        <div class="flex-align gap-8">
                                            <span class="text-md fw-medium text-gray-500">{{ $sanpham->luotxem }}</span>
                                            <span class="text-md fw-medium text-neutral-600">người xem</span>
                                        </div>
                                        @endif
                                        
                                    </div>
                                
                                    
                                    <!-- <span class="mt-32 text-gray-700 border-top border-gray-100 d-block"></span> -->
                                     <ul class="mt-30">
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Xuất xứ:
                                                    <span class="text-gray-500"> {{ $sanpham->xuatxu }}</span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Nơi sản xuất:
                                                    <span class="text-gray-500"> {{ $sanpham->sanxuat }}</span>
                                                </span>
                                            </li>
                                        </ul>
                                    @if($initialVariant && $initialVariant->is_sale)
                                                <div class="flex-align gap-8 text-main-600 mt-30">
                                                    <i class="ph-fill ph-seal-percent text-xl"></i>
                                                    -{{ $sanpham->giamgia }}%
                                                </div>
                                            @endif
                                    <div class="mb-32 flex-align gap-16 flex-wrap">
                                        <div class="flex-align gap-8">
                                            
                                            <h6 class="mb-0 text-main-600" id="current-price">
                                                @if($initialVariant)
                                                    {{ number_format($initialVariant->giadagiam, 0, ',', '.') }} ₫
                                                @else
                                                    Đang cập nhật
                                                @endif
                                            </h6>
                                        </div>
                                        @if($initialVariant && $initialVariant->is_sale)
                                            <div class="flex-align gap-8">
                                                <span class="text-gray-700">Giá gốc</span>
                                                <h6 class="text-xl text-gray-400 mb-0 fw-medium text-decoration-line-through" id="original-price">{{  number_format($sanpham->bienthe->first()->giagoc, 0, ',', '.')}} ₫</h6>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <span class="mt-32 pt-30 text-gray-700 border-top border-gray-100 d-block"></span>

                                    <div class="">
                                        <h6 class="mb-16">Loại sản phẩm</h6>
                                        <div class="flex-between align-items-start flex-wrap gap-16">
                                            <div>
                                                <div class=" flex-align gap-8">
                                                    @foreach($sanpham->bienthe as $bienthe)
                                                        <input type="radio"
                                                        @if($loop->first) checked @endif
                                                        id="bienthe-{{ $bienthe->id }}" name="bienthe" value="{{ $bienthe->id }}" class="d-none" data-variant-id="{{ $bienthe->id }}" onclick="updatePrice(this)">
                                                        <label for="bienthe-{{ $bienthe->id }}" 
                                                            class="color-list__button rounded-8 px-12 py-8 border border-2 border-gray-50 hover-border-main-600 transition-1 @if($loop->first) border-gray-900 @endif " style="cursor: pointer;">
                                                            {{ $bienthe->loaibienthe->ten }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <span class="mt-32 text-gray-700 border-top border-gray-100 d-block"></span>

                                    

                                    <a href="https://www.whatsapp.com" class="btn btn-black flex-center gap-8 rounded-8 py-16">
                                        <i class="ph ph-whatsapp-logo text-lg"></i>
                                    Liên hệ với cửa hàng
                                    </a>
                                    
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="product-details__sidebar py-40 px-32 border border-gray-100 rounded-16">
            
                            <div class="mb-20">
                                <h6 for="stock" class="mb-8 text-heading fw-semibold d-block">Giỏ hàng</h6>
                                <span class="text-xl d-flex">
                                    <i class="ph ph-location"></i>
                                </span>
                                <div class="d-flex rounded-4 overflow-hidden">
                                    <button type="button" id="quantity-minus" class="quantity__minus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white">
                                        <i class="ph ph-minus"></i>
                                    </button>
                                    <input type="number" id="quantity-input" value="1" min="1" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-16">
                                    <button type="button" id="quantity-plus" class="quantity__plus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white">
                                        <i class="ph ph-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-main flex-center gap-8 rounded-8 py-16 fw-normal mt-10 w-100">
                                <i class="ph ph-shopping-cart-simple text-lg"></i>
                                Thêm vào giỏ hàng
                            </button>

                            <div class="mt-32">
                                
                                <a href="{{ url('san-pham?thuonghieu='.$sanpham->thuonghieu->slug) }}" class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-20 mb-0" style="justify-content: start;">
                                    <span class="w-32 h-32 bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0">
                                        <i class="ph-fill ph-storefront"></i>
                                    </span>
                                    <span class="text-sm text-neutral-600"><span class="fw-semibold">{{ $sanpham->thuonghieu->ten }}</span> </span>
                                </a>
                            </div>

                            <div class="mt-32">
                                <div class="px-32 py-16 rounded-8 border border-gray-100 flex-between gap-8">
                                    <a href="#" class="d-flex text-main-600 text-28"><i class="ph-fill ph-chats-teardrop"></i></a>
                                    <span class="h-26 border border-gray-100"></span>

                                    <div class="dropdown on-hover-item">
                                        <button class="d-flex text-main-600 text-28" type="button">
                                            <i class="ph-fill ph-share-network"></i>
                                        </button>
                                        <div class="on-hover-dropdown common-dropdown border-0 inset-inline-start-auto inset-inline-end-0" >
                                            <ul class="flex-align gap-16">
                                                <li>
                                                    <a href="https://www.facebook.com" class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-facebook-logo"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.twitter.com" class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-twitter-logo"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com" class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
                                                        <i class="ph-fill ph-instagram-logo"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.pinterest.com" class="w-44 h-44 flex-center bg-main-100 text-main-600 text-xl rounded-circle hover-bg-main-600 hover-text-white">
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

                <div class="pt-80">
                    <div class="product-dContent border rounded-24">
                        <div class="product-dContent__header border-bottom border-gray-100 flex-between flex-wrap gap-16">
                            <ul class="nav common-tab nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="true">Mô tả sản phẩm</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">Đánh giá</button>
                                </li>
                            </ul>
                            <!-- <a href="#" class="btn bg-color-one rounded-16 flex-align gap-8 text-main-600 hover-bg-main-600 hover-text-white">
                                <img src="{{asset('assets/client')}}/images/icon/satisfaction-icon.png" alt="">
                                100% Satisfaction Guaranteed
                            </a> -->
                        </div>
                        <div class="product-dContent__box py-20">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                                    {{ $sanpham->mota }}
                                </div>
                                <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <h6 class="mb-24 title">Đánh giá về sản phẩm</h6>
                                            <div class="d-flex align-items-start gap-24 pb-44 border-bottom border-gray-100 mb-44">
                                                <img src="{{asset('assets/client')}}/images/thumbs/comment-img1.png" alt="" class="w-52 h-52 object-fit-cover rounded-circle flex-shrink-0">
                                                <div class="flex-grow-1">
                                                    <div class="flex-between align-items-start gap-8 ">
                                                        <div class="">
                                                            <h6 class="mb-12 text-md">Nicolas cage</h6>
                                                            <div class="flex-align gap-8">
                                                                <span class="text-md fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-md fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-md fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-md fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-md fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            </div>
                                                        </div>
                                                        <span class="text-gray-800 text-sm">3 ngày trước</span>
                                                    </div>
                                                    <p class="text-gray-700 mt-10">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour</p>

                                                    <div class="flex-align gap-20 mt-10">
                                                        <button class="flex-align gap-12 text-gray-700 hover-text-main-600">
                                                            <i class="ph-bold ph-thumbs-up"></i>
                                                            Hữu ích
                                                        </button>
                                                        
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mt-56">
                                                <div class="">
                                                    <h6 class="mb-24">Viết bài đánh giá</h6>
                                                    <span class="text-heading mb-8">Bạn có hài lòng với sản phẩm này không ?</span>
                                                    <div class="flex-align gap-8">
                                                        <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                        <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                        <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                        <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                        <span class="text-2xl fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                    </div>
                                                </div>
                                                <div class="mt-32">
                                                    <form action="#">   
                                                        
                                                        <div class="mb-10">
                                                            <label for="desc" class="text-neutral-600 mb-8">Nội dung</label>
                                                            <textarea class="common-input rounded-8" id="desc" placeholder="Nhập những dòng suy nghĩ của bạn..."></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-main rounded-pill mt-20">Đăng tải</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="ms-xxl-5">
                                                <h6 class="mb-24">Đánh giá từ khách hàng</h6>
                                                <div class="d-flex flex-wrap gap-44">
                                                    <div class="border border-gray-100 rounded-8 px-40 py-52 flex-center flex-column flex-shrink-0 text-center">
                                                        <h2 class="mb-6 text-main-600">4.8</h2>
                                                        <div class="flex-center gap-8">
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                        </div>
                                                        <span class="mt-16 text-gray-500">Điểm đánh giá trung bình</span>
                                                    </div>
                                                    <div class="border border-gray-100 rounded-8 px-24 py-40 flex-grow-1">
                                                        <div class="flex-align gap-8 mb-20">
                                                            <span class="text-gray-900 flex-shrink-0">5</span>
                                                            <div class="progress w-100 bg-gray-100 rounded-pill h-8" role="progressbar" aria-label="Basic example" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 70%"></div>
                                                            </div>
                                                            <div class="flex-align gap-4">
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            </div>
                                                            <span class="text-gray-900 flex-shrink-0">124</span>
                                                        </div>
                                                        <div class="flex-align gap-8 mb-20">
                                                            <span class="text-gray-900 flex-shrink-0">4</span>
                                                            <div class="progress w-100 bg-gray-100 rounded-pill h-8" role="progressbar" aria-label="Basic example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 50%"></div>
                                                            </div>
                                                            <div class="flex-align gap-4">
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            </div>
                                                            <span class="text-gray-900 flex-shrink-0">52</span>
                                                        </div>
                                                        <div class="flex-align gap-8 mb-20">
                                                            <span class="text-gray-900 flex-shrink-0">3</span>
                                                            <div class="progress w-100 bg-gray-100 rounded-pill h-8" role="progressbar" aria-label="Basic example" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 35%"></div>
                                                            </div>
                                                            <div class="flex-align gap-4">
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            </div>
                                                            <span class="text-gray-900 flex-shrink-0">12</span>
                                                        </div>
                                                        <div class="flex-align gap-8 mb-20">
                                                            <span class="text-gray-900 flex-shrink-0">2</span>
                                                            <div class="progress w-100 bg-gray-100 rounded-pill h-8" role="progressbar" aria-label="Basic example" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 20%"></div>
                                                            </div>
                                                            <div class="flex-align gap-4">
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            </div>
                                                            <span class="text-gray-900 flex-shrink-0">5</span>
                                                        </div>
                                                        <div class="flex-align gap-8 mb-0">
                                                            <span class="text-gray-900 flex-shrink-0">1</span>
                                                            <div class="progress w-100 bg-gray-100 rounded-pill h-8" role="progressbar" aria-label="Basic example" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-main-600 rounded-pill" style="width: 5%"></div>
                                                            </div>
                                                            <div class="flex-align gap-4">
                                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                                <span class="text-xs fw-medium text-gray-400 d-flex"><i class="ph-fill ph-star"></i></span>
                                                            </div>
                                                            <span class="text-gray-900 flex-shrink-0">2</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>  
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========================== Product Details Two End =========================== -->

            <!-- ========================== Similar Product Start ============================= -->
        <section class="new-arrival pb-20">
            <div class="container container-lg">
                <div class="section-heading">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Sản phẩm tương tự</h5>
                        <div class="flex-align gap-16">
                            <div class="flex-align gap-8">
                                <button type="button" id="new-arrival-prev" class="slick-prev slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1" >
                                    <i class="ph ph-caret-left"></i>
                                </button>
                                <button type="button" id="new-arrival-next" class="slick-next slick-arrow flex-center rounded-circle border border-gray-100 hover-border-main-600 text-xl hover-bg-main-600 hover-text-white transition-1" >
                                    <i class="ph ph-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="new-arrival__slider arrow-style-two">
                    @foreach ( $relatedProducts as $product)
                        <div>
                        <div class="product-card h-100 border border-gray-100 hover-border-main-600 rounded-6 position-relative transition-2">
                            <a href="{{ route('chi-tiet-san-pham',$product->slug) }}" class="flex-center rounded-8 bg-gray-50 position-relative">
                                <img src="{{ asset('assets/client') }}/images/thumbs/{{ $product->hinhanhsanpham->first()->hinhanh }}" alt="{{ $product->ten }}" class="w-100 rounded-top-2">
                            </a>
                            <div class="product-card__content w-100 h-100 align-items-stretch flex-column justify-content-between d-flex mt-10 px-10 pb-8">
                                <div>
                                <div class="flex-align justify-content-between mt-5">
                                    <div class="flex-align gap-4 w-100">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <a href="{{ url('san-pham?thuonghieu='.$product->thuonghieu->slug) }}" class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:100%; display: inline-block;" title="Trung Tâm Bán Hàng Siêu Thị Vina">Trung Tâm Bán Hàng Siêu Thị Vina</a>
                                    </div>
                                </div>
                                <h6 class="title text-lg fw-semibold mt-2 mb-2">
                                <a href="{{ route('chi-tiet-san-pham',$product->slug) }}" class="link text-line-2" tabindex="0">{{ $product->ten }}</a>
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
        </section>
        <!-- ========================== Similar Product End ============================= -->
    </div>
    <script>
    // 1. Lưu trữ dữ liệu biến thể từ PHP vào JavaScript
    const variants = @json($variantsData);

    /**
     * Cập nhật giá sản phẩm dựa trên biến thể được chọn.
     * @param {HTMLInputElement} element - Nút radio được click.
     */
    function updatePrice(element) {
        const variantId = element.value;
        const variant = variants[variantId];
        
        if (!variant) {
            console.error('Không tìm thấy dữ liệu biến thể với ID:', variantId);
            return;
        }

        const currentPriceElement = document.getElementById('current-price');
        const originalPriceElement = document.getElementById('original-price');
        const priceContainer = document.querySelector('.price-container');

        // 2. Cập nhật Giá đang bán
        currentPriceElement.textContent = variant.sale_price + ' ₫';

        // 3. Cập nhật Giá gốc (gạch ngang)
        if (variant.is_sale) {
            if (!originalPriceElement) {
                // Tạo element nếu chưa có (dùng lại cấu trúc HTML để tránh lỗi)
                const priceWrapper = currentPriceElement.closest('div').parentElement;
                const originalSpan = document.createElement('span');
                originalSpan.id = 'original-price';
                originalSpan.className = 'text-xl text-gray-400 mb-0 fw-medium text-decoration-line-through';
                currentPriceElement.after(originalSpan);
                originalPriceElement = originalSpan;
            }
            originalPriceElement.textContent = variant.original_price + ' ' + ' ₫';
            originalPriceElement.style.display = 'inline';
        } else {
            // Ẩn giá gốc nếu không có giảm giá
            if (originalPriceElement) {
                originalPriceElement.style.display = 'none';
            }
        }
    }
</script>
@endsection