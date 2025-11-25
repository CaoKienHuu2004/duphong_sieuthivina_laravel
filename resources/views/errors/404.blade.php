@extends('client.layouts.app')

@section('title')
    Không tìm thấy trang - 404 Not Found | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
        <div class="container py-5 text-center min-vh-50 d-flex flex-column justify-content-center align-items-center">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-7">
                    {{-- Icon hoặc Ảnh minh họa --}}
                    <div class="mb-4">
                        {{-- Bạn có thể dùng ảnh của bạn hoặc icon lớn --}}
                        <i class="fas fa-ghost text-secondary" style="font-size: 8rem; opacity: 0.2;"></i>
                        {{-- Hoặc dùng ảnh: <img src="{{ asset('assets/images/404.png') }}" class="img-fluid"
                            style="max-height: 250px;"> --}}
                    </div>

                    <h1 class="display-1 fw-bold text-danger mb-0">404</h1>
                    <h2 class="h4 mb-3 fw-bold text-dark">Oops! Không tìm thấy trang này.</h2>

                    <p class="text-gray-600 text-md fw-normal mb-4 mt-10">
                        Có vẻ như trang bạn đang tìm kiếm không tồn tại, đã bị xóa hoặc đường dẫn không đúng.
                        Hãy thử quay lại trang chủ hoặc tìm kiếm sản phẩm khác nhé.
                    </p>

                    <div class="d-flex justify-content-center mt-20">
                        <a href="{{ url('/') }}" class="btn btn-danger rounded-pill px-18 py-12 fw-semibold text-sm flex-align gap-8">
                            <i class="ph-bold ph-house"></i> Về Trang Chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* CSS inline nhỏ để căn chỉnh chiều cao nếu nội dung ít */
            .min-vh-50 {
                min-height: 60vh;
            }
        </style>
    </div>
@endsection