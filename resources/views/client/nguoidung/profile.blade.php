@extends('client.layouts.app')

@section('content')
    <div class="page">
         <!-- =============================== Account Section Start =========================== -->
 <section class="account py-80">
    <div class="container container-lg">
        <div class="row gy-4">

            <!-- Profile Card Start -->
            <div class="col-xl-8 mx-auto">
                <div class="border border-gray-100 hover-border-main-600 transition-1 rounded-16 px-24 py-40">
                    <h6 class="text-xl mb-32">Thông tin cá nhân</h6>

                    <!-- Hiển thị thông báo thành công -->
                    @if (session('success'))
                        <div class="alert alert-success mb-24">
                            {{ session('success') }}
                        </div>
                    @endif

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

                    <form action="{{ route('cap-nhat-tai-khoan') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-24">
                                <label for="username" class="text-neutral-900 text-lg mb-8 fw-medium">Tên đăng nhập</label>
                                <input type="text" class="common-input"
                                       id="username" name="username"
                                       value="{{ $user->username }}"
                                       readonly>
                                <small class="text-gray-500">Tên đăng nhập không thể thay đổi</small>
                            </div>
                            <div class="col-md-6 mb-24">
                                <label for="hoten" class="text-neutral-900 text-lg mb-8 fw-medium">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="common-input @error('hoten') is-invalid @enderror"
                                       id="hoten" name="hoten"
                                       placeholder="Nhập họ và tên"
                                       value="{{ old('hoten', $user->hoten) }}">
                                @error('hoten')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-24">
                                <label for="sodienthoai" class="text-neutral-900 text-lg mb-8 fw-medium">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="common-input @error('sodienthoai') is-invalid @enderror"
                                       id="sodienthoai" name="sodienthoai"
                                       placeholder="Nhập số điện thoại"
                                       value="{{ old('sodienthoai', $user->sodienthoai) }}">
                                @error('sodienthoai')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-24">
                                <label for="gioitinh" class="text-neutral-900 text-lg mb-8 fw-medium">Giới tính <span class="text-danger">*</span></label>
                                <select class="common-input @error('gioitinh') is-invalid @enderror"
                                        id="gioitinh" name="gioitinh">
                                    <option value="">Chọn giới tính</option>
                                    <option value="nam" {{ old('gioitinh', $user->gioitinh) == 'nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="nu" {{ old('gioitinh', $user->gioitinh) == 'nu' ? 'selected' : '' }}>Nữ</option>
                                    <option value="khac" {{ old('gioitinh', $user->gioitinh) == 'khac' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('gioitinh')
                                    <div class="text-danger text-sm mt-4">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-24">
                            <label for="ngaysinh" class="text-neutral-900 text-lg mb-8 fw-medium">Ngày sinh <span class="text-danger">*</span></label>
                            <input type="date" class="common-input @error('ngaysinh') is-invalid @enderror"
                                   id="ngaysinh" name="ngaysinh"
                                   value="{{ old('ngaysinh', $user->ngaysinh ? $user->ngaysinh : '') }}">
                            @error('ngaysinh')
                                <div class="text-danger text-sm mt-4">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-24">
                                <label for="vaitro" class="text-neutral-900 text-lg mb-8 fw-medium">Vai trò</label>
                                <input type="text" class="common-input"
                                       id="vaitro" name="vaitro"
                                       value="{{ ucfirst($user->vaitro) }}"
                                       readonly>
                            </div>
                            <div class="col-md-6 mb-24">
                                <label for="trangthai" class="text-neutral-900 text-lg mb-8 fw-medium">Trạng thái</label>
                                <input type="text" class="common-input"
                                       id="trangthai" name="trangthai"
                                       value="{{ $user->trangthai ? 'Hoạt động' : 'Bị khóa' }}"
                                       readonly>
                            </div>
                        </div>

                        <div class="mt-48">
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-main py-18 px-40">Cập nhật thông tin</button>
                                <a href="{{ route('trang-chu') }}" class="btn btn-outline-secondary py-18 px-40">Về trang chủ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Profile Card End -->

        </div>
    </div>
 </section>
<!-- =============================== Account Section End =========================== -->
    </div>
@endsection
