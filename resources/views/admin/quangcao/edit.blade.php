@extends('admin.layouts.app')

@section('title', 'Cập nhật banner quảng cáo | Quản trị hệ thống')

@section('content')
    <div class="page-wrapper">
        <form class="content" action="{{ route('quan-tri-vien.cap-nhat-banner-quang-cao', $banner->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Quan trọng cho hàm update --}}
            
            <div class="page-header">
                <div class="page-title">
                    <h4>Cập nhật banner quảng cáo</h4>
                    <h6>Chỉnh sửa thông tin banner #{{ $banner->id }}</h6>
                </div>
                <div class="page-btn">
                    <button type="submit" class="btn btn-added">
                        <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" class="me-1">
                        Lưu thay đổi
                    </button>
                </div>
            </div>

            {{-- Hiển thị thông báo lỗi/thành công (Giữ nguyên) --}}
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
                                        <label>Liên kết banner <span class="text-danger">*</span></label>
                                        <input class="text-black" type="text" name="lienket"
                                            placeholder="Nhập link banner quảng cáo..." 
                                            value="{{ old('lienket', $banner->lienket) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Vị trí banner <span class="text-danger">*</span></label>
                                        <select class="select text-black" name="vitri">
                                            <option>-- Chọn vị trí banner --</option>
                                            @php
                                                $positions = [
                                                    'home_banner_slider' => 'Banner trên slider',
                                                    'home_banner_event_1' => 'Banner sự kiện 4 ô (số 1)',
                                                    'home_banner_event_2' => 'Banner sự kiện 4 ô (số 2)',
                                                    'home_banner_event_3' => 'Banner sự kiện 4 ô (số 3)',
                                                    'home_banner_event_4' => 'Banner sự kiện 4 ô (số 4)',
                                                    'home_banner_promotion_1' => 'Banner khuyến mãi bên trái',
                                                    'home_banner_promotion_2' => 'Banner khuyến mãi ở giữa',
                                                    'home_banner_promotion_3' => 'Banner khuyến mãi phải',
                                                    'home_banner_ads' => 'Banner quảng cáo',
                                                    'home_banner_product' => 'Banner giới thiệu sản phẩm'
                                                ];
                                            @endphp
                                            @foreach($positions as $key => $label)
                                                <option value="{{ $key }}" {{ old('vitri', $banner->vitri) == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Mô tả banner quảng cáo <span class="text-danger">*</span></label>
                                        {{-- ID cho CKEditor --}}
                                        <textarea class="form-control" name="mota" id="mo_ta" style="height: 200px;">{{ old('mota', $banner->mota) }}</textarea>
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
                                        <label>Trạng thái banner <span class="text-danger">*</span></label>
                                        <select class="select text-black" name="trangthai">
                                            <option value="Hiển thị" {{ old('trangthai', $banner->trangthai) == 'Hiển thị' ? 'selected' : '' }}>Hiển thị</option>
                                            <option value="Tạm ẩn" {{ old('trangthai', $banner->trangthai) == 'Tạm ẩn' ? 'selected' : '' }}>Tạm ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Hình ảnh banner (Thay đổi)</label>

                                        {{-- 1. HIỂN THỊ ẢNH CŨ --}}
                                        @if($banner->hinhanh)
                                        <div class="mb-3 p-2 border rounded bg-light text-center">
                                            <p class="text-muted mb-1"><small>Ảnh hiện tại:</small></p>
                                            <img src="{{ asset('assets/client/images/bg/' . $banner->hinhanh) }}" 
                                                 alt="Ảnh hiện tại" 
                                                 style="max-width: 100%; max-height: 150px; border-radius: 5px;">
                                        </div>
                                        @endif

                                        {{-- 2. UPLOAD ẢNH MỚI --}}
                                        <div class="image-upload" id="drop-zone">
                                            <input type="file" id="imageInput" name="images" accept="image/*" />
                                            <div class="image-uploads">
                                                <img src="{{asset('assets/admin')}}/img/icons/upload.svg" alt="img" />
                                                <h4>Kéo thả hoặc click để thay đổi ảnh</h4>
                                            </div>
                                        </div>

                                        <div class="row mt-3" id="image-preview-container">
                                        </div>
                                        <small class="text-danger"> * Chỉ upload nếu muốn thay đổi ảnh cũ</small>

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
    {{-- GIỮ NGUYÊN CSS VÀ JS TỪ TRANG CREATE VÌ NÓ DÙNG CHUNG CHO UPLOAD ẢNH MỚI --}}
    <style>
        #image-preview-container { display: flex; flex-wrap: wrap; gap: 10px; }
        .preview-image-item { position: relative; width: 120px; height: 120px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; cursor: grab; background: #fff; transition: transform 0.2s; }
        .preview-image-item.dragging { opacity: 0.5; border: 2px dashed #ff9f43; }
        .preview-image-item img { width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
        .btn-remove-image { position: absolute; top: 5px; right: 5px; background: rgba(255, 0, 0, 0.7); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; z-index: 10; }
        .btn-remove-image:hover { background: red; }
    </style>
    
    <script>
        // Init CKEditor cho nội dung cũ
        if(document.querySelector('#mo_ta')) {
            ClassicEditor.create(document.querySelector('#mo_ta')).catch(error => { console.error(error); });
        }
    </script>

    <script>
        $(document).ready(function () {
            // JS xử lý upload ảnh mới (Giống hệt trang Create)
            let dt = new DataTransfer();
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('image-preview-container');

            $('#imageInput').on('change', function (e) {
                // Clear cũ nếu chỉ cho phép 1 ảnh
                dt = new DataTransfer(); 
                
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
                            <div class="preview-image-item" draggable="true" data-index="${index}">
                                <img src="${e.target.result}" alt="Image">
                                <button type="button" class="btn-remove-image" onclick="removeImage(${index})">&times;</button>
                            </div>
                        `;
                        $(previewContainer).append(html);
                    }
                    reader.readAsDataURL(file);
                });
            }

            window.updateInputFiles = function () { imageInput.files = dt.files; }

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