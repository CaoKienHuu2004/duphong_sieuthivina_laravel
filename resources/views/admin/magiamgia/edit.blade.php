@extends('admin.layouts.app')

@section('title', 'Tạo mã giảm giá | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <form class="content" action="{{ route('quan-tri-vien.cap-nhat-ma-giam-gia',$coupon->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="page-header">
                <div class="page-title">
                    <h4>Sửa mã giảm giá</h4>
                    <h6>Sửa thông tin mã giảm giá của bạn vào hệ thống</h6>
                </div>
                <div class="page-btn">
                    <button type="submit" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg"
                            alt="img" class="me-1">Lưu mã giảm giá</button>
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
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Mã giảm giá <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <input class="text-black" type="text" name="magiamgia"
                                            placeholder="Nhập mã giảm giá..." value="{{ old('magiamgiam', $coupon->magiamgia) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Điều kiện tối thiểu <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <input class="text-black form-control" type="number" name="dieukien"
                                            placeholder="Nhập diều kiện giảm giá..." value="{{ old('dieukien',$coupon->dieukien) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Giá trị giảm giá <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <input class="text-black form-control" type="number" name="giatri"
                                            placeholder="Nhập giá trị giảm giá..." value="{{ old('giatri',$coupon->giatri) }}"/>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Mô tả mã giảm giá <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <textarea class="form-control" name="mota"
                                            style="height: 200px;">{{ old('mota',$coupon->mota) }}</textarea>
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
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <input class="text-black form-control" type="date" name="ngaybatdau"
                                            placeholder="Ngày bắt đầu..." value="{{ old('ngaybatdau',$coupon->ngaybatdau) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Ngày kết thúc <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <input class="text-black form-control" type="date" name="ngayketthuc"
                                            placeholder="Ngày ketthuc..." value="{{ old('ngayketthuc',$coupon->ngayketthuc) }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái mã giảm giá <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <select class="select text-black" name="trangthai">
                                            <option value="Hoạt động" @if($coupon->trangthai == 'Hoạt động') selected @endif>Hoạt động</option>
                                            <option value="Tạm khóa" @if($coupon->trangthai == 'Tạm khóa') selected @endif>Tạm khóa</option>
                                        </select>
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
        /* Container chứa các ảnh preview */
        #image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Khối bao quanh mỗi ảnh */
        .preview-image-item {
            position: relative;
            width: 120px;
            height: 120px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            cursor: grab;
            /* Con trỏ hình bàn tay */
            background: #fff;
            transition: transform 0.2s;
        }

        /* Hiệu ứng khi đang được kéo */
        .preview-image-item.dragging {
            opacity: 0.5;
            border: 2px dashed #ff9f43;
        }

        /* Hình ảnh bên trong */
        .preview-image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
            /* Tránh xung đột sự kiện kéo chuột */
        }

        /* Nút xóa ảnh */
        .btn-remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            z-index: 10;
        }

        .btn-remove-image:hover {
            background: red;
        }
    </style>
    <script>
        /**
       * This configuration was generated using the CKEditor 5 Builder. You can modify it anytime using this link:
       * https://ckeditor.com/ckeditor-5/builder/?redirect=portal#installation/NoNgNARATAdA7DKFIhATgIwBY0gKwZxwAccaZW6xIWeeUAzFgAzEFZT4jIQBuAlsmZhgGMMOFjJAXUhYAZgEM089BGlA
       */

        ClassicEditor.create(document.querySelector('#mo_ta'), editorConfig);

    </script>
    <script>
        $(document).ready(function () {

            // === 1. CẤU HÌNH SELECT2 CHUNG ===
            // Khai báo biến config để dùng lại, tránh lặp code
            const select2Config = {
                tags: true, // Cho phép nhập text mới nếu không có trong danh sách
                placeholder: "Chọn hoặc nhập tên loại biến thể",
                width: '100%' // Fix lỗi hiển thị bị co nhỏ trong table
            };

            // [QUAN TRỌNG] Khởi tạo Select2 cho các phần tử ĐANG CÓ SẴN khi load trang
            $('.loai_bienthe').select2(select2Config);


            // === 2. CÁC HÀM HỖ TRỢ ===
            const tableBody = $('.table tbody');

            // Hàm cập nhật trạng thái nút xóa và index của name input
            function updateVariantState() {
                const rows = tableBody.find('tr');

                // Xử lý nút xóa: Nếu chỉ còn 1 dòng thì ẩn nút xóa đi
                if (rows.length === 1) {
                    rows.find('.btn-delete-variant').prop('disabled', true).css('opacity', '0.5');
                } else {
                    rows.find('.btn-delete-variant').prop('disabled', false).css('opacity', '1');
                }

                // Cập nhật lại name cho input để Laravel nhận mảng đúng: bienthe[0], bienthe[1]...
                rows.each(function (index) {
                    const row = $(this);
                    row.find('[name*="bienthe"]').each(function () {
                        const name = $(this).attr('name');
                        // Regex thay thế số ở giữa ngoặc vuông đầu tiên
                        const newName = name.replace(/bienthe\[\d+\]/, `bienthe[${index}]`);
                        $(this).attr('name', newName);
                    });
                });
            }

            // Chạy hàm update state lần đầu
            updateVariantState();


            // === 3. XỬ LÝ SỰ KIỆN Sửa BIẾN THỂ ===
            $('.btn-add-variant').click(function () {
                // Lấy dòng đầu tiên để clone
                const firstRow = tableBody.find('tr:first');

                // Clone dòng (nhân bản)
                const newRow = firstRow.clone();

                // --- Reset dữ liệu trong dòng mới (ĐÃ SỬA) ---
                newRow.find('input[type="text"]').val(''); // Xóa giá bán
                newRow.find('input[type="number"]').val(0); // Mặc định tất cả số là 0
                newRow.find('input[type="number"][min="1"]').val(1); // Riêng ô số lượng set thành 1

                // --- Xử lý Select2 khi Clone (Phần này bạn làm đúng rồi, nhưng mình comment rõ hơn) ---
                const select = newRow.find('select.loai_bienthe');

                // Xóa cái khung hiển thị Select2 cũ đi (của dòng gốc)
                newRow.find('.select2-container').remove();

                // Reset thẻ select về nguyên thủy (bỏ class và attribute do select2 sinh ra)
                select.removeClass('select2-hidden-accessible')
                    .removeAttr('data-select2-id')
                    .removeAttr('tabindex')
                    .removeAttr('aria-hidden');

                // Reset giá trị select về option đầu tiên
                select.val(select.find('option:first').val());

                // --- Sửa dòng mới vào bảng ---
                tableBody.append(newRow);

                // --- Khởi tạo lại Plugin cho dòng mới ---
                // 1. Init Select2 cho dòng mới (Dùng lại config ở trên)
                select.select2(select2Config);

                // 2. Init lại Icon Feather (để hiện nút xóa)
                feather.replace();

                // 3. Cập nhật lại index name và trạng thái nút xóa
                updateVariantState();
            });


            // === 4. XỬ LÝ SỰ KIỆN XÓA BIẾN THỂ ===
            tableBody.on('click', '.btn-delete-variant', function () {
                const rows = tableBody.find('tr');
                if (rows.length > 1) {
                    // Trước khi xóa, nên destroy select2 để tránh rác bộ nhớ (optional nhưng tốt)
                    $(this).closest('tr').find('.loai_bienthe').select2('destroy');

                    $(this).closest('tr').remove(); // Xóa dòng
                    updateVariantState(); // Cập nhật lại index
                }
            });


            // === 5. ĐỊNH DẠNG TIỀN TỆ ===
            $(document).on('input', '.currency-input', function (e) {
                let value = e.target.value;
                value = value.replace(/\D/g, ""); // Xóa ký tự không phải số
                if (value === "") {
                    e.target.value = "";
                    return;
                }
                // Format định dạng việt nam
                e.target.value = Number(value).toLocaleString('vi-VN');
            });
        });
    </script>
    <script>
        function ChangeToSlug() {
            let title, slug;

            // 1. Lấy text từ ô nhập liệu
            title = document.getElementById("slug-source").value;

            // 2. Xử lý chuỗi (Chuyển tiếng Việt -> Không dấu -> Gạch ngang)
            slug = title.toLowerCase();
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            slug = slug.replace(/ /gi, "-");
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');

            // 3. Nếu input rỗng thì hiển thị text mặc định, ngược lại thì hiển thị slug
            if (slug === "") {
                document.getElementById('slug-text').innerText = "...";
            } else {
                document.getElementById('slug-text').innerText = slug;
            }
        }
    </script>
@endsection