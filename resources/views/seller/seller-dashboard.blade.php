@extends('seller.layout.app')

@section('title', 'Dashboard Seller | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Chào mừng {{ $nguoiDung->hoten }}!</h4>
                            <p class="card-text">Bạn đang đăng nhập với vai trò <strong>Người bán hàng</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash1.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $thongKe['total_revenue'] }}">{{ number_format($thongKe['total_revenue']) }}</span> VNĐ</h5>
                            <h6>Doanh Thu Của Tôi</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash1">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash2.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $thongKe['my_products'] }}">{{ $thongKe['my_products'] }}</span></h5>
                            <h6>Sản Phẩm Của Tôi</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash2">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash3.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $thongKe['my_orders'] }}">{{ $thongKe['my_orders'] }}</span></h5>
                            <h6>Đơn Hàng Của Tôi</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash3">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash4.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $thongKe['pending_orders'] }}">{{ $thongKe['pending_orders'] }}</span></h5>
                            <h6>Đơn Chờ Xử Lý</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Thao tác nhanh</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    <a href="{{ route('quan-tri-vien.san-pham-nguoi-ban-hang.taosanpham') }}" class="btn btn-primary w-100">
                                        <i class="fa fa-plus me-2"></i>Thêm sản phẩm
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    <a href="{{ route('quan-tri-vien.san-pham-nguoi-ban-hang.sanpham') }}" class="btn btn-success w-100">
                                        <i class="fa fa-box me-2"></i>Quản lý sản phẩm
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    {{-- <a href="{{ route('admin.donhang.index') }}" class="btn btn-info w-100"> --}}
                                        <i class="fa fa-shopping-cart me-2"></i>Đơn hàng của tôi
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    {{-- <a href="{{ route('admin.cuahang.show', $nguoiDung->id) }}" class="btn btn-warning w-100"> --}}
                                        <i class="fa fa-store me-2"></i>Cửa hàng của tôi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Products Overview -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Sản phẩm của tôi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php

                                            $myProducts = \App\Models\SanphamModel::whereHas('cuahang', function ($query) use ($nguoiDung) {
                                                $query->where('cuahang.id', $nguoiDung->id);
                                            })->limit(5)->get();
                                        @endphp
                                        @forelse($myProducts as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $product->tensanpham }}</td>
                                            <td>{{ number_format($product->gia) }} VNĐ</td>
                                            <td>{{ $product->soluong }}</td>
                                            <td>
                                                @if($product->trangthai)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Tạm dừng</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <a href="{{ route('admin.sanpham.suasanpham', $product->id) }}" class="btn btn-sm btn-warning"> --}}
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có sản phẩm nào</td>
                                        </tr>
                                        @endforelse
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
