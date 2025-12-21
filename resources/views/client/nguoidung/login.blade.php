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
                            <label for="phonemail" class="text-neutral-900 text-lg mb-8 fw-medium">Email hoặc Điện thoại<span class="text-danger">*</span> </label>
                            <input type="text" class="text-md common-input @error('phonemail') is-invalid @enderror"
                                   id="phonemail" name="phonemail"
                                   placeholder="Nhập email hoặc số điện thoại"
                                   value="{{ old('phonemail') }}" required>
                            @error('phonemail')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-24">
                            <label for="password" class="text-neutral-900 text-lg mb-8 fw-medium">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" class="text-md common-input @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="Nhập mật khẩu" required>
                                <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash"
                                      onclick="togglePassword('password')"></span>
                            </div>
                            @error('password')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-24 mt-20">
                            <div class="flex-align gap-48 flex-wrap">
                                <button type="submit" class="btn btn-main py-18 px-40">Đăng nhập</button>
                                <div class="form-check common-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                    <label class="form-check-label flex-grow-1" for="remember">Ghi nhớ đăng nhập</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-20 flex-align flex-between gap-24">
                            <a href="#" class="text-danger-600 text-sm fw-semibold p-0 m-0 hover-text-decoration-underline">Quên mật khẩu ?</a>
                            <span class="text-gray-900 text-sm fw-normal">Bạn chưa có tài khoản ? <a href="{{ route('dang-ky') }}" class="text-main-600 hover-text-decoration-underline text-sm fw-semibold">Đăng ký ngay</a></span>
                        </div>
                        
                    </form>
                    
                </div>
                {{-- <a href="{{ route('login.google') }}" class="btn btn-white border border-gray-100 hover-border-gray-200 mt-10 mb-20 flex-align gap-8 justify-content-center" style="width: 100%; text-align: center;">
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
