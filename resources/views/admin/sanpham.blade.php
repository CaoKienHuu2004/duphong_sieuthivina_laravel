@extends('admin.layouts.app')

@section('title', 'Danh sách sản phẩm | Quản trị hệ thống Siêu Thị Vina')

@section('content')
<div class="page-wrapper">
      <div class="content">
        <div class="page-header">
          <div class="page-title">
            <h4>Danh sách sản phẩm</h4>
            <h6>Quản lý sản phẩm của bạn</h6>
          </div>
          <div class="page-btn">
            <a href="{{ route('quan-tri-vien.tao-san-pham') }}" class="btn btn-added"><img src="{{ asset('assets/admin') }}/img/icons/plus.svg" alt="img"
                class="me-1" />Thêm sản phẩm</a>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-sm-6 col-12">
            <a href="#" class="dash-widget dash1">
              <div class="dash-widgetimg">
                <span><i data-feather="package" style="color: #1fb163;"></i></span>
              </div>
              <div class="dash-widgetcontent">
                <h5>
                  <span class="counters">{{ $sanphams->count() }}</span>
                </h5>
                <h6>Tổng số sản phẩm</h6>
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
                  <span class="counters">{{ $sanphams->where('trangthai', 'Công khai')->count() }}</span>
                </h5>
                <h6>Sản phẩm đang bán</h6>
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
                  <span class="counters">{{ $sanphams->where('trangthai', 'Tạm khóa')->count() }}</span>
                </h5>
                <h6>Sản phẩm tạm ngừng bán</h6>
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
                  <span class="counters">{{ $sanphams->flatMap->bienthe->where('soluong', 0)->count() }}</span>
                </h5>
                <h6>Loại sản phẩm hết hàng</h6>
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
                    <img src="{{ asset('assets/admin') }}/img/icons/filter.svg" alt="img" />
                    <span><img src="{{ asset('assets/admin') }}/img/icons/closes.svg" alt="img" /></span>
                  </a>
                </div>
                <div class="search-input">
                  <a class="btn btn-searchset"><img src="{{ asset('assets/admin') }}/img/icons/search-white.svg" alt="img" /></a>
                </div>
              </div>
              {{-- <div class="wordset">
                <ul>
                  <li>
                    <button id="export-pdf-button" class="bg-white border-0 p-0" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="pdf"><img src="{{ asset('assets/admin') }}/img/icons/pdf.svg" alt="img" /></button>
                  </li>
                  <li>
                    <button id="export-excel-button" class="bg-white border-0 p-0" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="excel"><img src="{{ asset('assets/admin') }}/img/icons/excel.svg" alt="img" /></button>
                  </li>
                  <li>
                    <button id="print-button" class="bg-white border-0 p-0" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="printer"><img src="{{ asset('assets/admin') }}/img/icons/printer.svg"
                        alt="img" /></button>
                  </li>
                </ul>
              </div> --}}
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

            <div class="card mb-0" id="filter_inputs">
              <div class="card-body pb-0">
                <div class="row">
                  <div class="col-lg-12 col-sm-12">
                    <div class="row">
                      <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                          <select class="select" name="trangthai">
                            <option disabled selected>-- Trạng thái sản phẩm
                              --</option>
                            <option value="Công khai" {{ request('trangthai') == 'Công khai' ? 'selected' : '' }}>Đang bán</option>
                            <option value="Tạm khóa" {{ request('trangthai') == 'Tạm khóa' ? 'selected' : '' }}>Tạm ngừng bán</option>
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
                          <a class="btn btn-filters ms-auto"><img src="{{ asset('assets/admin') }}/img/icons/search-whites.svg"
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
                <!-- có thể thêm datanew sau class table -->
                <thead>
                  <tr>
                    <th class="text-start">Tên sản phẩm</th>
                    <th class="text-start">Danh mục</th>
                    <th class="text-start">Giá bán</th>
                    <th class="text-center">Tổng số lượng</th>
                    <th class="text-center">Lượt mua</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sanphams as $sp)
                  <tr>
                    <td class="productimgname align-items-center w-100">
                      <a href="{{ route('quan-tri-vien.chi-tiet-san-pham', ['id' => $sp->id, 'slug' => Str::slug($sp->ten)]) }}" class="product-img">
                        <img src="{{ asset('assets/client') }}/images/thumbs/{{ $sp->hinhanhsanpham->first()->hinhanh }}" alt="{{ $sp->ten }}" style="object-fit: cover; width:60px; height: 100%;" />
                      </a>
                      <div>
                        <span style="font-size: 12px;">{{ $sp->thuonghieu->ten ?? 'Không có' }}</span>
                        <p style="width: 290px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                          <a class="text-black" href="{{ route('quan-tri-vien.chi-tiet-san-pham', ['id' => $sp->id, 'slug' => Str::slug($sp->ten)]) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $sp->ten }}">{{ $sp->ten }}</a>
                        </p>
                      </div>
                      
                    </td>
                    <td class="text-start" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><span title="{!! $sp->danhmuc->pluck('ten')->implode(', ') ?: 'Chưa có danh mục' !!}" data-bs-toggle="tooltip" data-bs-placement="top">{!! $sp->danhmuc->pluck('ten')->implode(', ') ?: 'Chưa có danh mục' !!}</span></td>
                    <td class="text-start">
                       @if($sp->bienthe->count())
                        @php
                        $giaMin = $sp->bienthe->min('giagoc');
                        $giaMax = $sp->bienthe->max('giagoc');
                        @endphp

                        {{ number_format($sp->bienthe->min('giagoc'), 0, ',', '.') }} đ
                        {{-- Chỉ hiển thị giá max nếu > giá min --}}
                        @if($giaMax > $giaMin)
                        ~ {{ number_format($giaMax, 0, ',', '.') }} đ
                        @endif
                        @else
                        Chưa có giá
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($sp->bienthe->sum('soluong'), 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($sp->bienthe->sum('luotban'), 0, ',', '.') }}</td>
                    <td class="text-center"><span class="badges @if($sp->trangthai === "Công khai") bg-lightgreen @else bg-lightred @endif">{{ $sp->trangthai }}</span></td>
                    <td>
                      <a class="me-3" href="{{ route('quan-tri-vien.chinh-sua-san-pham',$sp->id) }}">
                        <img src="{{ asset('assets/admin') }}/img/icons/edit.svg" alt="img" />
                      </a>
                      <a class="" href="{{route('quan-tri-vien.xoa-san-pham', $sp->id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                        <img src="{{ asset('assets/admin') }}/img/icons/delete.svg" alt="img" />
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
<script>
  document.getElementById('filterForm').addEventListener('submit', function(e) {
    this.querySelectorAll('input, select').forEach(function(el) {
      if (!el.value) {
        el.removeAttribute('name'); // xoá name để nó không lên URL
      }
    });
  });
</script>
@endsection
