@extends('admin.layouts.app')

@section('title')
    Hệ thống quản trị Siêu Thị Vina
@endsection

@section('content')
    <div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Danh sách banner quảng cáo</h4>
            <h6>Quản lý banner quảng cáo của bạn</h6>
          </div>
          <div class="page-btn">
            <a href="addbanner.html" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img"
                class="me-1" />Thêm banner quảng cáo</a>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="table-top">
              <div class="search-set">
                <div class="search-path">
                </div>
                <div class="search-input">
                  <a class="btn btn-searchset"><img src="{{asset('assets/admin')}}/img/icons/search-white.svg" alt="img" /></a>
                </div>
              </div>
              <div class="wordset">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table dataold">
                <!-- có thể thêm dataold sau class table -->
                <thead>
                  <tr>
                    <th class="text-start">Banner quảng cáo</th>
                    <th class="text-start">Mô tả</th>
                    <th class="text-start">Liên kết</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="productimgname align-items-center w-100">
                      <a href="https://sieuthivina.com/qua-tang" class="product-img">
                        <img src="https://sieuthivina.com/assets/client/images/bg/banner4cai_chatviet.png" alt="product" style="object-fit: cover; width:220px; height: 100%;" />
                      </a>
                      
                    </td>
                    <td class="text-start">
                        <div style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">Đây là mô tả banner quảng cáo bao gồm giới thiệu công ty, chuyên mục bán hàng và uy tính từ thương hiệu, cần phải hiển thị ngắn gọn nhưng phải chắc chắn</div>
                    </td>
                    <td class="text-start"><a href="https://sieuthivina.com/qua-tang">https://sieuthivina.com/qua-tang</a></td>
                    <td class="text-center"><span class="badges bg-lightgreen">Công khai</span></td>
                    <!-- <td class="text-center"><span class="badges bg-lightred">Tạm ẩn</span></td> -->
                    <td>
                      <a class="me-3" href="editbanner.html">
                        <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                      </a>
                      <a class="confirm-text" href="javascript:void(0);">
                        <img src="{{asset('assets/admin')}}/img/icons/delete.svg" alt="img" />
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td class="productimgname align-items-center w-100">
                      <a href="https://sieuthivina.com/qua-tang" class="product-img">
                        <img src="https://sieuthivina.com/assets/client/images/bg/qua-tang-05.jpg" alt="product" style="object-fit: cover; width:220px; height: 100%;" />
                      </a>
                      
                    </td>
                    <td class="text-start">
                        <div style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">Đây là mô tả banner quảng cáo bao gồm giới thiệu công ty, chuyên mục bán hàng và uy tính từ thương hiệu, cần phải hiển thị ngắn gọn nhưng phải chắc chắn</div>
                    </td>
                    <td class="text-start"><a href="https://sieuthivina.com/qua-tang">https://sieuthivina.com/qua-tang</a></td>
                    <td class="text-center"><span class="badges bg-lightgreen">Công khai</span></td>
                    <!-- <td class="text-center"><span class="badges bg-lightred">Tạm ẩn</span></td> -->
                    <td>
                      <a class="me-3" href="editbanner.html">
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