@extends('admin.layouts.app')

@section('title', 'Danh sách thương hiệu | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách thương hiệu sản phẩm</h4>
                    <h6>Quản lý thương hiệu sản phẩm của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('quan-tri-vien.tao-thuong-hieu') }}" class="btn btn-added"><img
                            src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img" class="me-1" />Thêm thương hiệu</a>
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
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path"></div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/admin')}}/img/icons/search-white.svg"
                                        alt="img" /></a>
                            </div>
                        </div>
                        <div class="wordset"></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table dataold">
                            <!-- có thể thêm dataold sau class table -->
                            <thead>
                                <tr>
                                    <th class="text-start">Tên thương hiệu</th>
                                    <th class="text-start">Slug</th>
                                    <th class="text-center">Số sản phẩm</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($thuonghieu as $th)
                                    <tr>
                                        <td class="productimgname align-items-center w-100">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{asset('assets/client')}}/images/brands/{{ $th->logo }}"
                                                    alt="{{ $th->ten }}" style="object-fit: cover; width: 60px; height: 100%" />
                                            </a>
                                            <div>
                                                <!-- <span style="font-size: 12px;">CHẤT VIỆT GROUP</span> -->
                                                <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ $th->ten }}">{{ $th->ten }}</a>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="text-start">{{ $th->slug }}</td>
                                        <td class="text-center">
                                            <div style="font-size: 14px;">{{ $th->sanpham->count() }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badges bg-lightgreen">Công khai</span>
                                        </td>
                                        <!-- <td class="text-center"><span class="badges bg-lightred">Tạm ẩn</span></td> -->
                                        <td>
                                            <a class="me-3" href="{{ route('quan-tri-vien.chinh-sua-thuong-hieu', $th->id) }}">
                                                <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                                            </a>
                                            <a href="{{ route('quan-tri-vien.xoa-thuong-hieu', $th->id) }}">
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