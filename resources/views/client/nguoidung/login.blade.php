@extends('client.layouts.app')

@section('content')
    <div class="page">
         <!-- =============================== Account Section Start =========================== -->
 <section class="account py-80">
    <div class="container container-lg">
        <div class="row gy-4 justify-content-center">

            <!-- Login Card Start -->
            <div class="col-xl-6">
                <div class="border border-gray-100 hover-border-main-600 transition-1 rounded-16 px-24 py-40 h-100">
                    <h6 class="text-xl mb-32">Đăng nhập</h6>

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

                    <form action="{{ route('handleLogin') }}" method="POST">
                        @csrf
                        <div class="mb-24">
                            <label for="username" class="text-neutral-900 text-lg mb-8 fw-medium">Tên đăng nhập <span class="text-danger">*</span> </label>
                            <input type="text" class="common-input @error('username') is-invalid @enderror"
                                   id="username" name="username"
                                   placeholder="Nhập tên đăng nhập"
                                   value="{{ old('username') }}">
                            @error('username')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-24">
                            <label for="password" class="text-neutral-900 text-lg mb-8 fw-medium">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" class="common-input @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="Nhập mật khẩu">
                                <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y cursor-pointer ph ph-eye-slash"
                                      onclick="togglePassword('password')"></span>
                            </div>
                            @error('password')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-24 mt-48">
                            <div class="flex-align gap-48 flex-wrap">
                                <button type="submit" class="btn btn-main py-18 px-40">Đăng nhập</button>
                                <div class="form-check common-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                                    <label class="form-check-label flex-grow-1" for="remember">Ghi nhớ đăng nhập</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-48">
                            <a href="#" class="text-danger-600 text-sm fw-semibold hover-text-decoration-underline">Quên mật khẩu?</a>
                        </div>
                    </form>
                </div>
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
