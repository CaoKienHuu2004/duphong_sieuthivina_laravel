@extends('admin.layouts.app')

@section('title', 'Tạo sản phẩm | Quản trị hệ thống Siêu Thị Vina')

@section('content')
  <div class="page-wrapper">
    <div class="content">
      <div class="page-header">
        <div class="page-title">
          <h4>Tạo sản phẩm</h4>
          <h6>Tạo mới một sản phẩm của bạn</h6>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body">
              <form class="row" action="#" method="POST">
                @csrf
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Tên sản phẩm <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <input class="form-control" type="text" name="tensp" id="tensp" value=""
                      placeholder="tên sản phẩm..." />
                  </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Nơi xuất xứ <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <input type="text" name="xuatxu" value="" class="form-control" placeholder="xuất xứ ở..." />
                  </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Nơi sản xuất <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <input type="text" name="sanxuat" value="" class="form-control" placeholder="sản xuất tại..." />
                  </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Trạng thái</label>
                    <select class="form-select" name="trangthai">
                      <option value="0" selected>Còn hàng</option>
                      <option value="1">Hết hàng</option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Mô tả sản phẩm <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <textarea name="mo_ta" id="mo_ta" class="form-control"></textarea>
                  </div>
                </div>

                <div id="SpacingTwo" class="accordion-collapse collapse show rounded-2" aria-labelledby="headingSpacingTwo" style=""
                  data-select2-id="SpacingTwo">
                  <div class="accordion-body p-0" data-select2-id="57">
                    <label>Biến thể sản phẩm <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <div class="tab-content" id="pills-tabContent" data-select2-id="pills-tabContent">
                      <div class="tab-pane fade active show" id="pills-profile" role="tabpanel"
                        aria-labelledby="pills-profile-tab">

                        <div class="modal-body-table border" id="variant-table">
                          <div class="table-responsive">
                            <table class="table border">
                              <thead>
                                <tr>
                                  <th>Biến thể</th>
                                  <th>Số lượng</th>
                                  <th>Giá gốc</th>
                                  <th class="no-sort"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="add-product">
                                      <select class="form-control loai_bienthe" name="bienthe[0][id_tenloai]">
                                        <option>--Loại biến thể--</option>
                                        <option value="1">Lọ</option>
                                        <option value="2">Hộp</option>
                                        <option value="3">Gói</option>
                                        <option value="4">Túi 500ml</option>
                                        <option value="5">Hộp (Vỏ lụa) 500g</option>
                                        <option value="6">Hộp (đã lột vỏ) 500g</option>
                                        <option value="7">Chai</option>
                                        <option value="8">Bình xịt</option>
                                        <option value="9">Cái</option>
                                        <option value="10">Đường ăn kiêng (190ml/lon)</option>
                                        <option value="11">Có đường (190ml/lon)</option>
                                        <option value="12">Plus ít đường (190ml/lon)</option>
                                        <option value="13">Rút lông loại đặc biệt (50g/hộp)</option>
                                        <option value="14">Tinh chế loại 1 (50g/hộp)</option>
                                        <option value="15">Hộp 5 vỉ (5 viên/vỉ)</option>
                                        <option value="16">Hộp 1 vỉ (5 viên/vỉ)</option>
                                        <option value="17">Hộp 10 gói</option>
                                        <option value="18">Hộp 30 gói</option>
                                        <option value="19">Loại thường (20 gói x 15g)</option>
                                        <option value="20">Vị sữa (20g x 18g)</option>
                                        <option value="21">Hộp 6 lọ + túi (70ml/lọ)</option>
                                        <option value="22">Hộp 1 lọ (70ml/lọ)</option>
                                        <option value="23">Hộp Ngũ Phúc Luxury - 5 quà tặng cao cấp</option>
                                      </select>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="add-product">
                                      <input type="number" class="form-control" value="1" min="1" placeholder="số lượng...">
                                    </div>
                                  </td>
                                  <td>
                                    <div class="add-product">
                                      <input type="number" class="form-control" value="" min="0" placeholder="nhập giá">
                                    </div>
                                  </td>
                                  <td class="action-table-data">
                                    <div class="edit-delete-action">
                                      <a class="p-2" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round" class="feather feather-trash-2">
                                          <polyline points="3 6 5 6 21 6"></polyline>
                                          <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                          </path>
                                          <line x1="10" y1="11" x2="10" y2="17"></line>
                                          <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                      </a>
                                    </div>

                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <button class="btn btn-primary mb-4 mt-2" type="button" id="add-bienthe">+ Thêm biến thể</button>
                      </div>
                    </div>
                  </div>
                </div>
                

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Ảnh sản phẩm<span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc"> *</span></label>
                    <div class="image-upload">
                      <input type="file" name="anhsanpham[]" multiple class="form-control" id="anhsanpham" />
                      <div class="image-uploads">
                        <img src="http://127.0.0.1:8000/img/icons/upload.svg" alt="img" />
                        <h4>Tải lên file ảnh tại đây.</h4>
                      </div>
                      <!-- <div id="preview-anh" class="mt-2 d-flex flex-wrap"></div> -->


                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="product-list">
                    <ul class="row" id="preview-anh">
                      <!-- <li>
                                <div class="productviews">
                                  <div class="productviewsimg">
                                    <img src="assets/img/icons/macbook.svg" alt="img" />
                                  </div>
                                  <div class="productviewscontent">
                                    <div class="productviewsname">
                                      <h2>macbookpro.jpg</h2>
                                      <h3>581kb</h3>
                                    </div>
                                    <a href="javascript:void(0);" class="hideset">x</a>
                                  </div>
                                </div>
                              </li> -->
                    </ul>
                  </div>
                </div>

                <div class="col-lg-12">
                  <button type="submit" class="btn btn-submit me-2" title="Tạo sản phẩm">Tạo sản phẩm</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card">
            <div class="card-body">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>Ảnh sản phẩm<span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Bắt buộc"> *</span></label>
                  <div class="image-upload">
                    <input type="file" name="anhsanpham[]" multiple class="form-control" id="anhsanpham" />
                    <div class="image-uploads">
                      <img src="http://127.0.0.1:8000/img/icons/upload.svg" alt="img" />
                      <h4>Tải lên file ảnh tại đây.</h4>
                    </div>
                    <!-- <div id="preview-anh" class="mt-2 d-flex flex-wrap"></div> -->


                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="product-list">
                  <ul class="row" id="preview-anh">
                    <!-- <li>
                                <div class="productviews">
                                  <div class="productviewsimg">
                                    <img src="assets/img/icons/macbook.svg" alt="img" />
                                  </div>
                                  <div class="productviewscontent">
                                    <div class="productviewsname">
                                      <h2>macbookpro.jpg</h2>
                                      <h3>581kb</h3>
                                    </div>
                                    <a href="javascript:void(0);" class="hideset">x</a>
                                  </div>
                                </div>
                              </li> -->
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <form class="row" action="#" method="POST">
                @csrf
                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Danh mục <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <select class="form-control select" name="id_danhmuc[]" id="id_danhmuc" multiple>
                      <option value="1">
                        Sức khỏe
                      </option>
                      <option value="2">
                        Thực phẩm chức năng
                      </option>
                      <option value="3">
                        Chăm sóc cá nhân
                      </option>
                      <option value="4">
                        Làm đẹp
                      </option>
                      <option value="5">
                        Điện máy
                      </option>
                      <option value="6">
                        Thiết bị y tế
                      </option>
                      <option value="7">
                        Bách hoá
                      </option>
                      <option value="8">
                        Nội thất - Trang trí
                      </option>
                      <option value="9">
                        Mẹ &amp; bé
                      </option>
                      <option value="10">
                        Thời trang
                      </option>
                      <option value="11">
                        Thực phẩm - đồ ăn
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Thương hiệu <span class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Bắt buộc">*</span></label>
                    <select class="form-select" name="id_thuonghieu">
                      <option class="text-secondary">--Chọn thương hiệu--</option>
                      <option value="1">STV Trading</option>
                      <option value="2">C&#039;CHOI</option>
                      <option value="3">ACACI LABS</option>
                      <option value="4">GLOBAL (Yến Sào NEST100)</option>
                      <option value="5">CHẤT VIỆT GROUP</option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-12 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Video giới thiệu sản phẩm</label>
                    <input type="text" name="mediaurl" placeholder="Url Youtube..." />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('scripts')
  <script>
    /**
   * This configuration was generated using the CKEditor 5 Builder. You can modify it anytime using this link:
   * https://ckeditor.com/ckeditor-5/builder/?redirect=portal#installation/NoNgNARATAdA7DKFIhATgIwBY0gKwZxwAccaZW6xIWeeUAzFgAzEFZT4jIQBuAlsmZhgGMMOFjJAXUhYAZgEM089BGlA
   */

    ClassicEditor.create(document.querySelector('#mo_ta'), editorConfig);

  </script>
  <script>
    $('.loai_bienthe').select2({
      tags: true,   // Cho phép nhập thêm
      placeholder: "Chọn hoặc nhập tên loại biến thể",
    });
  </script>

@endsection