@extends('admin.layouts.app')

@section('title', 'Sửa danh mục | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        {{-- 1. Action trỏ về route update, truyền ID vào --}}
        <form class="content" action="{{ route('quan-tri-vien.cap-nhat-danh-muc', $danhmuc->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- 2. Bắt buộc có dòng này để Laravel hiểu là cập nhật --}}

            <div class="page-header">
                <div class="page-title">
                    <h4>Sửa danh mục sản phẩm</h4>
                    <h6>Cập nhật thông tin danh mục sản phẩm</h6>
                </div>
                <div class="page-btn">
                    <button type="submit" class="btn btn-added">
                        <img src="{{ asset('assets/admin') }}/img/icons/plus.svg" alt="img" class="me-1">
                        Lưu thay đổi
                    </button>
                </div>
            </div>

            {{-- Hiển thị thông báo (Giống trang create) --}}
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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Tên danh mục <span class="text-danger">*</span></label>
                                        {{-- 3. Đổ dữ liệu tên cũ: $danhmuc->ten --}}
                                        <input class="text-black" type="text" name="tendm"
                                            placeholder="Nhập tên danh mục sản phẩm..." id="slug-source"
                                            onkeyup="ChangeToSlug();" value="{{ old('tendm', $danhmuc->ten) }}" />
                                        <label>Đường dẫn: <span class="fst-italic form-text text-muted" id="slug-text">{{ $danhmuc->slug }}</span></label>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Sắp xếp danh mục <span class="text-danger">*</span></label>
                                                {{-- 5. Đổ dữ liệu sắp xếp --}}
                                                <input class="text-black form-control" type="number" name="sapxep" 
                                                    value="{{ old('sapxep', $danhmuc->sapxep) }}" placeholder="sắp xếp số thứ tự" />
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Chọn danh mục cha (nếu có)</label>
                                        <select class="select" name="parent">
                                            <option value="Không có" {{ (old('parent', $danhmuc->parent) == null) ? 'selected' : '' }}>Không có</option>
                                            
                                            {{-- Lưu ý: Biến này là danh sách tất cả danh mục để chọn --}}
                                            @if(isset($listDanhmuc))
                                                @foreach ($listDanhmuc as $dm)
                                                    {{-- Không hiển thị chính nó trong danh sách cha (tránh lỗi vòng lặp) --}}
                                                    @if($dm->id != $danhmuc->id)
                                                        <option value="{{ $dm->id }}" {{ (old('parent', $danhmuc->parent) == $dm->id) ? 'selected' : '' }}>
                                                            {{ $dm->ten }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái danh mục <span class="text-danger">*</span></label>
                                        <select class="select text-black" name="trangthai">
                                            <option value="Hiển thị" {{ (old('trangthai', $danhmuc->trangthai) == 'Hiển thị') ? 'selected' : '' }}>Hiển thị</option>
                                            <option value="Tạm ẩn" {{ (old('trangthai', $danhmuc->trangthai) == 'Tạm ẩn') ? 'selected' : '' }}>Tạm ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Hình ảnh danh mục <span class="text-danger">*</span></label>
                                        <div class="image-upload" id="drop-zone">
                                            <input type="file" id="imageInput" name="images" accept="image/*" />
                                            <div class="image-uploads">
                                                <img src="{{ asset('assets/admin') }}/img/icons/upload.svg" alt="img" />
                                                <h4>Kéo và thả file tại đây hoặc click để chọn</h4>
                                            </div>
                                        </div>
                                        <div class="row mt-3" id="image-preview-container">
                                            {{-- Ảnh cũ sẽ được JS load vào đây --}}
                                        </div>
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
    <style>
        #image-preview-container { display: flex; flex-wrap: wrap; gap: 10px; }
        .preview-image-item { position: relative; width: 120px; height: 120px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: #fff; }
        .preview-image-item img { width: 100%; height: 100%; object-fit: cover; }
        .btn-remove-image { position: absolute; top: 5px; right: 5px; background: rgba(255, 0, 0, 0.7); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; }
        .btn-remove-image:hover { background: red; }
    </style>

    <script>
        if(document.querySelector('#mo_ta')) {
            ClassicEditor.create(document.querySelector('#mo_ta'), editorConfig).catch(error => { console.error(error); });
        }
    </script>

    <script>
        function ChangeToSlug() {
            let title, slug;
            title = document.getElementById("slug-source").value;
            slug = title.toLowerCase();
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            document.getElementById('slug-text').innerText = slug === "" ? "..." : slug;
        }
    </script>

    <script>
        $(document).ready(function () {
            let dt = new DataTransfer();
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('image-preview-container');

            // 6. [QUAN TRỌNG] Logic hiển thị ảnh cũ
            // Lấy tên ảnh từ PHP truyền sang
            const oldImageName = "{{ $danhmuc->logo }}"; 
            // Đường dẫn thư mục ảnh (Sửa lại path nếu bạn lưu chỗ khác)
            const imagePath = "{{ asset('assets/client/images/categories') }}/"; 

            if (oldImageName && oldImageName !== 'danhmuc.jpg') {
                const imageUrl = imagePath + oldImageName;
                
                // Dùng fetch để lấy ảnh về và giả lập như người dùng vừa chọn file
                fetch(imageUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        // Tạo file giả lập
                        const file = new File([blob], oldImageName, { type: blob.type });
                        dt.items.add(file);
                        
                        // Cập nhật input và view
                        updateInputFiles();
                        renderPreview();
                    })
                    .catch(err => console.log('Không load được ảnh cũ hoặc ảnh không tồn tại'));
            }

            $('#imageInput').on('change', function (e) {
                dt = new DataTransfer(); // Reset khi chọn ảnh mới
                for (let i = 0; i < this.files.length; i++) {
                    dt.items.add(this.files[i]);
                }
                updateInputFiles();
                renderPreview();
            });

            function renderPreview() {
                previewContainer.innerHTML = '';
                Array.from(dt.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const html = `
                            <div class="preview-image-item" data-index="${index}">
                                <img src="${e.target.result}" alt="Image">
                                <button type="button" class="btn-remove-image" onclick="removeImage(${index})">&times;</button>
                            </div>
                        `;
                        $(previewContainer).append(html);
                    }
                    reader.readAsDataURL(file);
                });
            }

            window.updateInputFiles = function () {
                imageInput.files = dt.files;
            }

            window.removeImage = function (index) {
                const newDt = new DataTransfer();
                Array.from(dt.files).forEach((file, i) => {
                    if (i !== index) newDt.items.add(file);
                });
                dt = newDt;
                updateInputFiles();
                renderPreview();
            }
        });
    </script>
@endsection