@extends('admin.layouts.app')

@section('title', 'Tạo chương trình quà tặng | Quản trị hệ thống')

@section('content')
<div class="page-wrapper">
    <form class="content" action="{{ route('quan-tri-vien.luu-qua-tang') }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- Header --}}
        <div class="page-header">
            <div class="page-title">
                <h4>Thêm chương trình quà tặng</h4>
                <h6>Tạo mới sự kiện khuyến mãi mua hàng tặng quà</h6>
            </div>
            <div class="page-btn">
                <button type="submit" class="btn btn-added">
                    <img src="{{ asset('assets/admin') }}/img/icons/plus.svg" alt="img" class="me-1">
                    Lưu chương trình
                </button>
            </div>
        </div>

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

        {{-- Hiển thị lỗi --}}
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Vui lòng kiểm tra lại:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        <div class="row">
            {{-- CỘT TRÁI (Lớn) --}}
            <div class="col-lg-8">
                {{-- 1. Thông tin chung --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tên chương trình quà tặng <span class="text-danger">*</span></label>
                                    <input type="text" name="ten" class="form-control" placeholder="Ví dụ: Mua 2 Yến sào Nest100 tặng 1..." value="{{ old('ten') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Ngày bắt đầu <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="ngaybatdau" class="form-control" value="{{ old('ngaybatdau') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Ngày kết thúc <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="ngayketthuc" class="form-control" value="{{ old('ngayketthuc') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Điều kiện số lượng <span class="text-danger">*</span></label>
                                    <input type="number" name="dieukiensoluong" class="form-control" value="{{ old('dieukiensoluong') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Giá trị tối thiểu <span class="text-danger">*</span></label>
                                    <input type="number" name="dieukiengiatri" class="form-control" value="{{ old('dieukiengiatri') }}" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Mô tả chi tiết</label>
                                    <textarea class="form-control" id="mo_ta" name="mota">{{ old('mota') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Sản phẩm tham gia (Điều kiện Mua) --}}
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #008080;">
                        <h5 class="text-white mb-0">1. Sản phẩm tham gia (Điều kiện Mua)</h5>
                        <button type="button" class="btn btn-sm btn-light fw-bold" onclick="addThamGia()" style="color: #008080;">
                            <i class="fa fa-plus"></i> Thêm sản phẩm
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 70%">Chọn sản phẩm mua</th>
                                        <th style="width: 10%" class="text-center">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-thamgia">
                                    {{-- Dùng JS để thêm dòng vào đây --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 text-center" id="empty-thamgia">
                            <span class="text-muted">Chưa có sản phẩm điều kiện nào. Hãy bấm "Thêm sản phẩm"</span>
                        </div>
                    </div>
                </div>

                {{-- 3. Sản phẩm được tặng (Quà) --}}
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #008080;">
                        <h5 class="text-white mb-0">2. Sản phẩm được tặng (Quà)</h5>
                        <button type="button" class="btn btn-sm btn-light fw-bold" onclick="addDuocTang()" style="color: #008080;">
                            <i class="fa fa-plus"></i> Thêm quà tặng
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 70%">Chọn quà tặng</th>
                                        <th style="width: 20%">Số lượng tặng</th>
                                        <th style="width: 10%" class="text-center">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-duoctang">
                                    {{-- Dùng JS để thêm dòng vào đây --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 text-center" id="empty-duoctang">
                            <span class="text-muted">Chưa có quà tặng nào. Hãy bấm "Thêm quà tặng"</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI (Nhỏ) --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- Thương hiệu (Từ yêu cầu thêm id_thuonghieu vào bảng) --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Thương hiệu tài trợ</label>
                                    <select class="select" name="id_thuonghieu">
                                        <option value="">-- Chọn thương hiệu tài trợ --</option>
                                        {{-- Giả sử Controller truyền $thuonghieus sang --}}
                                        @if(isset($thuonghieus))
                                            @foreach($thuonghieus as $th)
                                                <option value="{{ $th->id }}" {{ old('id_thuonghieu') == $th->id ? 'selected' : '' }}>
                                                    {{ $th->ten }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            {{-- Trạng thái --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="select" name="trangthai">
                                        <option value="Hiển thị">Hiển thị</option>
                                        <option value="Tạm ẩn">Tạm ẩn</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Hình ảnh (Đơn 1 ảnh) --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Hình ảnh banner sự kiện</label>
                                    <div class="image-upload text-center">
                                        <input type="file" name="hinhanh" id="imgInp" accept="image/*">
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/admin') }}/img/icons/upload.svg" alt="img">
                                            <h4>Kéo thả hoặc click để upload</h4>
                                        </div>
                                    </div>
                                    {{-- Preview ảnh đơn --}}
                                    <div class="mt-3 text-center" style="display: none;" id="preview-box">
                                        <img id="preview-img" src="#" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #ddd;">
                                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeImage()">Xóa ảnh</button>
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
{{-- CKEditor --}}
<script>
    if(document.querySelector('#mota')) {
        ClassicEditor.create(document.querySelector('#mota')).catch(error => { console.error(error); });
    }
</script>

{{-- Script xử lý ảnh đơn --}}
<script>
    const imgInp = document.getElementById('imgInp');
    const previewBox = document.getElementById('preview-box');
    const previewImg = document.getElementById('preview-img');

    imgInp.onchange = evt => {
        const [file] = imgInp.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewBox.style.display = 'block';
            $('.image-uploads').hide(); // Ẩn vùng upload cũ
        }
    }

    function removeImage() {
        imgInp.value = "";
        previewBox.style.display = 'none';
        $('.image-uploads').show();
    }
</script>

{{-- Script xử lý thêm dòng sản phẩm (Giống biến thể) --}}
<script>
    let indexThamGia = 0;
    let indexDuocTang = 0;

    // Chuẩn bị danh sách options biến thể từ PHP để dùng trong JS
    // Lưu ý: Controller cần truyền biến $bienthes
    const productOptions = `
        <option value="">-- Chọn biến thể sản phẩm --</option>
        @if(isset($bienthes))
            @foreach($bienthes as $bt)
                <option value="{{ $bt->id }}">
                    {{ $bt->sanpham->ten ?? 'SP Lỗi' }} - {{ $bt->loaibienthe->ten ?? '' }} (Tồn: {{ $bt->luottang }})
                </option>
            @endforeach
        @endif
    `;

    // --- HÀM 1: THÊM SẢN PHẨM THAM GIA (MUA) ---
    function addThamGia() {
        $('#empty-thamgia').hide();
        
        const html = `
            <tr id="row-thamgia-${indexThamGia}">
                <td>
                    <select name="sp_thamgia[${indexThamGia}][id_bienthe]" class="form-control select-search" required>
                        ${productOptions}
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn p-0 text-danger" onclick="removeRow('row-thamgia-${indexThamGia}', 'empty-thamgia', 'tbody-thamgia')">
                        <img src="{{ asset('assets/admin') }}/img/icons/delete.svg" alt="img">
                    </button>
                </td>
            </tr>
        `;
        
        $('#tbody-thamgia').append(html);
        
        // Kích hoạt lại Select2 cho dòng mới thêm (nếu template dùng select2)
        if ($('.select-search').length > 0) {
            $('.select-search').select2();
        }
        
        indexThamGia++;
    }

    // --- HÀM 2: THÊM SẢN PHẨM ĐƯỢC TẶNG (QUÀ) ---
    function addDuocTang() {
        $('#empty-duoctang').hide();
        
        const html = `
            <tr id="row-duoctang-${indexDuocTang}">
                <td>
                    <select name="sp_duoctang[${indexDuocTang}][id_bienthe]" class="form-control select-search" required>
                        ${productOptions}
                    </select>
                </td>
                <td>
                    <input type="number" name="sp_duoctang[${indexDuocTang}][soluong]" class="form-control text-center" value="1" min="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn p-0 text-danger" onclick="removeRow('row-duoctang-${indexDuocTang}', 'empty-duoctang', 'tbody-duoctang')">
                        <img src="{{ asset('assets/admin') }}/img/icons/delete.svg" alt="img">
                    </button>
                </td>
            </tr>
        `;
        
        $('#tbody-duoctang').append(html);
        
        if ($('.select-search').length > 0) {
            $('.select-search').select2();
        }

        indexDuocTang++;
    }

    // --- HÀM XÓA DÒNG ---
    function removeRow(rowId, emptyMsgId, tbodyId) {
        $('#' + rowId).remove();
        
        // Nếu xóa hết thì hiện lại thông báo trống
        if ($('#' + tbodyId + ' tr').length === 0) {
            $('#' + emptyMsgId).show();
        }
    }
</script>
<script>
    if(document.querySelector('#mo_ta')) {
         ClassicEditor.create(document.querySelector('#mo_ta'), editorConfig);
    }
  </script>
@endsection