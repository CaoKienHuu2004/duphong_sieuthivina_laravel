@extends('admin.layouts.app')

@section('title')
    Hệ thống quản trị Siêu Thị Vina
@endsection

@section('content')
    <div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Danh sách quà tặng</h4>
            <h6>Quản lý quà tặng của bạn</h6>
          </div>
          <div class="page-btn">
            <a href="addproduct.html" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img"
                class="me-1" />Thêm quà tặng</a>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-sm-6 col-12">
            <a href="#" class="dash-widget dash1">
              <div class="dash-widgetimg">
                <span><i data-feather="gift" style="color: #1fb163;"></i></span>
              </div>
              <div class="dash-widgetcontent">
                <h5>
                  <span class="counters">{{ $quatangs->count() }}</span>
                </h5>
                <h6>Tổng số quà tặng</h6>
              </div>
            </a>
          </div>
          <div class="col-lg-3 col-sm-6 col-12">
            <a href="#" class="dash-widget dash2">
              <div class="dash-widgetimg">
                <span><i data-feather="share" style="color: #0093e8;"></i></span>
              </div>
              <div class="dash-widgetcontent">
                <h5>
                  <span class="counters">
                    {{ \App\Models\QuatangsukienModel::where('trangthai', 'Hiển thị')
                        ->whereNull('deleted_at')
                        ->where('ngaybatdau', '<=', now())
                        ->where('ngayketthuc', '>=', now())
                        ->whereHas('sanphamduoctang', function ($q) {
                            $q->where('luottang', '>', 0); // Sửa thành > 0 để đếm quà CÒN lượt
                        })
                        ->count() 
                    }}
                </span>
                </h5>
                <h6>Đang trưng bày</h6>
              </div>
            </a>
          </div>
          <div class="col-lg-3 col-sm-6 col-12">
            <a href="#" class="dash-widget dash3">
              <div class="dash-widgetimg">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-compass" style="color:#ea5454;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                  </svg></span>
              </div>
              <div class="dash-widgetcontent">
                <h5>
                  <span class="counters">
                        {{ \App\Models\QuatangsukienModel::where('trangthai', 'Hiển thị')
                            ->whereNull('deleted_at')
                            ->where('ngaybatdau', '<=', now())
                            ->where('ngayketthuc', '<=', now())
                            ->whereHas('sanphamduoctang', function ($q) {
                                $q->where('luottang', '>', 0); // Sửa thành > 0 để đếm quà CÒN lượt
                            })
                            ->count() 
                        }}
                    </span>
                </h5>
                <h6>Kết thúc thời gian khuyến mãi</h6>
              </div>
            </a>
          </div>
          <div class="col-lg-3 col-sm-6 col-12">
            <a href="#" class="dash-widget dash">
              <div class="dash-widgetimg">
                <span><i data-feather="alert-circle" style="color:#ff8f07;"></i></span>
              </div>
              <div class="dash-widgetcontent">
                <h5>
                  <span class="counters">
                    {{ \App\Models\QuatangsukienModel::where('trangthai', 'Hiển thị')
                        ->whereNull('deleted_at')
                        ->where('ngaybatdau', '<=', now())
                        ->where('ngayketthuc', '>=', now())
                        ->whereHas('sanphamduoctang', function ($q) {
                            $q->where('luottang', '=', 0);
                        })
                        ->count() 
                    }}
                </span>
                </h5>
                <h6>Đã hết quà tặng</h6>
              </div>
            </a>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="table-top">
              <div class="search-set">
                <div class="search-path">
                  <a class="btn btn-filter" id="filter_search">
                    <img src="{{asset('assets/admin')}}/img/icons/filter.svg" alt="img" />
                    <span><img src="{{asset('assets/admin')}}/img/icons/closes.svg" alt="img" /></span>
                  </a>
                </div>
                <div class="search-input">
                  <a class="btn btn-searchset"><img src="{{asset('assets/admin')}}/img/icons/search-white.svg" alt="img" /></a>
                </div>
              </div>
              <div class="wordset">
                <ul>
                  <li>
                    <button id="export-pdf-button" class="bg-white border-0 p-0" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="pdf"><img src="{{asset('assets/admin')}}/img/icons/pdf.svg" alt="img" /></button>
                  </li>
                  <li>
                    <button id="export-excel-button" class="bg-white border-0 p-0" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="excel"><img src="{{asset('assets/admin')}}/img/icons/excel.svg" alt="img" /></button>
                  </li>
                  <li>
                    <button id="print-button" class="bg-white border-0 p-0" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="printer"><img src="{{asset('assets/admin')}}/img/icons/printer.svg"
                        alt="img" /></button>
                  </li>
                </ul>
              </div>
            </div>

            <div class="card mb-0" id="filter_inputs">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-lg-12 col-sm-12">
                    <div class="row">
                      <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option disabled selected>-- Trạng thái sản phẩm
                              --</option>
                            <option value="Công khai">Đang bán</option>
                            <option value="Tạm khóa">Tạm ngừng bán</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select">
                            <option disabled selected>-- Trạng thái tồn kho
                              --</option>
                            <option>Còn hàng</option>
                            <option>Hết hàng</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-1 col-sm-6 col-12">
                        <div class="form-group">
                          <a class="btn btn-filters ms-auto"><img src="{{asset('assets/admin')}}/img/icons/search-whites.svg"
                              alt="img" /></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table datanew">
                <!-- có thể thêm datanew sau class table -->
                <thead>
                  <tr>
                    <th class="text-start">Tiêu đề</th>
                    <th class="text-start">Mô tả</th>
                    <th class="text-center">Thời gian quà tặng</th>
                    <th class="text-center">Lượt xem</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="productimgname align-items-center w-100">
                      <a href="javascript:void(0);" class="product-img">
                        <img src="{{asset('assets/client')}}/images/thumbs/tang-1-thuc-pham-bao-ve-suc-khoe-byealco-hop-1-vi-x-5-vien.jpg" alt="product" style="width: 80px; height: 80px; object-fit: cover;"/>
                      </a>
                      <div>
                        <span style="font-size: 12px;">CHẤT VIỆT GROUP</span>
                        <p style="width: 320px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                          <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Tặng 1 thực phẩm bảo vệ sức khỏe ByeAlco (Hộp 1 vỉ x 5 viên)">
                            Tặng 1 thực phẩm bảo vệ sức khỏe ByeAlco (Hộp 1 vỉ x 5 viên)
                          </a>
                        </p>
                      </div>
                      
                    </td>
                    <td class="text-start" style="font-size: 14px; width: 250px; white-space: normal; overflow: hidden; text-overflow: ellipsis;">
                        Mua 5 Thực phẩm bảo vệ sức khỏe ByeAlco (Hộp 1 vỉ x 5 viên)
                    </td>
                    <td class="text-center">
                        <span class="fw-bold">12/12/2025 - 05:00</span><br>
                        <span class="fw-bold">12/12/2025 - 23:59</span>
                    </td>
                    <td class="text-center">21</td>
                    <td class="text-center"><span class="badges bg-lightgreen">Công khai</span></td>
                    <td>
                      <a class="me-3" href="editproduct.html">
                        <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                      </a>
                      <a class="confirm-text" href="javascript:void(0);">
                        <img src="{{asset('assets/admin')}}/img/icons/delete.svg" alt="img" />
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
@endsection

@section('scripts')
<style>
    .dt-buttons {
        display: none !important;
    }
</style>
@endsection