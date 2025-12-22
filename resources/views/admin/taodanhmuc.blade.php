@extends('admin.layouts.app')

@section('title', 'Tạo danh mục | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
      <form class="content" action="#" method="post" enctype="multipart/form-data">
        <div class="page-header">
          <div class="page-title">
            <h4>Thêm danh mục sản phẩm</h4>
            <h6>Thêm thông tin danh mục sản phẩm của bạn vào hệ thống</h6>
          </div>
          <div class="page-btn">
            <button type="submit" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Lưu danh mục</button>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-6 col-12">
                    <div class="form-group">
                      <label>Tên danh mục <span data-bs-toggle="tooltip" data-bs-placement="top" class="text-danger"
                          title="Bắt buộc">*</span></label>
                      <input class="text-black" type="text" name="tensp" value="" placeholder="Nhập tên danh mục sản phẩm..."
                        id="slug-source" onkeyup="ChangeToSlug();" />
                      <label>Đường dẫn: <span class="fst-italic form-text text-muted" id="slug-text">...</span></label>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label>Mô tả danh mục <span data-bs-toggle="tooltip" data-bs-placement="top" class="text-danger"
                          title="Bắt buộc">*</span></label>
                      <textarea class="form-control" name="mota" id="mo_ta" value="" style="height: 200px;"></textarea>
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
                      <label>Chọn danh mục cha (nếu có)<span data-bs-toggle="tooltip" data-bs-placement="top" class="text-danger"
                          title="Bắt buộc">*</span></label>
                      <select class="select">
                        <option selected>Không có</option>
                        <option>Brand</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12 col-sm-6 col-12">
                    <div class="form-group">
                      <label>Trạng thái danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                          class="text-danger" title="Bắt buộc">*</span></label>
                      <select class="select text-black">
                        <option>Công khai</option>
                        <option>Tặm khóa</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label> Hình ảnh danh mục <span data-bs-toggle="tooltip" data-bs-placement="top"
                          class="text-danger" title="Bắt buộc">*</span></label>

                      <div class="image-upload" id="drop-zone">
                        <input type="file" id="imageInput" name="images[]" accept="image/*" />
                        <div class="image-uploads">
                          <img src="assets/img/icons/upload.svg" alt="img" />
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