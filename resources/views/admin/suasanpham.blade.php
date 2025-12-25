@extends('admin.layouts.app')

@section('title', 'Cập nhật sản phẩm | Quản trị hệ thống Siêu Thị Vina')

@section('content')
  <div class="page-wrapper">
    {{-- FORM ACTION TRỎ VỀ ROUTE UPDATE --}}
    <form class="content" action="{{ route('quan-tri-vien.cap-nhat-san-pham', $sanpham->id) }}" method="post" enctype="multipart/form-data">
      @csrf 
      @method('PUT') {{-- QUAN TRỌNG: Method PUT cho update --}}
      
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <div class="page-header">
        <div class="page-title">
          <h4>Cập nhật sản phẩm</h4>
          <h6>Chỉnh sửa thông tin sản phẩm</h6>
        </div>
        <div class="page-btn">
          {{-- Nút Lưu thay đổi --}}
          <button type="submit" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img"
              class="me-1">Lưu thay đổi</button>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                    {{-- VALUE CŨ --}}
                    <input class="text-black form-control" type="text" name="tensp" value="{{ old('tensp', $sanpham->ten) }}" placeholder="Nhập tên sản phẩm..."
                      id="slug-source" onkeyup="ChangeToSlug();" />
                    <label>Đường dẫn: <span class="fst-italic form-text text-muted" id="slug-text">{{ $sanpham->slug }}</span></label>
                    @error('tensp') <span class="form-text text-muted text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Xuất xứ <span class="text-danger">*</span></label>
                     {{-- VALUE CŨ --}}
                    <input class="text-black form-control" type="text" name="xuatxu" value="{{ old('xuatxu', $sanpham->xuatxu) }}" placeholder="Nhập xuất xứ..." />
                    @error('xuatxu') <span class="form-text text-muted text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Nơi sản xuất</label>
                     {{-- VALUE CŨ --}}
                    <input class="text-black form-control" type="text" name="sanxuat" value="{{ old('sanxuat', $sanpham->sanxuat) }}" placeholder="Nhập nơi sản xuất..." />
                    @error('sanxuat') <span class="form-text text-muted text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Mô tả sản phẩm <span class="text-danger">*</span></label>
                    {{-- VALUE CŨ TRONG TEXTAREA --}}
                    <textarea class="form-control" name="mo_ta" id="mo_ta">{{ old('mo_ta', $sanpham->mota) }}</textarea>
                    @error('mo_ta') <span class="form-text text-muted text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                
                {{-- KHU VỰC BIẾN THỂ --}}
                <div class="col-lg-12 mb-3">
                  <div class="flex-align">
                    <button type="button" class="btn btn-primary my-2 btn-add-variant"
                      style="font-size: 12px; display: flex; align-items: center;"><i class="me-1"
                        data-feather="plus-circle" style="width: 15px; margin: 0px; padding: 0px;"></i> <span
                        class="m-0">Thêm biến thể sản phẩm</span></button>
                  </div>
                  
                  <table class="table rounded-2">
                    <tbody>
                      {{-- LOOP QUA BIẾN THỂ CŨ --}}
                      @foreach($sanpham->bienthe as $index => $bt)
                      <tr>
                        {{-- INPUT HIDDEN ID ĐỂ BIẾT LÀ UPDATE --}}
                        <input type="hidden" name="bienthe[{{ $index }}][id_bienthe_cu]" value="{{ $bt->id }}">

                        <td style="width: 30%;">
                          <div class="form-group">
                            <label>Loại biến thể <span class="text-danger">*</span></label>
                            <select class="form-control loai_bienthe" name="bienthe[{{ $index }}][id_tenloai]">
                              <option disabled>-- Chọn loại --</option>
                              @foreach ($loaibienthes as $loaibienthe)
                                {{-- SELECTED CŨ --}}
                                <option value="{{ $loaibienthe->id }}" {{ $bt->id_loaibienthe == $loaibienthe->id ? 'selected' : '' }}>
                                    {{ $loaibienthe->ten }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                        </td>
                        <td style="width: 25%;">
                          <div class="form-group">
                            <label>Giá bán <span class="text-danger">*</span></label>
                            {{-- FORMAT TIỀN --}}
                            <input type="text" class="form-control currency-input" name="bienthe[{{ $index }}][gia]" 
                                   value="{{ number_format($bt->giagoc, 0, ',', '.') }}" placeholder="0"/>
                          </div>
                        </td>
                        <td style="width: 20%;">
                          <div class="form-group">
                            <label>Số lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="bienthe[{{ $index }}][soluong]" value="{{ $bt->soluong }}" min="0" />
                          </div>
                        </td>
                         <td style="width: 15%;">
                          <div class="form-group">
                            <label>SL Tặng</label>
                             <input type="number" class="form-control" name="bienthe[{{ $index }}][luottang]" value="{{ $bt->luottang }}" min="0" />
                          </div>
                        </td>
                        <td style="width: 10%;">
                          <button type="button" class="btn btn-primary m-0 btn-delete-variant" style="font-size: 12px;"><i
                              data-feather="trash" style="width: 15px; margin: 0px; padding: 0px;"></i></button>
                        </td>
                      </tr>
                      @endforeach
                      {{-- NẾU SẢN PHẨM CŨ BỊ LỖI KHÔNG CÓ BIẾN THỂ NÀO THÌ HIỆN 1 DÒNG TRỐNG (ĐỂ CLONE) --}}
                      @if($sanpham->bienthe->count() == 0)
                        <tr>
                            {{-- Dòng trống y hệt file create --}}
                            <td style="width: 30%;">
                                <div class="form-group">
                                    <label>Loại biến thể <span class="text-danger">*</span></label>
                                    <select class="form-control loai_bienthe" name="bienthe[0][id_tenloai]">
                                        <option disabled selected>-- Chọn loại --</option>
                                        @foreach ($loaibienthes as $loaibienthe)
                                            <option value="{{ $loaibienthe->id }}">{{ $loaibienthe->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td style="width: 25%;">
                                <div class="form-group">
                                    <label>Giá bán <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control currency-input" name="bienthe[0][gia]" value="" placeholder="0"/>
                                </div>
                            </td>
                            <td style="width: 20%;">
                                <div class="form-group">
                                    <label>Số lượng <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="bienthe[0][soluong]" value="1" min="0" />
                                </div>
                            </td>
                             <td style="width: 15%;">
                                <div class="form-group">
                                    <label>SL Tặng</label>
                                    <input type="number" class="form-control" name="bienthe[0][luottang]" value="0" min="0" />
                                </div>
                            </td>
                            <td style="width: 10%;">
                                <button type="button" class="btn btn-primary m-0 btn-delete-variant" style="font-size: 12px;"><i
                                    data-feather="trash" style="width: 15px; margin: 0px; padding: 0px;"></i></button>
                            </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
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
                    <div class="form-group mb-3">
                        <label>Chọn danh mục <span class="text-danger">*</span></label>
                        {{-- LẤY MẢNG ID DANH MỤC ĐANG CÓ CỦA SP --}}
                        @php 
                            $selectedDanhmuc = $sanpham->danhmuc->pluck('id')->toArray(); 
                        @endphp

                        <div class="border rounded p-2 bg-white" style="max-height: 200px; overflow-y: auto;">
                            <ul class="list-unstyled m-0">
                                @foreach($danhmucs as $cha)
                                    @if(empty($cha->parent)) 
                                        <li>
                                            <div class="form-check">
                                                {{-- CHECKED CŨ --}}
                                                <input class="form-check-input" type="checkbox" name="id_danhmuc[]" 
                                                      value="{{ $cha->id }}" id="cat{{ $cha->id }}"
                                                      {{ in_array($cha->id, $selectedDanhmuc) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cat{{ $cha->id }}">
                                                    {{ $cha->ten }}
                                                </label>
                                            </div>

                                            <ul class="list-unstyled ps-4">
                                                @foreach($danhmucs as $con)
                                                    @if($con->parent == $cha->id)
                                                        <li>
                                                            <div class="form-check">
                                                                {{-- CHECKED CŨ --}}
                                                                <input class="form-check-input" type="checkbox" name="id_danhmuc[]" 
                                                                          value="{{ $con->id }}" id="cat{{ $con->id }}"
                                                                          {{ in_array($con->id, $selectedDanhmuc) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="cat{{ $con->id }}">
                                                                    {{ $con->ten }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @error('id_danhmuc') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Thương hiệu <span class="text-danger">*</span></label>
                    <select class="select thuonghieu" name="id_thuonghieu">
                      <option disabled>--Chọn thương hiệu--</option>
                      @foreach ($thuonghieus as $thuonghieu)
                        {{-- SELECTED CŨ --}}
                        <option value="{{ $thuonghieu->id }}" {{ $sanpham->id_thuonghieu == $thuonghieu->id ? 'selected' : '' }}>
                            {{ $thuonghieu->ten }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_thuonghieu') <span class="form-text text-muted text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Trạng thái sản phẩm <span class="text-danger">*</span></label>
                    <select class="select text-black" name="trangthai">
                      <option value="Công khai" {{ $sanpham->trangthai == 'Công khai' ? 'selected' : '' }}>Công khai</option>
                      <option value="Tạm ẩn" {{ $sanpham->trangthai == 'Tạm ẩn' ? 'selected' : '' }}>Tạm ẩn</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label> Hình ảnh sản phẩm (Thêm mới nếu cần)</label>
                    <div class="image-upload" id="drop-zone">
                      <input type="file" id="imageInput" name="anhsanpham[]" multiple accept="image/*" />
                      <div class="image-uploads">
                        <img src="{{asset('assets/admin')}}/img/icons/upload.svg" alt="img" />
                        <h4>Kéo và thả file tại đây để thêm</h4>
                      </div>
                    </div>
                    @error('anhsanpham') <span class="form-text text-muted text-danger">{{ $message }}</span> @enderror
                    
                    {{-- HIỂN THỊ ẢNH CŨ VÀ ẢNH PREVIEW MỚI --}}
                    <div class="row mt-3" id="image-preview-container">
                        {{-- LOOP ẢNH CŨ TỪ DB --}}
                        @foreach($sanpham->hinhanhsanpham as $img)
                            <div class="preview-image-item existing-image" data-id="{{ $img->id }}">
                                <img src="{{ asset('assets/client/images/thumbs/' . $img->hinhanh) }}" alt="Image">
                                {{-- Nút xóa ảnh cũ --}}
                                <button type="button" class="btn-remove-image btn-remove-existing" data-id="{{ $img->id }}">&times;</button>
                            </div>
                        @endforeach
                        {{-- Ảnh preview upload mới sẽ chui vào đây nhờ JS --}}
                    </div>
                    
                    {{-- Input hidden để chứa ID ảnh cần xóa --}}
                    <div id="deleted-images-container"></div>

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
  {{-- GIỮ NGUYÊN STYLE VÀ CÁC SCRIPT CKEDITOR, SELECT2 CŨ --}}
  <style>
    /* Style cũ giữ nguyên */
    #image-preview-container { display: flex; flex-wrap: wrap; gap: 5px; }
    .preview-image-item { position: relative; width: 120px; height: 120px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; cursor: grab; background: #fff; transition: transform 0.2s; }
    .preview-image-item img { width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
    .btn-remove-image { position: absolute; top: 5px; right: 5px; background: rgba(255, 0, 0, 0.7); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; z-index: 10; }
  </style>

  <script>
    if(document.querySelector('#mo_ta')) {
         ClassicEditor.create(document.querySelector('#mo_ta'), editorConfig);
    }
  </script>

  <script>
    $(document).ready(function () {
      
      const select2Config = { tags: true, placeholder: "Chọn loại", width: '100%' };
      $('.loai_bienthe').select2(select2Config);
      $('.thuonghieu').select2();

      const tableBody = $('.table tbody');

      function updateVariantState() {
        const rows = tableBody.find('tr');
        if (rows.length === 1) {
          rows.find('.btn-delete-variant').prop('disabled', true).css('opacity', '0.5');
        } else {
          rows.find('.btn-delete-variant').prop('disabled', false).css('opacity', '1');
        }

        // Cập nhật lại name cho input: bienthe[0], bienthe[1]...
        rows.each(function (index) {
          const row = $(this);
          
          // SỬA NAME CHUẨN: bienthe[index][key]
          row.find('[name^="bienthe"]').each(function () {
            const oldName = $(this).attr('name');
            // Regex thay thế index số cũ bằng index mới
            const newName = oldName.replace(/bienthe\[\d+\]/, `bienthe[${index}]`);
            $(this).attr('name', newName);
          });
        });
      }

      // Không gọi updateVariantState() ngay lúc load vì blade đã render chuẩn index rồi
      // Chỉ gọi khi thêm/xóa dòng
      // updateVariantState(); 

      $('.btn-add-variant').click(function () {
        // Clone dòng đầu tiên (để lấy cấu trúc)
        // LƯU Ý: Dòng đầu tiên có thể chứa ID cũ, cần xóa đi
        const firstRow = tableBody.find('tr:first'); 
        const newRow = firstRow.clone();

        // RESET GIÁ TRỊ INPUT
        newRow.find('input').not('[type="checkbox"]').val(''); 
        newRow.find('input[type="number"][name*="soluong"]').val(1); 
        newRow.find('input[type="number"][name*="luottang"]').val(0);
        newRow.find('input[name*="gia"]').val(''); 

        // QUAN TRỌNG: XÓA INPUT HIDDEN CHỨA ID CŨ (Để controller hiểu là tạo mới)
        newRow.find('input[name*="id_bienthe_cu"]').remove();

        // Xử lý Select2 khi clone
        const select = newRow.find('select.loai_bienthe');
        newRow.find('.select2-container').remove(); // Xóa khung select2 cũ đi kèm
        select.removeClass('select2-hidden-accessible').removeAttr('data-select2-id').removeAttr('tabindex').removeAttr('aria-hidden');
        select.val(select.find('option:first').val()); // Reset option

        tableBody.append(newRow);
        
        // Khởi tạo lại select2 cho dòng mới
        select.select2(select2Config);
        feather.replace();
        updateVariantState(); // Cập nhật lại index
      });

      tableBody.on('click', '.btn-delete-variant', function () {
        const rows = tableBody.find('tr');
        if (rows.length > 1) {
          $(this).closest('tr').find('.loai_bienthe').select2('destroy');
          $(this).closest('tr').remove();
          updateVariantState();
        }
      });

      // Format tiền tệ
      $(document).on('input', '.currency-input', function (e) {
        let value = e.target.value;
        value = value.replace(/\D/g, "");
        if (value === "") { e.target.value = ""; return; }
        e.target.value = Number(value).toLocaleString('vi-VN');
      });

      // --- LOGIC XÓA ẢNH CŨ ---
      $(document).on('click', '.btn-remove-existing', function() {
          const imgId = $(this).data('id');
          // Thêm input hidden vào form để báo Controller biết cần xóa ảnh này
          $('#deleted-images-container').append(`<input type="hidden" name="delete_images[]" value="${imgId}">`);
          // Xóa khỏi giao diện
          $(this).closest('.existing-image').remove();
      });

    });
  </script>

  {{-- SCRIPT CHANGE SLUG --}}
   <script>
    function ChangeToSlug() {
      // ... (Giữ nguyên script cũ của bạn) ...
      let title, slug;
      title = document.getElementById("slug-source").value;
      slug = title.toLowerCase();
      // ... (Phần replace dấu tiếng Việt giữ nguyên) ...
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
      if (slug === "") {
        document.getElementById('slug-text').innerText = "...";
      } else {
        document.getElementById('slug-text').innerText = slug;
      }
    }
  </script>

  {{-- SCRIPT UPLOAD MỚI (CHỈ XỬ LÝ ẢNH MỚI, KHÔNG ĐỤNG ẢNH CŨ) --}}
  <script>
    $(document).ready(function () {
      let dt = new DataTransfer();
      const imageInput = document.getElementById('imageInput');
      const previewContainer = document.getElementById('image-preview-container');

      $('#imageInput').on('change', function (e) {
        for (let i = 0; i < this.files.length; i++) {
          let file = this.files[i];
          dt.items.add(file);
        }
        updateInputFiles();
        renderPreview();
      });

      function renderPreview() {
        // CHỈ XÓA CÁC ẢNH PREVIEW CŨ (CLASS preview-new-item), KHÔNG XÓA ẢNH CÓ SẴN (CLASS existing-image)
        $('.preview-new-item').remove();

        Array.from(dt.files).forEach((file, index) => {
          const reader = new FileReader();
          reader.onload = function (e) {
            const html = `
                    <div class="preview-image-item preview-new-item" draggable="true" data-index="${index}">
                        <img src="${e.target.result}" alt="Image">
                        <button type="button" class="btn-remove-image" onclick="removeImage(${index})">&times;</button>
                    </div>
                        `;
            $(previewContainer).append(html); // Append vào cuối (sau các ảnh cũ)
          }
          reader.readAsDataURL(file);
        });
        // addDragDropEvents(); // Có thể bỏ qua drag drop cho đơn giản logic edit
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