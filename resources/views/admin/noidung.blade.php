@extends('admin.layouts.app')

@section('title', 'Danh sách trang nội dung | Quản trị hệ thống')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách trang nội dung</h4>
                    <h6>Quản lý các trang tĩnh (Giới thiệu, Chính sách, Điều khoản...)</h6>
                </div>
                {{-- ĐÃ BỎ NÚT THÊM MỚI THEO YÊU CẦU --}}
            </div>

            {{-- Thông báo --}}
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
                                <a class="btn btn-searchset">
                                    <img src="{{asset('assets/admin')}}/img/icons/search-white.svg" alt="img" />
                                </a>
                            </div>
                        </div>
                        <div class="wordset"></div>
                    </div>

                    <div class="table-responsive">
                        {{-- Class dataold giữ nguyên theo template của bạn --}}
                        <table class="table dataold">
                            <thead>
                                <tr>
                                    <th class="text-start">Tiêu đề trang</th>
                                    <th class="text-start">Slug (Đường dẫn)</th>
                                    <th class="text-center">Ngày cập nhật</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pages as $page)
                                    <tr>
                                        {{-- Cột Tiêu đề --}}
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="fw-bold text-dark">{{ $page->tieude }}</a>
                                        </td>

                                        {{-- Cột Slug --}}
                                        <td>
                                            <span class="text-muted">/{{ $page->slug }}</span>
                                        </td>

                                        {{-- Cột Ngày cập nhật (Timestamp) --}}
                                        <td class="text-center">
                                            {{ $page->updated_at ? $page->updated_at->format('d/m/Y H:i') : 'Chưa cập nhật' }}
                                        </td>

                                        {{-- Cột Trạng thái --}}
                                        <td class="text-center">
                                            @if($page->trangthai == 'Hiển thị')
                                                <span class="badges bg-lightgreen">Hiển thị</span>
                                            @else
                                                <span class="badges bg-lightred">Tạm ẩn</span>
                                            @endif
                                        </td>

                                        {{-- Cột Hành động (Chỉ có Sửa) --}}
                                        <td class="text-center">
                                            <a class="me-3" href="{{ route('quan-tri-vien.sua-trang-don', $page->id) }}" title="Sửa nội dung & Cập nhật trạng thái">
                                                <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                                            </a>
                                            {{-- ĐÃ BỎ NÚT XÓA THEO YÊU CẦU --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Chưa có trang nội dung nào.</td>
                                    </tr>
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