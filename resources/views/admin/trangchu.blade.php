@extends('admin.layouts.app')

@section('title', 'Trang chủ | Quản trị hệ thống Siêu Thị Vina')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash1">
                        <div class="dash-widgetimg">
                            <span><img src="{{asset('assets/admin')}}/img/icons/dash2.svg" alt="img" /></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>
                                <span class="counters">{{ number_format($tongDoanhThu, 0, ',', '.') }} đ</span>
                            </h5>
                            <h6>Tổng doanh thu</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget">
                        <div class="dash-widgetimg">
                            <span><i class="text-warning" data-feather="calendar"></i></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>
                                <span class="counters">{{ number_format($tongDoanhThuThang, 0, ',', '.') }} đ</span>
                            </h5>
                            <h6>Tổng doanh thu tháng này</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash2">
                        <div class="dash-widgetimg">
                            <span><i data-feather="file-text" style="color:#00d1e8;"></i></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>
                                <span class="counters">{{ number_format($tongDoanhThuTuan, 0, ',', '.') }} đ</span>
                            </h5>
                            <h6>Tổng doanh thu tuần này</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="dash-widget dash3">
                        <div class="dash-widgetimg">
                            <span><i data-feather="compass" style="color:#ea5454;"></i></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5>
                                <span class="counters">{{ number_format($tongDoanhThuNgay, 0, ',', '.') }} đ</span>
                            </h5>
                            <h6>Tổng doanh thu hôm nay</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7 col-sm-12 col-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Thống kê doanh thu</h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#basictab1" data-bs-toggle="tab">Trong tuần</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#basictab2" data-bs-toggle="tab">Trong tháng</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#basictab3" data-bs-toggle="tab">Trong năm</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="basictab1">
                                    <div id="sales_charts1"></div>
                                </div>
                                <div class="tab-pane" id="basictab2">
                                    <div id="sales_charts2"></div>
                                </div>
                                <div class="tab-pane" id="basictab3">
                                    <div id="sales_charts3"></div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

                <div class="col-lg-5 col-sm-12 col-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 d-flex gap-2 align-items-center">Đơn hàng mới
                                @if ($donHangsMoi->count() > 0)
                                    <span class="bg-danger text-white text-center rounded-circle blinking-flash"
                                        style="font-size: 13px; width: 20px;">!</span>
                                @endif
                            </h4>
                            <a href="{{ route('quan-tri-vien.danh-sach-don-hang') }}">Xem tất cả</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive dataview">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Thông tin</th>
                                            <th>Ngày đặt</th>
                                            <th class="text-end">Tổng giá trị</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donHangsMoi as $donhang)
                                            <tr>
                                                <td class="text-start"><span class="fw-bold text-black"
                                                        style="font-size: 14px;">{{ $donhang->nguoinhan }}</span>
                                                    <p><a href="productlist.html">#{{ $donhang->madon }}</a></p>
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y H:i', strtotime($donhang->created_at)) }}
                                                </td>
                                                <td class="text-end">{{ number_format($donhang->thanhtien, 0, ',', '.') }} đ
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('quan-tri-vien.chi-tiet-don-hang', $donhang->madon) }}">
                                                        <i data-feather="clipboard" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="text-center">Không còn đơn hàng nào chờ xác nhận !</div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12 d-flex">
                    <div class="card mb-0 w-100">
                        <div class="card-body">
                            <h4 class="card-title">Sản phẩm hết hàng</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-start">Tên sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-center">Giá bán</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sanPhamHetHang as $bt)
                                            <tr>
                                                <td class="productimgname text-start">
                                                    <a class="product-img" href="productlist.html">
                                                        @php
                                                            // Kiểm tra xem có sản phẩm cha không
                                                            $sanpham = $bt->sanpham; 
                                                            // Kiểm tra xem có ảnh không
                                                            $hinhAnh = ($sanpham && $sanpham->hinhanhsanpham && $sanpham->hinhanhsanpham->first()) 
                                                                ? $sanpham->hinhanhsanpham->first()->hinhanh 
                                                                : 'product-placeholder.png'; // Tên ảnh mặc định nếu không có ảnh
                                                        @endphp

                                                        <img style="object-fit: cover;"
                                                            src="{{ asset('assets/client/images/thumbs/' . $hinhAnh) }}"
                                                            alt="{{ $sanpham->ten ?? 'Sản phẩm lỗi' }}" />
                                                    </a>
                                                    <div>
                                                        <p style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            <a class="text-black fw-bold" href="{{ route('chi-tiet-san-pham',$bt->sanpham->slug) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ $bt->sanpham->ten }}">{{ $bt->sanpham->ten }}</a>
                                                            </p>
                                                        {{ $bt->loaibienthe->ten }}
                                                    </div>

                                                </td>
                                                <td class="text-center">{{ $bt->soluong }}</td>
                                                <td class="text-center">{{ number_format($bt->giagoc, 0, ',', '.') }} đ</td>
                                                <td class="text-center">
                                                    <a href="{{ route('chi-tiet-san-pham',$bt->sanpham->slug) }}">
                                                        <i data-feather="eye" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
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
                <div class="col-lg-6 col-sm-12 col-12 d-flex">
                    <div class="card mb-0 w-100">
                        <div class="card-body">
                            <h4 class="card-title">Sản phẩm tồn kho nhiều</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-start">Tên sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-center">Giá bán</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sanPhamTonKho as $bt)
                                            <tr>
                                                <td class="productimgname text-start">
                                                    <a class="product-img" href="productlist.html">
                                                        @php
                                                            // Kiểm tra xem có sản phẩm cha không
                                                            $sanpham = $bt->sanpham; 
                                                            // Kiểm tra xem có ảnh không
                                                            $hinhAnh = ($sanpham && $sanpham->hinhanhsanpham && $sanpham->hinhanhsanpham->first()) 
                                                                ? $sanpham->hinhanhsanpham->first()->hinhanh 
                                                                : 'product-placeholder.png'; // Tên ảnh mặc định nếu không có ảnh
                                                        @endphp

                                                        <img style="object-fit: cover;"
                                                            src="{{ asset('assets/client/images/thumbs/' . $hinhAnh) }}"
                                                            alt="{{ $sanpham->ten ?? 'Sản phẩm lỗi' }}" />
                                                    </a>
                                                    <div>
                                                        <p style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            <a class="text-black fw-bold" href="{{ route('chi-tiet-san-pham',$bt->sanpham->slug) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{ $bt->sanpham->ten }}">{{ $bt->sanpham->ten }}</a>
                                                            </p>
                                                        {{ $bt->loaibienthe->ten }}
                                                    </div>

                                                </td>
                                                <td class="text-center">{{ $bt->soluong }}</td>
                                                <td class="text-center">{{ number_format($bt->giagoc, 0, ',', '.') }} đ</td>
                                                <td class="text-center">
                                                        <a href="{{ route('chi-tiet-san-pham',$bt->sanpham->slug) }}">
                                                            <i data-feather="eye" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
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
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

            // Hàm format tiền Việt Nam (1.000.000 đ)
            const formatCurrency = (value) => {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
            };

            // Cấu hình chung cho cả 3 biểu đồ (DRY code)
            const commonOptions = {
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#28C76F'], // Màu xanh lá
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '55%',
                        distributed: false,
                    }
                },
                dataLabels: { enabled: false },
                legend: { show: false },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            // Rút gọn số hiển thị trên trục Y (ví dụ 1000k) cho đỡ rối nếu số quá lớn
                            if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                            if (value >= 1000) return (value / 1000).toFixed(0) + 'k';
                            return value;
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return formatCurrency(val);
                        }
                    }
                }
            };

            // Hàm gọi Ajax và vẽ biểu đồ
            function renderChart(elementId, type) {
                if ($(elementId).length > 0) {
                    $.ajax({
                        url: "{{ route('quan-tri-vien.thong-ke-doanh-thu') }}",
                        type: "GET",
                        data: { type: type },
                        success: function (res) {
                            var options = {
                                ...commonOptions,
                                series: res.series,
                                xaxis: {
                                    categories: res.categories
                                }
                            };
                            var chart = new ApexCharts(document.querySelector(elementId), options);
                            chart.render();
                        },
                        error: function (err) {
                            console.error("Lỗi load chart " + type, err);
                        }
                    });
                }
            }

            // === THỰC THI ===
            renderChart("#sales_charts1", "week");
            renderChart("#sales_charts2", "month");
            renderChart("#sales_charts3", "year");

        });
    </script>
@endsection