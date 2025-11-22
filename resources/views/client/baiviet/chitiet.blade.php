@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <section class="blog-details py-80 fix-scale-150">
            <div class="container container-lg">
                <div class="row gy-5">
                    <div class="col-lg-8 pe-xl-4">
                        <div class="blog-item-wrapper">
                            <div class="blog-item">
                                <img src="{{asset('assets/client')}}/images/thumbs/blog-img1.png" alt=""
                                    class="cover-img rounded-16">
                                <div class="blog-item__content mt-24">
                                    <span class="bg-main-50 text-main-600 py-4 px-24 rounded-8 mb-16">Gadget</span>
                                    <h4 class="mb-24">Nice decoration make be distilled to a single house</h4>
                                    <p class="text-gray-700 mb-24">A great commerce experience cannot be distilled to a
                                        single number. It's not a Lighthouse score, or a set of Core Web Vitals figures,
                                        although both are important inputs. A great commerce experience is a trilemma that
                                        carefully balances competing needs of delivering great customer experience, dynamic
                                        storefront capabilities, and long-term business — conversion, retention,
                                        re-engagement — objectives. As developers, we rightfully obsess about the customer
                                        experience, relentlessly working to squeeze every millisecond out of the critical
                                        rendering path, optimize input latency, and eliminate jank. At the limit, statically
                                        generated, edge delivered, and HTML-first pages look like the optimal strategy. That
                                        is until you are confronted with the realization that the next step function in
                                        improving conversion rates and business.</p>
                                    <p class="text-gray-700 pb-24 mb-24 border-bottom border-gray-100">Re-engagement —
                                        objectives. As developers, we rightfully obsess about the customer experience,
                                        relentlessly working to squeeze every millisecond out of the critical rendering
                                        path, optimize input latency, and eliminate...</p>

                                    <div class="flex-align flex-wrap gap-24">
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                            <span class="text-sm text-gray-500">
                                                <a href="blog-details.html" class="text-gray-500 hover-text-main-600">July
                                                    12, 2025</a>
                                            </span>
                                        </div>
                                        <div class="flex-align flex-wrap gap-8">
                                            <span class="text-lg text-main-600"><i class="ph ph-chats-circle"></i></span>
                                            <span class="text-sm text-gray-500">
                                                <a href="blog-details.html" class="text-gray-500 hover-text-main-600">102
                                                    Lượt xem</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-48 flex-between flex-sm-nowrap flex-wrap gap-24">
                            <div class="">
                                <button type="button"
                                    class="mb-20 h6 text-gray-500 text-lg fw-normal hover-text-main-600">Trước đó</button>
                                <h6 class="text-lg mb-0">
                                    <a href="blog-details.html" class="">A great commerce experience cannot be distilled to
                                        a single number. </a>
                                </h6>
                            </div>
                            <div class="text-end">
                                <button type="button"
                                    class="mb-20 h6 text-gray-500 text-lg fw-normal hover-text-main-600">Tiếp theo</button>
                                <h6 class="text-lg mb-0">
                                    <a href="blog-details.html" class="">A great commerce experience cannot be distilled to
                                        a single number. </a>
                                </h6>
                            </div>
                        </div>

                        <div class="my-48">
                            <span class="border-bottom border-gray-100 d-block"></span>
                        </div>
                    </div>


                    <div class="col-lg-4 ps-xl-4">

                        <!-- Recent Post Start -->
                        <div class="blog-sidebar border border-gray-100 rounded-8 p-32 mb-40">
                            <h6 class="text-xl mb-32 pb-32 border-bottom border-gray-100">Recent Posts</h6>
                            <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16">
                                <a href="blog-details.html"
                                    class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                    <img src="{{asset('assets/client')}}/images/thumbs/recent-post1.png" alt=""
                                        class="cover-img">
                                </a>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg">
                                        <a href="blog-details.html" class="text-line-3">Once determined you need to come up
                                            with a name</a>
                                    </h6>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.html" class="text-gray-500 hover-text-main-600">July 12,
                                                2025</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16">
                                <a href="blog-details.html"
                                    class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                    <img src="{{asset('assets/client')}}/images/thumbs/recent-post2.png" alt=""
                                        class="cover-img">
                                </a>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg">
                                        <a href="blog-details.html" class="text-line-3">Once determined you need to come up
                                            with a name</a>
                                    </h6>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.html" class="text-gray-500 hover-text-main-600">July 12,
                                                2025</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-16">
                                <a href="blog-details.html"
                                    class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                    <img src="{{asset('assets/client')}}/images/thumbs/recent-post3.png" alt=""
                                        class="cover-img">
                                </a>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg">
                                        <a href="blog-details.html" class="text-line-3">Once determined you need to come up
                                            with a name</a>
                                    </h6>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.html" class="text-gray-500 hover-text-main-600">July 12,
                                                2025</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-sm-nowrap flex-wrap gap-24 mb-0">
                                <a href="blog-details.html"
                                    class="w-100 h-100 rounded-4 overflow-hidden w-120 h-120 flex-shrink-0">
                                    <img src="{{asset('assets/client')}}/images/thumbs/recent-post4.png" alt=""
                                        class="cover-img">
                                </a>
                                <div class="flex-grow-1">
                                    <h6 class="text-lg">
                                        <a href="blog-details.html" class="text-line-3">Once determined you need to come up
                                            with a name</a>
                                    </h6>
                                    <div class="flex-align flex-wrap gap-8">
                                        <span class="text-lg text-main-600"><i class="ph ph-calendar-dots"></i></span>
                                        <span class="text-sm text-gray-500">
                                            <a href="blog-details.html" class="text-gray-500 hover-text-main-600">July 12,
                                                2025</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Recent Post End -->

                        <!-- Tags Start -->
                        <div class="blog-sidebar border border-gray-100 rounded-8 p-32 mb-40">
                            <h6 class="text-xl mb-32 pb-32 border-bottom border-gray-100">Recent Posts</h6>
                            <ul>
                                <li class="mb-16">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Gaming (12)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                                <li class="mb-16">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Smart Gadget (05)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                                <li class="mb-16">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Software (29)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                                <li class="mb-16">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Electronics (24)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                                <li class="mb-16">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Laptop (08)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                                <li class="mb-16">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Mobile & Accessories (16)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                                <li class="mb-0">
                                    <a href="blog-details.html"
                                        class="flex-between gap-8 text-gray-700 border border-gray-100 rounded-4 p-4 ps-16 hover-border-main-600 hover-text-main-600">
                                        <span>Apliance (24)</span>
                                        <span class="w-40 h-40 flex-center rounded-4 bg-main-50 text-main-600"><i
                                                class="ph ph-arrow-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Tags End -->

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection