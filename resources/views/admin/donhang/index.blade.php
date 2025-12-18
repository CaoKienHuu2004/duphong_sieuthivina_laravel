@extends('admin.layouts.app')

@section('title')
    Hệ thống quản trị Siêu Thị Vina
@endsection

@section('content')
    <div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Danh sách đơn hàng của bạn <span
                class="bg-danger text-white text-center rounded-circle blinking-flash px-2 py-1"
                style="font-size: 13px;">!</span></h4>
            <h6>Những đơn hàng có ở trên hệ thống của bạn</h6>
          </div>
        </div>

        <div class="card comp-section">
          <div class="card-body">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" href="#solid-tab1" data-bs-toggle="tab">Chờ xác nhận
                  <span class="bg-danger text-white px-2 py-1 rounded-circle blinking-flash">{{ $donhangs->where('trangthai','Chờ xác nhận')->count() }}</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab2" data-bs-toggle="tab">Đang xử lý (4)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab3" data-bs-toggle="tab">Đang giao hàng (4)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab4" data-bs-toggle="tab">Đã giao hàng (4)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab5" data-bs-toggle="tab">Đã hoàn thành (4)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#solid-tab6" data-bs-toggle="tab">Đơn đã bị hủy (4)</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="solid-tab1 tab-pane show active" id="solid-tab1">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="sales-details.html">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightyellow">Chờ xác
                            nhận</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="check-circle" class="text-success" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Xác nhận đơn hàng"></i>
                          </a>
                          <a class="confirm-text" href="javascript:void(0);">
                            <i data-feather="x-circle" class="text-danger" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Từ chối và hủy đơn"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>

                        <td class="text-center"><span class="badges bg-lightyellow">Chờ xác nhận</span></td>
                        <td class="text-center"><span class="badges bg-lightpurple">Chưa thanh
                            toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="check-circle" class="text-success" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Xác nhận thanh toán và tiến hành thanh toán"></i>
                          </a>
                          <a class="confirm-text" href="javascript:void(0);">
                            <i data-feather="x-circle" class="text-danger" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Từ chối và hủy đơn"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab2 tab-pane" id="solid-tab2">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightblue">Chờ đóng gói</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="truck" class="text-success" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Tiến hành giao hàng"></i>
                          </a>
                          <a class="confirm-text" href="javascript:void(0);">
                            <i data-feather="x-circle" class="text-danger" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Từ chối và hủy đơn"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;"> 801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightblue">Chờ đóng gói</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="truck" class="text-success" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Tiến hành giao hàng"></i>
                          </a>
                          <a class="confirm-text" href="javascript:void(0);">
                            <i data-feather="x-circle" class="text-danger" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Từ chối và hủy đơn"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab3 tab-pane" id="solid-tab3">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightblue">Đang giao hàng</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="user-check" class="text-success" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Hoàn thành đơn hàng (giao thành công)"></i>
                          </a>
                          <a class="confirm-text" href="javascript:void(0);">
                            <i data-feather="x-circle" class="text-danger" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Từ chối và hủy đơn"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightblue">Đang giao hàng</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="user-check" class="text-success" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Hoàn thành đơn hàng (giao thành công)"></i>
                          </a>
                          <a class="confirm-text" href="javascript:void(0);">
                            <i data-feather="x-circle" class="text-danger" data-bs-toggle="tooltip"
                              data-bs-placement="top" title="Từ chối và hủy đơn"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab4 tab-pane" id="solid-tab4">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã giao hàng</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-black" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã giao hàng</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-black" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab5 tab-pane" id="solid-tab5">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã giao hàng</span></td>
                        <td class="text-center"><span class="badges bg-lightgreen">Đã thanh toán</span></td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="solid-tab6 tab-pane" id="solid-tab6">
                <div class="row d-flex justify-content-between mb-3 align-items-center">
                  <div class="col-lg-2 form-group m-0">
                    <input type="text" class="form-control search-pane" placeholder="tìm kiếm....">
                  </div>
                  <form action="#" method="get" class="col-lg-3 m-0 form-group d-flex align-items-center justify-content-end">
                    <select class="select" name="trangthaithanhtoan" id="" onchange="this.form.submit()">
                      <option value="" selected disabled>--Trạng thái thanh toán--</option>
                      <option value="Chưa thanh toán">Chưa thanh toán</option>
                      <option value="Đã thanh toán">Đã thanh toán</option>
                    </select>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table datanew">
                    <!-- có thể thêm datanew sau class table -->
                    <thead>
                      <tr>
                        <th class="text-start">Mã đơn</th>
                        <th class="text-start" style="width: 20px !important;">Địa chỉ giao
                          hàng</th>
                        <th class="text-start">Tổng cộng</th>
                        <th class="text-start">Ngày đặt hàng</th>
                        <th class="text-center">Trạng thái đơn hàng</th>
                        <th class="text-center">Trạng thái thanh toán</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightred ">Đã hủy</span></td>
                        <td class="text-center fw-bold">-</td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-start">
                          <a class="fw-bold" href="javascript:void(0);">#STV25120944</a>
                        </td>
                        <td class="text-start">
                          <p class="fw-bold text-black m-0" style="font-size: 14px;">Trần Bá Hộ</p>
                          <div class="text-black" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">801/2A Phạm Thế Hiển, Phường 4, Quận 8, Thành phố Hồ Chí Minh</div>
                        </td>
                        <td class="text-start text-black fw-bold"><span class="text-danger">300.000 đ</span></td>
                        <td class="text-start text-black" style="width: 50px;">
                          09/12/2025 - 16:59
                        </td>
                        <td class="text-center"><span class="badges bg-lightred">Đã hủy</span></td>
                        <td class="text-center fw-bold">-</td>
                        <td class="text-center">
                          <a class="me-3" href="editproduct.html">
                            <i data-feather="eye" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                              title="Xem chi tiết đơn hàng"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
<style>
    .dt-buttons {
        display: none !important;
    }
</style>
@endsection