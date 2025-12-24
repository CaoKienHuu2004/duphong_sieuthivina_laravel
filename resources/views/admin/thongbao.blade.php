@extends('admin.layouts.app')

@section('title', 'Gửi thông báo hệ thống | Quản trị viên')

@section('content')
    <div class="page-wrapper">
        <form class="content" action="{{ route('quan-tri-vien.luu-thong-bao') }}" method="post">
            @csrf
            
            <div class="page-header">
                <div class="page-title">
                    <h4>Gửi thông báo thủ công</h4>
                    <h6>Gửi tin nhắn khuyến mãi, quà tặng hoặc bảo trì đến tất cả khách hàng</h6>
                </div>
                <div class="page-btn">
                    <button type="submit" class="btn btn-added">
                        <img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img" class="me-1">
                        Gửi thông báo ngay
                    </button>
                </div>
            </div>

            {{-- Hiển thị thông báo --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                {{-- CỘT CHÍNH --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                {{-- Tiêu đề --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Tiêu đề thông báo <span class="text-danger">*</span></label>
                                        <input type="text" name="tieude" class="form-control" 
                                               placeholder="Ví dụ: Siêu sale 12/12 - Giảm giá 50% toàn bộ yến sào..." 
                                               value="{{ old('tieude') }}" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Liên kết <span class="text-danger">*</span></label>
                                        <input type="text" name="lienket" class="form-control" 
                                               placeholder="Ví dụ: https://sieuthivina.shop" 
                                               value="{{ old('lienket') }}" required>
                                    </div>
                                </div>

                                {{-- Nội dung (CKEditor) --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nội dung chi tiết <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="noidung" id="noi_dung" style="height: 200px;">{{ old('noidung') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CỘT PHỤ --}}
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                {{-- Loại thông báo --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Loại thông báo <span class="text-danger">*</span></label>
                                        <select class="select text-black" name="loai" required>
                                            <option value="">-- Chọn loại --</option>
                                            <option value="Khuyến mãi" {{ old('loai') == 'Khuyến mãi' ? 'selected' : '' }}>🎁 Khuyến mãi / Sự kiện</option>
                                            <option value="Quà tặng" {{ old('loai') == 'Quà tặng' ? 'selected' : '' }}>🎀 Chương trình Quà tặng</option>
                                            <option value="Hệ thống" {{ old('loai') == 'Hệ thống' ? 'selected' : '' }}>📢 Thông báo Hệ thống / Bảo trì</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Đối tượng nhận (Mặc định All) --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Đối tượng nhận tin</label>
                                        <input type="text" class="form-control" value="Tất cả người dùng (Hoạt động)" disabled style="background-color: #e9ecef;">
                                        <small class="text-muted">Hệ thống sẽ gửi tin nhắn này đến tất cả tài khoản đang hoạt động.</small>
                                    </div>
                                </div>

                                {{-- Info Box --}}
                                <div class="col-12 mt-3">
                                    <div class="alert alert-warning">
                                        <i class="fa fa-info-circle me-1"></i> 
                                        Lưu ý: Hành động này sẽ tạo nhiều bản ghi dữ liệu tương ứng với số lượng khách hàng. Vui lòng không spam.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        // Kích hoạt CKEditor
        if(document.querySelector('#noi_dung')) {
            ClassicEditor.create(document.querySelector('#noi_dung'))
                .catch(error => { console.error(error); });
        }
    </script>
@endsection