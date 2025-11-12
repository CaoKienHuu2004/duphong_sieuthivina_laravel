@extends('client.layouts.app')

@section('content')
    <div class="page">
         <!-- =============================== Account Section Start =========================== -->
 <section class="account pt-20">
    <div class="container container-lg">
        <div class="row gy-4 justify-content-center">

            <!-- Register Card Start -->
            <div class="col-xl-5">
                <div class="border border-gray-100 rounded-16 px-24 py-40">
                    <h6 class="text-xl mb-32">Đăng ký tài khoản</h6>

                    <!-- Hiển thị lỗi -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-24">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('handleRegister') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-24">
                                <label for="hoten" class="text-neutral-900 text-md mb-8 fw-medium">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="py-14 px-18 text-sm common-input @error('hoten') is-invalid @enderror"
                                       id="hoten" name="hoten"
                                       placeholder="Nhập họ và tên"
                                       value="{{ old('hoten') }}">
                                @error('hoten')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-24">
                                <label for="username" class="text-neutral-900 text-md mb-8 fw-medium">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" class="py-14 px-18 text-sm common-input @error('username') is-invalid @enderror"
                                       id="username" name="username"
                                       placeholder="Nhập tên đăng nhập"
                                       value="{{ old('username') }}">
                                @error('username')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-24">
                                <label for="email" class="text-neutral-900 text-md mb-8 fw-medium">Email <span class="text-danger">*</span></label>
                                <input type="email" class="py-14 px-18 text-sm common-input @error('email') is-invalid @enderror"
                                       id="email" name="email"
                                       placeholder="Nhập email"
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-24">
                                <label for="sodienthoai" class="text-neutral-900 text-md mb-8 fw-medium">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="py-14 px-18 text-sm common-input @error('sodienthoai') is-invalid @enderror"
                                       id="sodienthoai" name="sodienthoai"
                                       placeholder="Nhập số điện thoại"
                                       value="{{ old('sodienthoai') }}">
                                @error('sodienthoai')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="password" class="text-neutral-900 text-md mb-8 fw-medium">Mật khẩu <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="py-14 px-18 text-sm common-input @error('password') is-invalid @enderror"
                                           id="password" name="password"
                                           placeholder="Nhập mật khẩu"
                                           value="{{ old('password') }}">
                                    <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash"
                                          onclick="togglePassword('password')"></span>
                                </div>
                                @error('password')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="text-neutral-900 text-md mb-8 fw-medium">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" class="py-14 px-18 text-sm common-input @error('password_confirmation') is-invalid @enderror"
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Nhập lại mật khẩu">
                                    <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash"
                                          onclick="togglePassword('password_confirmation')"></span>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-20">
                            <p class="text-gray-500">Dữ liệu cá nhân của bạn sẽ được lưu trữ bảo mật, khi bạn nhấn vào <strong>Đăng ký</strong> cũng như đồng ý với các nội dung điều khoản và
                                <a href="#" class="text-main-600 text-decoration-underline"> chính sách bảo mật</a> từ nền tảng.</p>
                        </div>

                        <div class="mt-20">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-main py-14 px-40">Đăng ký</button>
                            </div>
                        </div>
                        <div class="mt-20">
                            <div class="d-flex gap-3">
                                <span class="text-gray-900 text-sm fw-normal">Bạn đã là thành viên ? <a href="{{ route('dang-ky') }}" class="text-main-600 hover-text-decoration-underline text-sm fw-semibold">Đăng nhập ngay</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register Card End -->

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
