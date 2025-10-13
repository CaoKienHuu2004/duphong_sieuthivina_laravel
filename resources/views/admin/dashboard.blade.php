@extends('admin.layout.app')

@section('title', 'Dashboard Admin | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Chào mừng {{ $user->hoten }}!</h4>
                            <p class="card-text">Bạn đang đăng nhập với vai trò <strong>Quản trị viên</strong></p>
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
                            <h5><span class="counters" data-count="{{ $stats['total_revenue'] }}">{{ number_format($stats['total_revenue']) }}</span> VNĐ</h5>
                            <h6>Tổng Doanh Thu</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash1">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash2.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $stats['total_users'] }}">{{ $stats['total_users'] }}</span></h5>
                            <h6>Tổng Người Dùng</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash2">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash3.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $stats['total_products'] }}">{{ $stats['total_products'] }}</span></h5>
                            <h6>Tổng Sản Phẩm</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash3">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('')}}img/icons/dash4.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><span class="counters" data-count="{{ $stats['total_orders'] }}">{{ $stats['total_orders'] }}</span></h5>
                            <h6>Tổng Đơn Hàng</h6>
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
                                    <a href="{{ route('admin.sanpham.index') }}" class="btn btn-primary w-100">
                                        <i class="fa fa-box me-2"></i>Quản lý sản phẩm
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    <a href="{{ route('admin.donhang.index') }}" class="btn btn-success w-100">
                                        <i class="fa fa-shopping-cart me-2"></i>Quản lý đơn hàng
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    <a href="{{ route('admin.khachhang.index') }}" class="btn btn-info w-100">
                                        <i class="fa fa-users me-2"></i>Quản lý khách hàng
                                    </a>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                    <a href="{{ route('admin.cuahang.index') }}" class="btn btn-warning w-100">
                                        <i class="fa fa-store me-2"></i>Quản lý cửa hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Hoạt động gần đây</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Hoạt động</th>
                                            <th>Người thực hiện</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ now()->format('d/m/Y H:i') }}</td>
                                            <td>Đăng nhập hệ thống</td>
                                            <td>{{ $user->hoten }}</td>
                                            <td><span class="badge bg-success">Thành công</span></td>
                                        </tr>
                                        <!-- Có thể thêm các hoạt động khác từ database -->
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
