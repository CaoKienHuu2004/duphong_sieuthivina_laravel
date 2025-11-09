@extends('client.layouts.app')

@section('title')
    Thông tin cá nhân | Siêu Thị Vina - Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <style>
    /* CSS cho Avatar */
    .avatar-container {
        width: 100px; /* Kích thước container */
        height: 100px;
        border-radius: 50%; /* Tạo hình tròn */
        overflow: hidden; /* Cắt ảnh thừa ra khỏi hình tròn */
        cursor: pointer; /* Thay đổi con trỏ chuột thành dạng "click" */
        /* Có thể thêm box-shadow hoặc border nếu muốn */
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Đảm bảo ảnh lấp đầy container mà không bị méo */

    }
    </style>
    <div class="page">
        <section class="shop py-40">
                <div class="container container-lg">
                    <div class="row">
                        <div class="col-lg-3">
                        <div class="shop-sidebar">
                                <button type="button"
                                    class="shop-sidebar__close d-lg-none d-flex w-32 h-32 flex-center border border-gray-100 rounded-circle hover-bg-main-600 position-absolute inset-inline-end-0 me-10 mt-8 hover-text-white hover-border-main-600">
                                    <i class="ph ph-x"></i>
                                </button>
                                <div class="shop-sidebar__box border border-gray-100 rounded-8 p-16 pb-0 mb-20">
                                    <div class="border-bottom border-gray-100 pb-16 mb-16">
                                        <a href="http://127.0.0.1:8000/san-pham?thuonghieu=chat-viet-group" class="px-16 py-8 bg-gray-50 rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                            <span class="bg-white text-main-600 rounded-circle flex-center text-xl flex-shrink-0" style="width: 45px; height: 45px;">
                                                <img src="{{ asset('assets/client') }}/images/thumbs/{{ Auth::user()->avatar }}" alt="{{ Auth::user()->username }}" class="w-100 rounded-circle">
                                            </span>
                                            <div class="flex-column d-flex">
                                                <span class="text-xs text-neutral-600">
                                                    <span class="fw-medium">{{ Auth::user()->username }}</span> 
                                                </span>
                                                <span class="text-md text-neutral-600">
                                                    <span class="fw-semibold">{{ Auth::user()->hoten }}</span> 
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    <ul class="max-h-540 overflow-y-auto scroll-sm">
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('tai-khoan') }}" class="{{ Route::is('tai-khoan') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} px-16 py-8 hover-bg-main-50 hover-text-main-600 rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-user"></i> Thông tin cá nhân</span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-bell-simple-ringing"></i> Thông báo <span class="badge bg-main-600 px-6 py-4">!</span></span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('don-hang-cua-toi') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('don-hang-cua-toi') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-notepad"></i> Đơn hàng của tôi </span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-map-pin-area"></i> Sổ địa chỉ</span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-chat-centered-dots"></i> Đánh giá sản phẩm</span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-6">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-heart"></i> Sản phẩm yêu thích <span class="badge bg-success-600 px-6 py-4">6</span></span> 
                                                </a>
                                            </div>        
                                        </li>
                                        <li class="mb-20">
                                            <div class="">
                                                <a href="{{ route('trang-chu') }}" class="px-16 py-8 hover-bg-main-50 hover-text-main-600 {{ Route::is('trang-chu') ? 'border border-main-600 text-main-600' : 'text-neutral-600' }} rounded-8 flex-between gap-12 mb-0" style="justify-content: start;">
                                                    <span class="fw-medium text-md flex-align gap-12"><i class="ph-bold ph-headset"></i> Hỗ trợ khách hàng</span> 
                                                </a>
                                            </div>        
                                        </li>
                                    </ul>
                                </div>
                                
                                
                                <form action="{{ route('dang-xuat') }}" method="post" class="shop-sidebar__box rounded-8 flex-align justify-content-between mb-32">
                                    @csrf
                                    <button title="Đăng xuất" type="submit" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-border-main-600 hover-text-white rounded-8 px-32 py-12 w-100 flex-center gap-8">
                                       <i class="ph-bold ph-sign-out"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Sidebar End -->

                        <!-- Content Start -->
                        <div class="col-lg-9">
                            <!-- Top Start -->
                            <div class="flex-between gap-16 flex-wrap mb-20 ">
                                <h6 class="mb-0 text-gray-900">Thông tin cá nhân</h6>
                                <div class="position-relative flex-align gap-16 flex-wrap">
                                    <button type="button" class="w-44 h-44 d-lg-none d-flex flex-center border border-gray-100 rounded-6 text-2xl sidebar-btn">
                                        <i class="ph-bold ph-folder-user"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Top End -->

                            <div class="row g-12">
                               <div class="border border-gray-100 rounded-8 p-16">
                                    @if(session('success'))
                                        <span class="border-dashed border-success-500 bg-success-300 text-success-900 rounded-8 px-8 py-4">{{ session('success') }}</span>
                                    @endif
                                    <form class="row" action="{{ route('cap-nhat-tai-khoan') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-xl-8 py-10">
                                            <h6 class="mb-20 fw-semibold text-gray-700 text-md">Thông tin cá nhân</h6>
                                            <div class="row mb-20">
                                                <div class="col-xl-3 flex-align flex-center flex-wrap gap-2">
                                                    <div class="avatar-container mx-16 mt-10 mb-0">
                                                        <img id="avatarImage" src="{{ asset('assets/client') }}/images/thumbs/{{ Auth::user()->avatar }}" alt="Avatar" class="avatar-img">
                                                        <input type="file" id="fileInput" name="avatar" style="display: none;">
                                                    </div>
                                                    <label class="form-label text-xs text-gray-500 fw-medium" for="fileInput" style="cursor: pointer;"><i class="ph-bold ph-pencil-simple"></i> đổi ảnh</label>
                                                    @error('avatar')
                                                            <div class="text-main-600 fw-normal">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>
                                                <div class="col-xl-9">
                                                    <div class="form-group">
                                                        <label class="form-label text-md text-gray-900" for="">Tên người dùng:</label>
                                                        <input type="text" id="username" placeholder="" value="{{ Auth::user()->username }}" class="form-control p-10 bg-gray-50 disabled" readonly>
                                                        @error('username')
                                                            <div class="text-main-600 fw-normal">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mt-10">
                                                        <label class="form-label text-md text-gray-900" for="">Họ và tên:</label>
                                                        <input type="text" id="hoten" name="hoten" placeholder="Nhập họ và tên của bạn..." value="{{ old('hoten',Auth::user()->hoten) }}" class="form-control p-10" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-20">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label text-md text-gray-900" for="gioitinh">Giới tính:</label>
                                                        <select name="gioitinh" id="gioitinh" class="form-control p-10" required>
                                                            <option value="Nam" 
                                                                @if (Auth::check() && Auth::user()->gioitinh == 'Nam') 
                                                                    selected 
                                                                @endif
                                                            >
                                                                Nam
                                                            </option>
                                                            
                                                            <option value="Nữ" 
                                                                @if (Auth::check() && Auth::user()->gioitinh == 'Nữ') 
                                                                    selected 
                                                                @endif
                                                            >
                                                                Nữ
                                                            </option>
                                                            
                                                        </select>
                                                        @error('gioitinh')
                                                            <div class="text-main-600 fw-normal">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label class="form-label text-md text-gray-900" for="ngaysinh">Ngày sinh:</label>
                                                        <input type="date" id="ngaysinh" name="ngaysinh" value="{{ old('ngaysinh',Auth::user()->ngaysinh) }}" class="form-control p-10" required>
                                                        @error('ngaysinh')
                                                            <div class="text-main-600 fw-normal">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <button title="Lưu thông tin cá nhân" type="submit" class="btn bg-main-600 text-white hover-bg-main-300 hover-text-main-600 rounded-8 px-32 py-12 w-100 flex-center flex-align gap-8">
                                                <i class="ph-bold ph-floppy-disk"></i> Lưu thông tin
                                            </button>
                                        </div>
                                        <div class="col-xl-4 border-start border-gray-200 py-10">
                                            <h6 class="mb-20 fw-semibold text-gray-700 text-md">Thông tin liên hệ</h6>
                                            <div class="form-group mb-10">
                                                <div class="flex-align flex-between">
                                                    <label class="form-label text-md text-gray-900 flex-align gap-8" for="sodienthoai"><i class="ph-bold ph-phone"></i> Số điện thoại:</label>
                                                    <span id="suasodienthoai" class="text-xs text-primary-700 flex-align gap-4 fw-normal" style="cursor:pointer;"><i class="ph-bold ph-pencil-simple"></i> Chỉnh sửa</span>
                                                </div>
                                                <input type="text" id="sodienthoai" name="sodienthoai" value="{{ old('sodienthoai',Auth::user()->sodienthoai) }}" class="form-control p-10 bg-gray-50 disabled" required readonly>
                                                @error('sodienthoai')
                                                    <div class="text-main-600 fw-normal">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div class="flex-align flex-between">
                                                    <label class="form-label text-md text-gray-900 flex-align gap-8" for="email"><i class="ph-bold ph-envelope"></i> Email:</label>
                                                    <span id="suaemail" class="text-xs text-primary-700 flex-align gap-4 fw-normal" style="cursor:pointer;"><i class="ph-bold ph-pencil-simple"></i> Chỉnh sửa</span>
                                                </div>
                                                <input type="text" id="email" name="email" value="{{ old('email',Auth::user()->email) }}" class="form-control p-10 bg-gray-50 disabled" required readonly>
                                                @error('email')
                                                    <div class="text-main-600 fw-normal">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            
                                            <span class="mt-20 pt-20 text-gray-700 border-top border-gray-100 d-block"></span>

                                            <h6 class="mb-20 fw-semibold text-gray-700 text-md">Thông tin bảo mật</h6>
                                            <div class="form-group mb-10">
                                                <div class="flex-align flex-between">
                                                    <label class="form-label text-md text-gray-900 flex-align gap-8 m-0" for=""><i class="ph-bold ph-lock"></i> Đổi mật khẩu:</label>
                                                    <a href="#" class="text-sm text-primary-700 flex-align gap-4 fw-normal" style="cursor:pointer;"><i class="ph-bold ph-pencil-simple"></i> Chỉnh sửa</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarContainer = document.querySelector('.avatar-container');
            const fileInput = document.getElementById('fileInput');
            const avatarImage = document.getElementById('avatarImage');

            // **Bước 1: Kích hoạt Input File**
            // Lắng nghe sự kiện click vào toàn bộ khu vực avatar
            avatarContainer.addEventListener('click', function() {
                fileInput.click(); // Tự động click vào input file ẩn
            });

            // **Bước 2: Xem trước ảnh đã chọn (Hiệu ứng tức thì)**
            fileInput.addEventListener('change', function(event) {
                // Kiểm tra xem có file nào được chọn không
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();

                    // Đọc nội dung file
                    reader.onload = function(e) {
                        // Thay đổi thuộc tính 'src' của thẻ <img> để hiển thị ảnh mới
                        avatarImage.src = e.target.result;
                    };

                    // Bắt đầu đọc file ảnh đã chọn
                    reader.readAsDataURL(event.target.files[0]);
                    
                    // **Gợi ý quan trọng:**
                    // Tại đây, bạn có thể tự động gửi form (dùng Ajax)
                    // hoặc thông báo cho người dùng rằng ảnh đã sẵn sàng để lưu.
                    console.log("File đã được chọn: ", event.target.files[0].name);
                }
            });
        });
    </script>
    <script>
    // Lấy các phần tử DOM
    const phoneInput = document.getElementById('sodienthoai');
    const editButton = document.getElementById('suasodienthoai');

    const emailInput = document.getElementById('email');
    const editEmail = document.getElementById('suaemail');

    // --- LOGIC 1: Khi nhấn nút CHỈNH SỬA ---
    editButton.addEventListener('click', function() {
        // Chuyển sang chế độ chỉnh sửa
        phoneInput.removeAttribute('readonly');
        
        // Tùy chọn: Thay đổi kiểu dáng
        phoneInput.classList.remove('bg-gray-50');
        
        // Ẩn nút Chỉnh sửa
        editButton.style.display = 'none'; 
        
        // Đặt con trỏ chuột vào trường nhập liệu
        phoneInput.focus(); 
    });

    editEmail.addEventListener('click', function() {
        // Chuyển sang chế độ chỉnh sửa
        emailInput.removeAttribute('readonly');
        
        // Tùy chọn: Thay đổi kiểu dáng
        emailInput.classList.remove('bg-gray-50');
        
        // Ẩn nút Chỉnh sửa
        editEmail.style.display = 'none'; 
        
        // Đặt con trỏ chuột vào trường nhập liệu
        emailInput.focus(); 
    });

    // --- LOGIC 2: Khi rời khỏi trường nhập liệu (sự kiện BLUR) ---
    phoneInput.addEventListener('blur', function() {
        // Kiểm tra xem trường input có đang ở chế độ chỉnh sửa không
        // Nếu trường đó KHÔNG có thuộc tính 'readonly' (tức là đang chỉnh sửa)
        if (!phoneInput.hasAttribute('readonly')) {
            
            // Khóa lại trường nhập liệu (trở lại trạng thái chỉ đọc)
            phoneInput.setAttribute('readonly', 'readonly');
            
            // Hiện nút Chỉnh sửa
            editButton.style.display = 'inline-block';
            
            phoneInput.classList.add('bg-gray-50');
            
            // Gợi ý: Tại đây, bạn sẽ gọi một hàm AJAX để gửi dữ liệu đã thay đổi lên server
            // console.log('Dữ liệu mới đã được lưu (hoặc sẵn sàng để lưu): ' + phoneInput.value);
        }
    });

    emailInput.addEventListener('blur', function() {
        // Kiểm tra xem trường input có đang ở chế độ chỉnh sửa không
        // Nếu trường đó KHÔNG có thuộc tính 'readonly' (tức là đang chỉnh sửa)
        if (!emailInput.hasAttribute('readonly')) {
            
            // Khóa lại trường nhập liệu (trở lại trạng thái chỉ đọc)
            emailInput.setAttribute('readonly', 'readonly');
            
            // Hiện nút Chỉnh sửa
            editEmail.style.display = 'inline-block';
            
            emailInput.classList.add('bg-gray-50');
            
            // Gợi ý: Tại đây, bạn sẽ gọi một hàm AJAX để gửi dữ liệu đã thay đổi lên server
            // console.log('Dữ liệu mới đã được lưu (hoặc sẵn sàng để lưu): ' + phoneInput.value);
        }
    });
</script>
@endsection
