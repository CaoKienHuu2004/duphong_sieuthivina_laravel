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
            <a href="{{ route('quan-tri-vien.tao-banner-quang-cao') }}" class="btn btn-added"><img src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img"
                class="me-1" />Thêm banner quảng cáo</a>
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
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
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
                    <th class="text-start">Vị trí</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($banners as $banner)
                        <tr class="text-start">
                            <td class="productimgname align-items-center w-100">
                            <a href="#" class="product-img">
                                <img src="{{ asset('assets/client') }}/images/bg/{{ $banner->hinhanh }}" alt="{{ $banner->hinhanh }}" style="object-fit: cover; width: 170px; max-width: 300px; height: 100%;" />
                            </a>
                            
                            </td>
                            <td class="text-start">
                                <div style="font-size: 14px; width: 280px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $banner->mota }}</div>
                            </td>
                            <td class="text-start"><a href="{{ $banner->lienket }}" style="font-size: 14px; width: 280px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $banner->lienket }}</a></td>
                            <td class="text-start">{{ $banner->vitri }}</td>
                            @if ($banner->trangthai == 'Hiển thị')
                            <td class="text-center"><span class="badges bg-lightgreen">{{ $banner->trangthai }}</span></td>
                            @else
                            <td class="text-center"><span class="badges bg-lightred">{{ $banner->trangthai }}</span></td>
                            @endif
                            <!-- <td class="text-center"><span class="badges bg-lightred">Tạm ẩn</span></td> -->
                            <td>
                            <a class="me-3" href="{{ route('quan-tri-vien.chinh-sua-banner-quang-cao',$banner->id) }}">
                                <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                            </a>
                            <a href="{{ route('quan-tri-vien.xoa-banner-quang-cao',$banner->id) }}">
                                <img src="{{asset('assets/admin')}}/img/icons/delete.svg" alt="img" />
                            </a>
                            </td>
                        </tr>
                    @empty
                        
                    @endforelse
                  
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