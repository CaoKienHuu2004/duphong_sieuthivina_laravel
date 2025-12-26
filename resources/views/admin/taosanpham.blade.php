@extends('admin.layouts.app')

@section('title', 'Tạo sản phẩm | Quản trị hệ thống Siêu Thị Vina')

@section('content')
  <div class="page-wrapper">
    {{-- SỬA: Thêm route store-sanpham (bạn cần đảm bảo route này có trong web.php) --}}
    <form class="content" action="{{ route('quan-tri-vien.luu-san-pham') }}" method="post" enctype="multipart/form-data">
      @csrf {{-- QUAN TRỌNG: Phải có CSRF token --}}
      
      {{-- Hiển thị lỗi nếu có --}}
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
          <h4>Thêm sản phẩm</h4>
          <h6>Thêm thông tin sản phẩm của bạn vào hệ thống</h6>
        </div>
        <div class="page-btn">
          <button type="submit" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img"
              class="me-1">Tạo sản phẩm</button>
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
                    <input class="text-black form-control" type="text" name="tensp" value="{{ old('tensp') }}" placeholder="Nhập tên sản phẩm..."
                      id="slug-source" onkeyup="ChangeToSlug();" />
                    <label>Đường dẫn: <span class="fst-italic form-text text-muted" id="slug-text">...</span></label>
                    @error('tensp')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Xuất xứ <span class="text-danger">*</span></label>
                    <input class="text-black form-control" type="text" name="xuatxu" value="{{ old('xuatxu') }}" placeholder="Nhập xuất xứ..." />
                    @error('xuatxu')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Nơi sản xuất</label>
                    <input class="text-black form-control" type="text" name="sanxuat" value="{{ old('sanxuat') }}" placeholder="Nhập nơi sản xuất..." />
                    @error('sanxuat')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Mô tả sản phẩm <span class="text-danger">*</span></label>
                    {{-- SỬA: id trùng với script CKEditor, name là mo_ta --}}
                    <textarea class="form-control" name="mo_ta" id="mo_ta">{{ old('mo_ta') }}</textarea>
                    @error('mo_ta')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
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
                      <tr>
                        <td style="width: 30%;">
                          <div class="form-group">
                            <label>Loại biến thể <span class="text-danger">*</span></label>
                            {{-- Name chuẩn mảng --}}
                            <select class="form-control loai_bienthe" name="bienthe[0][id_tenloai]">
                              <option disabled selected>-- Chọn loại --</option>
                              @foreach ($loaibienthes as $loaibienthe)
                                <option value="{{ $loaibienthe->id }}">{{ $loaibienthe->ten }}</option>
                              @endforeach
                            </select>
                            @error('bienthe.0.id_tenloai')
                              <span class="form-text text-muted text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        </td>
                        <td style="width: 25%;">
                          <div class="form-group">
                            <label>Giá bán <span class="text-danger">*</span></label>
                            {{-- SỬA: Thêm name="bienthe[0][gia]" --}}
                            <input type="text" class="form-control currency-input" name="bienthe[0][gia]" value="" placeholder="0"/>
                            @error('bienthe.0.gia')
                              <span class="form-text text-muted text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        </td>
                        <td style="width: 20%;">
                          <div class="form-group">
                            <label>Số lượng <span class="text-danger">*</span></label>
                             {{-- SỬA: Thêm name="bienthe[0][soluong]" --}}
                            <input type="number" class="form-control" name="bienthe[0][soluong]" value="1" min="0" />
                            @error('bienthe.0.soluong')
                              <span class="form-text text-muted text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        </td>
                        {{-- Phần quà tặng và giảm giá có thể thêm name tương tự nếu cần lưu --}}
                         <td style="width: 15%;">
                          <div class="form-group">
                            <label>Số lượng quà tặng</label>
                             <input type="number" class="form-control" name="bienthe[0][luottang]" value="0" min="0" />
                          </div>
                        </td>
                        <td style="width: 10%;">
                          <button type="button" class="btn btn-primary m-0 btn-delete-variant" style="font-size: 12px;"><i
                              data-feather="trash" style="width: 15px; margin: 0px; padding: 0px;"></i></button>
                        </td>
                      </tr>
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
                        
                        <div class="border rounded p-2 bg-white" style="max-height: 200px; overflow-y: auto;">
                            <ul class="list-unstyled m-0">
                                @foreach($danhmucs as $cha)
                                    @if(empty($cha->parent)) 
                                        <li>
                                            <div class="form-check">
                                                {{-- SỬA: name="id_danhmuc[]" --}}
                                                <input class="form-check-input" type="checkbox" name="id_danhmuc[]" 
                                                      value="{{ $cha->id }}" id="cat{{ $cha->id }}">
                                                <label class="form-check-label" for="cat{{ $cha->id }}">
                                                    {{ $cha->ten }}
                                                </label>
                                            </div>

                                            <ul class="list-unstyled ps-4">
                                                @foreach($danhmucs as $con)
                                                    @if($con->parent == $cha->id)
                                                        <li>
                                                            <div class="form-check">
                                                                {{-- SỬA: name="id_danhmuc[]" --}}
                                                                <input class="form-check-input" type="checkbox" name="id_danhmuc[]" 
                                                                      value="{{ $con->id }}" id="cat{{ $con->id }}">
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
                        @error('id_danhmuc')
                            <div class="text-danger mt-1 small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Thương hiệu <span class="text-danger">*</span></label>
                    {{-- SỬA: name="id_thuonghieu" --}}
                    <select class="select thuonghieu" name="id_thuonghieu">
                      <option selected disabled>--Chọn thương hiệu--</option>
                      @foreach ($thuonghieus as $thuonghieu)
                        <option value="{{ $thuonghieu->id }}">{{ $thuonghieu->ten }}</option>
                      @endforeach
                    </select>
                    @error('id_thuonghieu')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Trạng thái sản phẩm <span class="text-danger">*</span></label>
                    <select class="select text-black" name="trangthai">
                      <option value="Công khai" selected>Đăng bán</option>
                      <option value="Quà tặng">Quà tặng</option>
                      <option value="Tạm ẩn">Tạm ẩn</option>
                    </select>

                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label> Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                    <div class="image-upload" id="drop-zone">
                      {{-- SỬA: name="anhsanpham[]" --}}
                      <input type="file" id="imageInput" name="anhsanpham[]" multiple accept="image/*" />
                      <div class="image-uploads">
                        <img src="{{asset('assets/admin')}}/img/icons/upload.svg" alt="img" />
                        <h4>Kéo và thả file tại đây</h4>
                      </div>
                    </div>
                    @error('anhsanpham')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
                    
                    <div class="row mt-3" id="image-preview-container"></div>
                    @error('anhsanpham.*')
                      <span class="form-text text-muted text-danger">{{ $message }}</span>
                    @enderror
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
  {{-- GIỮ NGUYÊN PHẦN CSS CỦA BẠN --}}
  <style>
    /* ... (Giữ nguyên CSS cũ) ... */
    #image-preview-container { display: flex; flex-wrap: wrap; gap: 5px; }
    .preview-image-item { position: relative; width: 120px; height: 120px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; cursor: grab; background: #fff; transition: transform 0.2s; }
    .preview-image-item img { width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
    .btn-remove-image { position: absolute; top: 5px; right: 5px; background: rgba(255, 0, 0, 0.7); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px; z-index: 10; }
  </style>

  {{-- SCRIPT CKEDITOR GIỮ NGUYÊN --}}
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
          // Regex để tìm bienthe[x][y] và thay bằng bienthe[index][y]
          row.find('[name*="bienthe"]').each(function () {
            const name = $(this).attr('name');
            const newName = name.replace(/bienthe\[\d+\]/, `bienthe[${index}]`);
            $(this).attr('name', newName);
          });
        });
      }

      updateVariantState();

      $('.btn-add-variant').click(function () {
        const firstRow = tableBody.find('tr:first');
        const newRow = firstRow.clone();

        newRow.find('input').val(''); // Reset giá trị
        newRow.find('input[type="number"][name*="soluong"]').val(1); 
        newRow.find('input[type="number"][name*="giamgia"]').val(0);

        const select = newRow.find('select.loai_bienthe');
        newRow.find('.select2-container').remove();
        select.removeClass('select2-hidden-accessible').removeAttr('data-select2-id').removeAttr('tabindex').removeAttr('aria-hidden');
        select.val(select.find('option:first').val());

        tableBody.append(newRow);
        select.select2(select2Config);
        feather.replace();
        updateVariantState();
      });

      tableBody.on('click', '.btn-delete-variant', function () {
        const rows = tableBody.find('tr');
        if (rows.length > 1) {
          $(this).closest('tr').find('.loai_bienthe').select2('destroy');
          $(this).closest('tr').remove();
          updateVariantState();
        }
      });

      $(document).on('input', '.currency-input', function (e) {
        let value = e.target.value;
        value = value.replace(/\D/g, "");
        if (value === "") { e.target.value = ""; return; }
        e.target.value = Number(value).toLocaleString('vi-VN');
      });
    });
  </script>

  {{-- SCRIPT UPLOAD ẢNH & SLUG (GIỮ NGUYÊN LOGIC CỦA BẠN) --}}
  <script>
     // ... (Copy lại script ChangeToSlug và script Drag Drop ảnh của bạn vào đây) ...
     // Nhớ sửa dòng này trong script ảnh của bạn để đồng bộ input file:
     // const imageInput = document.getElementById('imageInput'); 
     // (ID này đã có trong HTML mới tôi sửa ở trên)
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
        addDragDropEvents();
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
            e.preventDefault();
          });
          item.addEventListener('drop', function () {
            const dragEndIndex = +this.getAttribute('data-index');
            swapItems(dragStartIndex, dragEndIndex);
          });
        });
      }

      function swapItems(fromIndex, toIndex) {
        if (fromIndex === toIndex) return;
        const fileArray = Array.from(dt.files);
        const itemToMove = fileArray.splice(fromIndex, 1)[0];
        fileArray.splice(toIndex, 0, itemToMove);
        const newDt = new DataTransfer();
        fileArray.forEach(file => newDt.items.add(file));
        dt = newDt;
        updateInputFiles();
        renderPreview();
      }
    });
  </script>
@endsection