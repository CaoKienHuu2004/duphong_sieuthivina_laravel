@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="product-details py-40">
            <div class="container container-lg">
                <div class="row gy-4">
                    <div class="col-xl-9">
                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <div class="product-details__left">
                                    <div class="product-details__thumb-slider p-6 border border-gray-100 rounded-16">
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
                                                    <div class="max-w-120 max-h-120 h-100 flex-center border border-gray-100 rounded-16 p-8">
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
                                        <div class="flex-align gap-12 flex-wrap">
                                            <div class="flex-align gap-8">
                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                                <span class="text-xs fw-medium text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                            </div>
                                            <span class="text-sm fw-medium text-neutral-600">4.7 sao</span>
                                            <span class="text-sm fw-medium text-gray-500">(21,676)</span>
                                        </div>
                                        <span class="text-sm fw-medium text-gray-500">|</span>
                                        <a href="#" class="text-gray-900 flex-align gap-4 hover-text-main-600"><i class="ph-bold ph-storefront"></i> Apple </a>
                                    </div>
                                    
                                    <!-- <span class="mt-32 text-gray-700 border-top border-gray-100 d-block"></span> -->

                                    <div class="my-32 flex-align gap-16 flex-wrap">
                                        <div class="flex-align gap-8">
                                            <div class="flex-align gap-8 text-main-two-600">
                                                <i class="ph-fill ph-seal-percent text-xl"></i>
                                                -10%
                                            </div>
                                            <h6 class="mb-0">300.000 đ</h6>
                                        </div>
                                        <div class="flex-align gap-8">
                                            <span class="text-gray-700">Giá gốc</span>
                                            <h6 class="text-xl text-gray-400 mb-0 fw-medium text-decoration-line-through">425.000 đ</h6>
                                        </div>
                                    </div>
                                    
                                    <span class="mt-32 pt-32 text-gray-700 border-top border-gray-100 d-block"></span>

                                    <div class="mt-10">
                                        <h6 class="mb-16">Loại sản phẩm</h6>
                                        <div class="flex-between align-items-start flex-wrap gap-16">
                                            <!-- <div>
                                                <span class="text-gray-900 d-block mb-12">
                                                    Color: 
                                                    <span class="fw-medium">Mineral Silver</span> 
                                                </span>
                                                <div class="color-list flex-align gap-8">
                                                    <button type="button" class="color-list__button w-20 h-20 border border-2 border-gray-50 rounded-circle bg-info-600"></button>
                                                    <button type="button" class="color-list__button w-20 h-20 border border-2 border-gray-50 rounded-circle bg-warning-600"></button>
                                                    <button type="button" class="color-list__button w-20 h-20 border border-2 border-gray-50 rounded-circle bg-tertiary-600"></button>
                                                    <button type="button" class="color-list__button w-20 h-20 border border-2 border-gray-50 rounded-circle bg-main-600"></button>
                                                    <button type="button" class="color-list__button w-20 h-20 border border-2 border-gray-50 rounded-circle bg-gray-100"></button>
                                                </div>
                                            </div> -->
                                            <div>
                                                
                                                <div class="flex-align gap-8 flex-wrap">
                                                    <a class="color-list__button cursor-pointer px-12 py-8 text-sm rounded-8 text-gray-900 border border-gray-200 hover-border-main-600 hover-text-main-600"> with offer </a>
                                                    <a class="color-list__button cursor-pointer px-12 py-8 text-sm rounded-8 text-gray-900 border border-gray-200 hover-border-main-600 hover-text-main-600">12th Gen Laptop</a>
                                                    <a class="color-list__button cursor-pointer px-12 py-8 text-sm rounded-8 text-gray-900 border border-gray-200 hover-border-main-600 hover-text-main-600">without offer</a>
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
            
                            <div class="mb-32">
                                <h6 for="stock" class="mb-8 text-heading fw-semibold d-block">Giỏ hàng</h6>
                                <span class="text-xl d-flex">
                                    <i class="ph ph-location"></i>
                                </span>
                                <div class="d-flex rounded-4 overflow-hidden">
                                    <button type="button" class="quantity__minus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white">
                                        <i class="ph ph-minus"></i>
                                    </button>
                                    <input type="number" class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-16" id="stock" value="1" min="1">
                                    <button type="button" class="quantity__plus flex-shrink-0 h-48 w-48 text-neutral-600 bg-gray-50 flex-center hover-bg-main-600 hover-text-white">
                                        <i class="ph ph-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-32">
                                <div class="flex-between flex-wrap gap-8 border-bottom border-gray-100 pb-16 mb-16">
                                    <span class="text-gray-500">Giá</span>
                                    
                                    <h6 class="text-lg mb-0"><span class="text-sm text-gray-400 mb-0 fw-medium text-decoration-line-through">425.000 đ</span> 300.000 đ</h6>
                                </div>
                            </div>

                            <a href="cart.html" class="btn btn-main flex-center gap-8 rounded-8 py-16 fw-normal mt-48">
                                <i class="ph ph-shopping-cart-simple text-lg"></i>
                                Thêm vào giỏ hàng
                            </a>

                            <div class="mt-32">
                                
                                <div class="px-16 py-8 bg-main-50 rounded-8 flex-between gap-24 mb-0">
                                    <span class="w-32 h-32 bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0">
                                        <i class="ph-fill ph-storefront"></i>
                                    </span>
                                    <span class="text-sm text-neutral-600">Cửa hàng:  <span class="fw-semibold">MR Distribution LLC</span> </span>
                                </div>
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
                </div>

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
                        <div class="product-dContent__box">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab" tabindex="0">
                                    <div class="mb-40">
                                        <h6 class="mb-24">Mô tả về sản phẩm "ABCXYZ"</h6>
                                        <p>Wherever celebrations and good times happen, the LAY'S brand will be there just as it has been for more than 75 years. With flavors almost as rich as our history, we have a chip or crisp flavor guaranteed to bring a smile on your face. </p>
                                        <p>Morbi ut sapien vitae odio accumsan gravida. Morbi vitae erat auctor, eleifend nunc a, lobortis neque. Praesent aliquam dignissim viverra. Maecenas lacus odio, feugiat eu nunc sit amet, maximus sagittis dolor. Vivamus nisi sapien, elementum sit amet eros sit amet, ultricies cursus ipsum. Sed consequat luctus ligula. Curabitur laoreet rhoncus blandit. Aenean vel diam ut arcu pharetra dignissim ut sed leo. Vivamus faucibus, ipsum in vestibulum vulputate, lorem orci convallis quam, sit amet consequat nulla felis pharetra lacus. Duis semper erat mauris, sed egestas purus commodo vel.</p>    
                                        <ul class="list-inside mt-32 ms-16">
                                            <li class="text-gray-400 mb-4">8.0 oz. bag of LAY'S Classic Potato Chips</li>
                                            <li class="text-gray-400 mb-4">Tasty LAY's potato chips are a great snack</li>
                                            <li class="text-gray-400 mb-4">Includes three ingredients: potatoes, oil, and salt</li>
                                            <li class="text-gray-400 mb-4">Gluten free product</li>
                                        </ul>
                                        <ul class="mt-32">
                                            <li class="text-gray-400 mb-4">Made in USA</li>
                                            <li class="text-gray-400 mb-4">Ready To Eat.</li>
                                        </ul>
                                    </div>
                                    <div class="mb-40">
                                        <h6 class="mb-24">Product Specifications</h6>
                                        <ul class="mt-32">
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Product Type:
                                                    <span class="text-gray-500"> Chips & Dips</span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Product Name:
                                                    <span class="text-gray-500"> Potato Chips Classic </span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Brand:
                                                    <span class="text-gray-500"> Lay's</span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    FSA Eligible:
                                                    <span class="text-gray-500"> No</span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Size/Count: 
                                                    <span class="text-gray-500"> 8.0oz</span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Item Code:
                                                    <span class="text-gray-500"> 331539</span>
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium">
                                                    Ingredients:
                                                    <span class="text-gray-500"> Potatoes, Vegetable Oil, and Salt.</span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mb-40">
                                        <h6 class="mb-24">Nutrition Facts</h6>
                                        <ul class="mt-32">
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium"> Total Fat 10g 13%</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium"> Saturated Fat 1.5g 7%</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium"> Cholesterol 0mg 0%</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium"> Sodium 170mg 7%</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-heading fw-medium"> Potassium 350mg 6%</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="mb-0">
                                        <h6 class="mb-24">More Details</h6>
                                        <ul class="mt-32">
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-gray-500"> Lunarlon midsole delivers ultra-plush responsiveness</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-gray-500"> Encapsulated Air-Sole heel unit for lightweight cushioning</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-gray-500"> Colour Shown: Ale Brown/Black/Goldtone/Ale Brown</span>
                                            </li>
                                            <li class="text-gray-400 mb-14 flex-align gap-14">
                                                <span class="w-20 h-20 bg-main-50 text-main-600 text-xs flex-center rounded-circle">
                                                    <i class="ph ph-check"></i>
                                                </span>
                                                <span class="text-gray-500"> Style: 805899-202</span>
                                            </li>
                                        </ul>
                                    </div>

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
                                            <div class="d-flex align-items-start gap-24">
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
        <section class="new-arrival pb-80">
            <div class="container container-lg">
                <div class="section-heading">
                    <div class="flex-between flex-wrap gap-8">
                        <h5 class="mb-0">Có thể bạn sẽ thích</h5>
                        <div class="flex-align gap-16">
                            <a href="shop.html" class="text-sm fw-medium text-gray-700 hover-text-main-600 hover-text-decoration-underline">Xem đầy đủ</a>
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
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img7.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">C-500 Antioxidant Protect Dietary Supplement</a>
                                </h6>   
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs"> Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">25.000 đ </span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> 50.000 đ</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Thêm giỏ hàng <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Giảm 50% </span>
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img8.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">Marcel's Modern Pantry Almond Unsweetened</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">25.000 đ</span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> 50.000 đ</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Thêm giỏ hàng <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50% </span>
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img9.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">O Organics Milk, Whole, Vitamin D</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> $28.99</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <span class="product-card__badge bg-info-600 px-8 py-4 text-sm text-white">Best Sale </span>
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img10.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">Whole Grains and Seeds Organic Bread</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> $28.99</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img11.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">Lucerne Yogurt, Lowfat, Strawberry</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> $28.99</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <span class="product-card__badge bg-danger-600 px-8 py-4 text-sm text-white">Sale 50% </span>
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img12.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">Nature Valley Whole Grain Oats and Honey Protein</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> $28.99</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="product-card h-100 p-8 border border-gray-100 hover-border-main-600 rounded-16 position-relative transition-2">
                            <span class="product-card__badge bg-info-600 px-8 py-4 text-sm text-white">Best Sale </span>
                            <a href="product-details.html" class="product-card__thumb flex-center overflow-hidden">
                                <img src="{{asset('assets/client')}}/images/thumbs/product-img10.png" alt="">
                            </a>
                            <div class="product-card__content p-sm-2 w-100">
                                <h6 class="title text-lg fw-semibold mt-12 mb-8">
                                    <a href="product-details.html" class="link text-line-2">Whole Grains and Seeds Organic Bread</a>
                                </h6>
                                <div class="flex-align gap-4">
                                    <span class="text-main-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs">By Lucky Supermarket</span>
                                </div>

                                <div class="product-card__content mt-12">
                                    <div class="product-card__price mb-8">
                                        <span class="text-heading text-md fw-semibold ">$14.99 <span class="text-gray-500 fw-normal">/Qty</span> </span>
                                        <span class="text-gray-400 text-md fw-semibold text-decoration-line-through"> $28.99</span>
                                    </div>
                                    <div class="flex-align gap-6">
                                        <span class="text-xs fw-bold text-gray-600">4.8</span>
                                        <span class="text-15 fw-bold text-warning-600 d-flex"><i class="ph-fill ph-star"></i></span>
                                        <span class="text-xs fw-bold text-gray-600">(17k)</span>
                                    </div>
                                    <a href="cart.html" class="product-card__cart btn bg-main-50 text-main-600 hover-bg-main-600 hover-text-white py-11 px-24 rounded-pill flex-align gap-8 mt-24 w-100 justify-content-center">
                                        Add To Cart <i class="ph ph-shopping-cart"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ========================== Similar Product End ============================= -->
    </div>
@endsection