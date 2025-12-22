@extends('admin.layouts.app')

@section('title', 'Tạo danh mục | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <form class="content" action="{{ route('quan-tri-vien.luu-danh-muc') }}" method="post">
            @csrf
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm danh mục sản phẩm</h4>
                    <h6>Thêm thông tin danh mục sản phẩm của bạn vào hệ thống</h6>
                </div>
                <div class="page-btn">
                    <button type="submit" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg"
                            alt="img" class="me-1">Lưu danh mục</button>
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Tên danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <input class="text-black" type="text" name="tendm" value=""
                                            placeholder="Nhập tên danh mục sản phẩm..." id="slug-source"
                                            onkeyup="ChangeToSlug();" />
                                        <label>Đường dẫn: <span class="fst-italic form-text text-muted"
                                                id="slug-text">...</span></label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Mô tả danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <textarea class="form-control" name="mota" id="mo_ta" value=""
                                            style="height: 200px;">Ơ là hò ơ</textarea>
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
                                    <label>Sắp xếp danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                                            class="text-danger" title="Bắt buộc">*</span></label>
                                    <input class="text-black form-control" type="number" name="sapxep" value=""
                                        placeholder="sắp xếp số thứ tự" />
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Chọn danh mục cha (nếu có)<span data-bs-toggle="tooltip"
                                                data-bs-placement="top" class="text-danger"
                                                title="Bắt buộc">*</span></label>
                                        <select class="select" name="parent">
                                            <option selected>Không có</option>
                                            @foreach ($danhmuc as $dm)
                                                <option value="{{ $dm->id }}">{{ $dm->ten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Trạng thái danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>
                                        <select class="select text-black" name="trangthai">
                                            <option value="Hiển thị">Công khai</option>
                                            <option value="Tạm ẩn">Tạm ẩn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label> Hình ảnh danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                class="text-danger" title="Bắt buộc">*</span></label>

                                        <div class="image-upload" id="drop-zone">
                                            <input type="file" id="imageInput" name="images" accept="image/*" />
                                            <div class="image-uploads">
                                                <img src="{{asset('assets/admin')}}/img/icons/upload.svg" alt="img" />
                                                <h4>Kéo và thả file tại đây hoặc click để chọn</h4>
                                            </div>
                                        </div>

                                        <div class="row mt-3" id="image-preview-container">
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


            // === 3. XỬ LÝ SỰ KIỆN THÊM BIẾN THỂ ===
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

                // --- Thêm dòng mới vào bảng ---
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
    <script>
        $(document).ready(function () {
            // Mảng lưu trữ các file hiện tại (Dùng DataTransfer để đồng bộ với input)
            let dt = new DataTransfer();
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('image-preview-container');

            // 1. XỬ LÝ KHI CHỌN FILE
            $('#imageInput').on('change', function (e) {
                for (let i = 0; i < this.files.length; i++) {
                    let file = this.files[i];
                    // Chỉ chấp nhận file ảnh và không trùng lặp (nếu muốn)
                    dt.items.add(file);
                }
                // Cập nhật lại input và render view
                updateInputFiles();
                renderPreview();
            });

            // 2. HÀM RENDER ẢNH PREVIEW
            function renderPreview() {
                previewContainer.innerHTML = ''; // Xóa preview cũ

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

                // Gán lại sự kiện Drag & Drop cho các item mới sinh ra
                addDragDropEvents();
            }

            // 3. HÀM CẬP NHẬT LẠI INPUT FILE (QUAN TRỌNG CHO LARAVEL)
            window.updateInputFiles = function () {
                imageInput.files = dt.files;
            }

            // 4. HÀM XÓA ẢNH
            window.removeImage = function (index) {
                const newDt = new DataTransfer();
                Array.from(dt.files).forEach((file, i) => {
                    if (i !== index) newDt.items.add(file);
                });
                dt = newDt; // Cập nhật lại biến global
                updateInputFiles(); // Đồng bộ input
                renderPreview(); // Vẽ lại giao diện
            }

            // 5. XỬ LÝ KÉO THẢ SẮP XẾP (DRAG & DROP)
            function addDragDropEvents() {
                const items = document.querySelectorAll('.preview-image-item');
                let dragStartIndex;

                items.forEach(item => {
                    item.addEventListener('dragstart', function () {
                        dragStartIndex = +this.getAttribute('data-index');
                        this.classList.add('dragging');
                    });

                    item.addEventListener('dragend', function () {
                        this.classList.remove('dragging');
                    });

                    item.addEventListener('dragover', function (e) {
                        e.preventDefault(); // Cho phép drop
                    });

                    item.addEventListener('drop', function () {
                        const dragEndIndex = +this.getAttribute('data-index');
                        swapItems(dragStartIndex, dragEndIndex);
                    });
                });
            }

            // 6. LOGIC HOÁN ĐỔI VỊ TRÍ TRONG MẢNG FILE
            function swapItems(fromIndex, toIndex) {
                if (fromIndex === toIndex) return;

                const fileArray = Array.from(dt.files);

                // Hoán đổi vị trí trong mảng tạm
                const itemToMove = fileArray.splice(fromIndex, 1)[0];
                fileArray.splice(toIndex, 0, itemToMove);

                // Tạo DataTransfer mới từ mảng đã sắp xếp
                const newDt = new DataTransfer();
                fileArray.forEach(file => newDt.items.add(file));

                dt = newDt; // Cập nhật biến gốc
                updateInputFiles(); // Cập nhật input thật
                renderPreview(); // Vẽ lại
            }
        });
    </script>
@endsection