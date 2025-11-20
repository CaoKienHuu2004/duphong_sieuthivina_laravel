@extends('admin.layouts.app')

@section('title', 'Tạo danh mục | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Add Category</h4>
                    <h6>Create new product Category</h6>
                </div>
            </div>

            <form class="row" action="{{ route('quan-tri-vien.luu-danh-muc') }}" method="POST">
                <div class="col-lg-8 col-sm-8 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Tên danh mục <span class="text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Bắt buộc">*</span></label>
                                        <input type="text" name="ten" class="form-control" />
                                        @error('ten')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Slug (đường dẫn) <span class="text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Bắt buộc (vd: bach-hoa)">*</span></label>
                                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                                            required />
                                        @error('slug')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select class="form-select" name="trangthai">
                                            <option value="0" {{ old('trangthai') == 0 ? 'selected' : '' }}>Hiển thị</option>
                                            <option value="1" {{ old('trangthai') == 1 ? 'selected' : '' }}>Ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-submit" title="Tạo danh mục">Tạo danh mục</button>
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
                                        <label class="form-label">Ảnh đại diện danh mục <span class="text-danger" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Bắt buộc">*</span></label>
                                        
                                        <div class="image-upload-container">
                                            
                                            <label for="avatarInput" style="display: block; width: 100%; cursor: pointer;" class="d-flex justify-content-center">
                                                
                                                <img id="previewImage" 
                                                    src="{{ isset($danhmuc) && $danhmuc->hinh_anh ? asset('assets/client/images/categories/'.$danhmuc->hinh_anh) : asset('assets/admin/img/default_image.png') }}" 
                                                    alt="Preview" 
                                                    style="width: 80%; object-fit: cover;">
                                            </label>

                                            <input type="file" 
                                                name="hinh_anh" 
                                                id="avatarInput" 
                                                class="d-none" 
                                                accept="image/*" 
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