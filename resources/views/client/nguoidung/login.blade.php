@extends('client.layouts.app')

@section('content')
    <div class="page">
        <!-- =============================== Account Section Start =========================== -->
        <section class="account pt-20">
            <div class="container container-lg">
                <div class="row gy-4 justify-content-center">

                    <!-- Login Card Start -->
                    <div class="col-xl-5">
                        <div class="border border-gray-100 rounded-16 px-24 py-40 h-100">
                            <h6 class="text-xl mb-32">Đăng nhập</h6>

                            <form action="{{ route('handleLogin') }}" method="POST">
                                @csrf
                                <div class="mb-24">
                                    <label for="phonemail" class="text-neutral-900 text-lg mb-8 fw-medium">Email hoặc Điện
                                        thoại<span class="text-danger">*</span> </label>
                                    <input type="text" class="text-md common-input @error('phonemail') is-invalid @enderror"
                                        id="phonemail" name="phonemail" placeholder="Nhập email hoặc số điện thoại"
                                        value="{{ old('phonemail') }}" required>
                                    @error('phonemail')
                                        <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-24">
                                    <label for="password" class="text-neutral-900 text-lg mb-8 fw-medium">Mật khẩu <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input type="password"
                                            class="text-md common-input @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Nhập mật khẩu" required>
                                        <span
                                            class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash"
                                            onclick="togglePassword('password')"></span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-24 mt-20">
                                    <div class="flex-between gap-48 flex-wrap">
                                        <div class="form-check common-check mb-0">
                                            <input class="form-check-input" type="checkbox" value="1" id="remember"
                                                name="remember">
                                            <label class="form-check-label flex-grow-1" for="remember">Ghi nhớ đăng
                                                nhập</label>
                                        </div>
                                        <a href="#"
                                            class="text-danger-600 text-md fw-semibold p-0 m-0 mt-2 hover-text-decoration-underline">Quên
                                            mật khẩu ?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-main py-18 px-40 w-100">Đăng nhập</button>
                                <style>
                                    .login-divider {
                                        display: flex;
                                        align-items: center;
                                        text-align: center;
                                        margin: 20px 0;
                                        /* Khoảng cách trên dưới 20px */
                                        color: #6c757d;
                                        /* Màu chữ xám (Bootstrap secondary) */
                                        font-size: 14px;
                                        font-weight: 400;
                                    }

                                    /* Tạo đường kẻ bên trái và phải */
                                    .login-divider::before,
                                    .login-divider::after {
                                        content: '';
                                        flex: 1;
                                        /* Tự động lấp đầy khoảng trống */
                                        border-bottom: 1px solid #dee2e6;
                                        /* Màu đường kẻ (Xám nhạt) */
                                    }

                                    /* Tạo khoảng cách giữa chữ "hoặc" và đường kẻ */
                                    .login-divider::before {
                                        margin-right: 15px;
                                    }

                                    .login-divider::after {
                                        margin-left: 15px;
                                    }

                                    /* (Tùy chọn) Chỉnh chữ 'hoặc' viết hoa nhỏ nếu thích */
                                    .login-divider span {
                                        text-transform: uppercase;
                                        font-size: 12px;
                                        letter-spacing: 1px;
                                    }
                                </style>
                                <div class="login-divider">
                                    <span>hoặc</span>
                                </div>
                                <a href="{{ route('login.google') }}"
                                    class="btn btn-white border border-gray-100 hover-border-gray-200 mt-10 mb-20 flex-align gap-8 justify-content-center">
                                    <div class="icon-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px"
                                            viewBox="-3 0 262 262" preserveAspectRatio="xMidYMid">
                                            <path
                                                d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
                                                fill="#4285F4" />
                                            <path
                                                d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
                                                fill="#34A853" />
                                            <path
                                                d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
                                                fill="#FBBC05" />
                                            <path
                                                d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
                                                fill="#EB4335" />
                                        </svg>
                                    </div>
                                    <span class="btn-text">Đăng nhập bằng Google</span>
                                </a>
                                <div class="mt-20 flex-align flex-between gap-24">


                                    <span class="text-gray-900 text-sm fw-normal">Bạn chưa có tài khoản ? <a
                                            href="{{ route('dang-ky') }}"
                                            class="text-main-600 hover-text-decoration-underline text-sm fw-semibold">Đăng
                                            ký ngay</a></span>
                                </div>

                            </form>

                        </div>
                        {{-- <a href="{{ route('login.google') }}"
                            class="btn btn-white border border-gray-100 hover-border-gray-200 mt-10 mb-20 flex-align gap-8 justify-content-center"
                            style="width: 100%; text-align: center;">
                            <i class="ph-bold ph-google-logo text-2xl"></i> Đăng nhập bằng Google
                        </a> --}}
                    </div>

                </div>
            </div>
        </section>
        <!-- =============================== Account Section End =========================== -->
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.nextElementSibling;

            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.remove('ph-eye-slash');
                toggle.classList.add('ph-eye');
            } else {
                input.type = 'password';
                toggle.classList.remove('ph-eye');
                toggle.classList.add('ph-eye-slash');
            }
        }
    </script>
@endsection