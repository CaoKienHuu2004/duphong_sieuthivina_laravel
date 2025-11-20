@extends('admin.layouts.app')

@section('title')
    Sửa "{{ $danhmuc->ten }}" | Danh mục | Quản trị hệ thống Siêu Thị Vina
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sửa danh mục "{{ $danhmuc->ten }}"</h4>
                    <h6>Chỉnh sửa thông tin danh mục sản phẩm</h6>
                </div>
            </div>

            <form class="row" action="{{ route('quan-tri-vien.cap-nhat-danh-muc', $danhmuc->slug) }}" method="POST">
            @csrf
                <div class="col-lg-8 col-sm-8 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Tên danh mục <span class="text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Bắt buộc">*</span></label>
                                        <input type="text" name="ten" class="form-control"
                                            value="{{ old('ten_danh_muc', $danhmuc->ten) }}" required />
                                        @error('ten')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Slug (đường dẫn) <span class="text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Bắt buộc (vd: bach-hoa)">*</span></label>
                                        <input type="text" name="slug" class="form-control"
                                            value="{{ old('slug', $danhmuc->slug) }}" required />
                                        @error('slug')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select class="form-select" name="trangthai">
                                            <option value="0" {{ old('trangthai', $danhmuc->trangthai) == 'Hiển thị' ? 'selected' : '' }}>Hiển
                                                thị</option>
                                            <option value="1" {{ old('trangthai', $danhmuc->trangthai) == 'Tạm ẩn' ? 'selected' : '' }}>Tạm ẩn
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-submit" title="Cập nhật">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="form-label">Ảnh đại diện danh mục <span class="text-danger"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Bắt buộc">*</span></label>

                                        <div class="image-upload-container">

                                            <label for="avatarInput" style="display: block; width: 100%; cursor: pointer;"
                                                class="d-flex align-items-center flex-column">

                                                <img id="previewImage"
                                                    src="{{ isset($danhmuc) && $danhmuc->logo ? asset('assets/client/images/categories/' . $danhmuc->logo) : asset('assets/admin/img/default_image.png') }}"
                                                    alt="Preview" style="width: 70%; object-fit: cover;">
                                                {{-- <small class="text-muted">{{ $danhmuc->logo }}</small> --}}
                                            </label>

                                            <input type="file" name="hinh_anh" id="avatarInput" class="d-none" accept="image/*"
                                                onchange="previewFile(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewFile(input) {
            var preview = document.getElementById('previewImage');
            var file = input.files[0];

            // Kiểm tra xem người dùng có chọn file hay không
            if (file) {
                var reader = new FileReader();

                // Khi file đã được đọc xong thì gán src mới cho thẻ img
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                // Đọc file dưới dạng URL data
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection