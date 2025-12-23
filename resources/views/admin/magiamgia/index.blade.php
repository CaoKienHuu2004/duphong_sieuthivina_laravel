@extends('admin.layouts.app')

@section('title', 'Danh sách mã giảm giá | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách mã giảm giá đơn hàng</h4>
                    <h6>Quản lý mã giảm giá đơn hàng của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('quan-tri-vien.tao-ma-giam-gia') }}" class="btn btn-added"><img
                            src="{{asset('assets/admin')}}/img/icons/plus.svg" alt="img" class="me-1" />Thêm mã giảm giá</a>
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
                                    <th class="text-start">Mã giảm giá</th>
                                    <th class="text-start">Mô tả</th>
                                    <th class="text-center">Điều kiện tối thiểu</th>
                                    <th class="text-center">Giá trị giảm</th>
                                    <th class="text-center">Thời gian giảm giá</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($coupons as $cp)
                                    <tr>
                                        <td>
                                            <div>
                                                <!-- <span style="font-size: 12px;">CHẤT VIỆT GROUP</span> -->
                                                <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ $cp->magiamgia }}">{{ $cp->magiamgia }}</a>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="text-start" style="font-size: 14px; width: 340px; white-space: break-spaces; overflow: hidden; text-overflow: ellipsis;">{{ $cp->mota }}</td>
                                        <td class="text-center">> {{ number_format($cp->dieukien, 0, ',', '.') }} đ</td>
                                        <td class="text-center">- {{ number_format($cp->giatri, 0, ',', '.') }} đ</td>
                                        <td class="text-center">
                                            {{ date('d/m/Y', strtotime($cp->ngaybatdau)) }} - 
                                            {{ date('d/m/Y', strtotime($cp->ngayketthuc)) }}
                                        </td>
                                        <td class="text-center">
                                            @if($cp->trangthai == 'Hoạt động')
                                            <span class="badges bg-lightgreen">Hoạt động</span>
                                            @else
                                            <span class="badges bg-lightred">Tạm khóa</span>
                                            @endif
                                        </td>
                                        <!-- <td class="text-center"><span class="badges bg-lightred">Tạm ẩn</span></td> -->
                                        <td>
                                            <a class="me-3" href="{{ route('quan-tri-vien.chinh-sua-thuong-hieu', $cp->id) }}">
                                                <img src="{{asset('assets/admin')}}/img/icons/edit.svg" alt="img" />
                                            </a>
                                            <a href="{{ route('quan-tri-vien.xoa-thuong-hieu', $cp->id) }}">
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