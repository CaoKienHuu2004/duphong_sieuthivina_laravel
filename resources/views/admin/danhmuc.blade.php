@extends('admin.layouts.app')

@section('title', 'Danh sách danh mục | Quản trị hệ thống Siêu Thị Vina')

@section('content')
<div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Danh sách danh mục sản phẩm</h4>
            <h6>Quản lý danh mục sản phẩm của bạn</h6>
          </div>
          <div class="page-btn">
            <a href="{{route('quan-tri-vien.tao-danh-muc')}}" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img"
                class="me-1" />Thêm danh mục</a>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="table-top">
              <div class="search-set">
                <div class="search-path">
                  <!-- <a class="btn btn-filter" id="filter_search">
                    <img src="{{asset('assets/admin')}}/img/icons/filter.svg" alt="img" />
                    <span><img src="{{asset('assets/admin')}}/img/icons/closes.svg" alt="img" /></span>
                  </a> -->
                </div>
                <div class="search-input">
                  <a class="btn btn-searchset"><img src="{{asset('assets/admin')}}/img/icons/search-white.svg" alt="img" /></a>
                </div>
              </div>
              <div class="wordset">
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
              <table class="table dataold">
                <!-- có thể thêm dataold sau class table -->
                <thead>
                  <tr>
                    <th class="text-start">Tên danh mục</th>
                    <th class="text-start">Slug</th>
                    <th class="text-center">Số sản phẩm</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($danhmuc as $dm)
                        <tr>
                    <td class="productimgname align-items-center w-100">
                      <a href="javascript:void(0);" class="product-img">
                        <img src="{{asset('assets/client')}}/images/categories/{{ $dm->logo }}" alt="{{ $dm->ten }}" style="object-fit: cover;" />
                      </a>
                      <div>
                        <!-- <span style="font-size: 12px;">CHẤT VIỆT GROUP</span> -->
                        <p style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                          <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $dm->ten }}">{{ $dm->ten }}</a>
                        </p>
                      </div>
                      
                    </td>
                    <td class="text-start">{{ $dm->slug }}</td>
                    <td class="text-center">{{ $dm->sanpham_count }}</td>
                    <td class="text-center"><span class="badges bg-lightgreen">Công khai</span></td>
                    <!-- <td class="text-center"><span class="badges bg-lightred">Tạm ẩn</span></td> -->
                    <td>
                      <a class="me-3" href="editcategory.html">
                        <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                      </a>
                      <a href="{{ route('quan-tri-vien.xoa-danh-muc',$dm->id) }}">
                        <img src="{{asset('assets/admin')}}/img/icons/delete.svg" alt="img" />
                      </a>
                    </td>
                  </tr>
                    @endforeach
                  
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