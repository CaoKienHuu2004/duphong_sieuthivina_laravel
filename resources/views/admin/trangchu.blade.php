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
                                    <span class="counters">37.000.000 đ</span>
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
                                    <span class="counters">37.000.000</span> đ
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
                                    <span class="counters">254.000</span> đ
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
                                    <span class="counters">400.000</span> đ
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
                                <h4 class="card-title mb-0 d-flex gap-2 align-items-center">Đơn hàng mới <span
                                        class="bg-danger text-white text-center rounded-circle blinking-flash"
                                        style="font-size: 13px; width: 20px;">!</span></h4>

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
                                            <tr>
                                                <td class="text-start"><span class="fw-bold text-black"
                                                        style="font-size: 14px;">Cao Kiến Hựu</span>
                                                    <p><a href="productlist.html">#STV25120944</a></p>
                                                </td>
                                                <td>
                                                    09/12/2025 - 20:56
                                                </td>
                                                <td class="text-end">300.000 đ</td>
                                                <td class="text-end">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="clipboard" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-start"><span class="fw-bold text-black"
                                                        style="font-size: 14px;">Trần Bá Hộ</span>
                                                    <p><a href="productlist.html">#STV25120944</a></p>
                                                </td>
                                                <td>
                                                    09/12/2025 - 20:57
                                                </td>
                                                <td class="text-end">300.000 đ</td>
                                                <td class="text-end">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="clipboard" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-start"><span class="fw-bold text-black"
                                                        style="font-size: 14px;">Lê Quang Huy</span>
                                                    <p><a href="productlist.html">#STV25120944</a></p>
                                                </td>
                                                <td>
                                                    09/12/2025 - 20:58
                                                </td>
                                                <td class="text-end">300.000 đ</td>
                                                <td class="text-end">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="clipboard" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td class="productimgname text-start">
                                                    <a class="product-img" href="productlist.html">
                                                        <img style="object-fit: cover;"
                                                            src="{{asset('assets/admin')}}/img/icon_nguyenban.png" alt="product" />
                                                    </a>
                                                    <div>
                                                        <p><a class="fw-bold" href="productlist.html">tên sản phẩm</a>
                                                        </p>
                                                        tên biến thể
                                                    </div>

                                                </td>
                                                <td class="text-center">978</td>
                                                <td class="text-center">20.000 đ</td>
                                                <td class="text-center">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="archive" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Bổ sung hàng"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="productimgname text-start">
                                                    <a class="product-img" href="productlist.html">
                                                        <img style="object-fit: cover;"
                                                            src="{{asset('assets/admin')}}/img/icon_nguyenban.png" alt="product" />
                                                    </a>
                                                    <div>
                                                        <p><a class="fw-bold" href="productlist.html">tên sản phẩm</a>
                                                        </p>
                                                        tên biến thể
                                                    </div>

                                                </td>
                                                <td class="text-center">978</td>
                                                <td class="text-center">20.000 đ</td>
                                                <td class="text-center">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="archive" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Bổ sung hàng"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td class="productimgname text-start">
                                                    <a class="product-img" href="productlist.html">
                                                        <img style="object-fit: cover;"
                                                            src="{{asset('assets/admin')}}/img/icon_nguyenban.png" alt="product" />
                                                    </a>
                                                    <div>
                                                        <p><a class="fw-bold" href="productlist.html">tên sản phẩm</a>
                                                        </p>
                                                        tên biến thể
                                                    </div>

                                                </td>
                                                <td class="text-center">978</td>
                                                <td class="text-center">20.000 đ</td>
                                                <td class="text-center">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="eye" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="productimgname text-start">
                                                    <a class="product-img" href="productlist.html">
                                                        <img style="object-fit: cover;"
                                                            src="{{asset('assets/admin')}}/img/icon_nguyenban.png" alt="product" />
                                                    </a>
                                                    <div>
                                                        <p><a class="fw-bold" href="productlist.html">tên sản phẩm</a>
                                                        </p>
                                                        tên biến thể
                                                    </div>

                                                </td>
                                                <td class="text-center">978</td>
                                                <td class="text-center">20.000 đ</td>
                                                <td class="text-center">
                                                    <a href="editsupplier.html">
                                                        <i data-feather="eye" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xem chi tiết"
                                                            style="color:#ea5454;"></i>
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
            </div>
        </div>
@endsection
@section('scripts')
    <script>
        if ($("#sales_charts1").length > 0) {
            // ----------------------------------------------------
            // BƯỚC 1: TẠO DANH SÁCH 7 NGÀY ĐỘNG (7 NGÀY TRƯỚC VÀ HÔM NAY)
            // ----------------------------------------------------

            const today = new Date();
            const sevenDayCategories = [];

            // Lặp để lấy 7 ngày, bắt đầu từ (Hôm nay - 6 ngày) đến (Hôm nay)
            // i sẽ chạy từ -6 đến 0
            for (let i = -6; i <= 0; i++) {
                // Tạo một đối tượng Date mới từ ngày gốc
                const date = new Date(today);

                // Thiết lập ngày (cộng/trừ i ngày)
                // i = -6 là ngày sớm nhất, i = 0 là ngày hôm nay
                date.setDate(today.getDate() + i);

                // Định dạng ngày thành "DD/MM"
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');

                const formattedDate = `${day}/${month}`;
                sevenDayCategories.push(formattedDate);
            }

            // ----------------------------------------------------
            // BƯỚC 2: KHỞI TẠO BIỂU ĐỒ VỚI DANH SÁCH MỚI
            // ----------------------------------------------------

            var options = {
                series: [
                    // Đảm bảo data của bạn có 7 giá trị, với giá trị cuối cùng là của ngày hôm nay
                    { name: "Doanh thu", data: [10, 45, 60, 70, 50, 45, 60] },
                ],
                colors: ["#28C76F"],
                chart: {
                    type: "bar",
                    height: 300,
                    stacked: true,
                    zoom: { enabled: true },
                },
                responsive: [
                    {
                        breakpoint: 280,
                        options: { legend: { position: "bottom", offsetY: 0 } },
                    },
                ],
                plotOptions: {
                    bar: { horizontal: false, columnWidth: "50%" },
                },
                xaxis: {
                    // SỬ DỤNG MẢNG CATEGORIES 7 NGÀY TRƯỚC
                    categories: sevenDayCategories,
                },
                legend: { position: "right", offsetY: 40 },
                fill: { opacity: 1 },
            };

            var chart = new ApexCharts(
                document.querySelector("#sales_charts1"),
                options
            );
            chart.render();
        }

        if ($("#sales_charts2").length > 0) {

            // Mảng tên tháng tiếng Việt
            const monthNames = [
                "Thg 1", "Thg 2", "Thg 3", "Thg 4", "Thg 5", "Thg 6",
                "Thg 7", "Thg 8", "Thg 9", "Thg 10", "Thg 11", "Thg 12"
            ];

            // ----------------------------------------------------
            // BƯỚC 1: TẠO DANH SÁCH 4 TUẦN GẦN NHẤT
            //         VÀ GÁN TÊN THÁNG TƯƠNG ỨNG
            // ----------------------------------------------------

            const today = new Date();
            const fourWeekCategories = [];

            // Lặp để lấy 4 tuần, bắt đầu từ (Tuần hiện tại - 3) đến (Tuần hiện tại)
            // i sẽ chạy từ -3 đến 0 (4 items)
            for (let i = -3; i <= 0; i++) {
                const date = new Date(today);

                // Di chuyển đến một ngày trong tuần cần tính (ví dụ: ngày cuối tuần đó)
                date.setDate(today.getDate() + (i * 7));

                // Lấy tên tháng
                const monthIndex = date.getMonth();
                const monthName = monthNames[monthIndex];

                // Lấy ngày trong tháng để làm rõ hơn (ví dụ: 01 Thg 12)
                const day = date.getDate().toString().padStart(2, '0');

                // Định dạng thành "Ngày/Tháng" hoặc "Tuần x" tùy theo nhu cầu trực quan
                // Tôi chọn hiển thị ngày và tháng để biết tuần đó thuộc tháng nào
                const formattedLabel = `${day} ${monthName}`;

                fourWeekCategories.push(formattedLabel);
            }

            // ----------------------------------------------------
            // BƯỚC 2: KHỞI TẠO BIỂU ĐỒ VỚI DANH SÁCH NGÀY/THÁNG MỚI
            // ----------------------------------------------------

            var options = {
                series: [
                    // Cần có 4 giá trị data để khớp với 4 categories
                    { name: "Doanh thu", data: [50, 5, 10, 20] },
                ],
                colors: ["#28C76F"],
                chart: {
                    type: "bar",
                    height: 300,
                    stacked: true,
                    zoom: { enabled: true },
                },
                responsive: [
                    {
                        breakpoint: 280,
                        options: { legend: { position: "bottom", offsetY: 0 } },
                    },
                ],
                plotOptions: {
                    bar: { horizontal: false, columnWidth: "50%" },
                },
                xaxis: {
                    // SỬ DỤNG MẢNG CATEGORIES MỚI (4 TUẦN, GHI TÊN THÁNG)
                    categories: fourWeekCategories,
                    // title: { text: "4 Tuần Gần Nhất (Theo Ngày/Tháng)" }
                },
                legend: { position: "right", offsetY: 40 },
                fill: { opacity: 1 },
            };

            var chart = new ApexCharts(
                document.querySelector("#sales_charts2"),
                options
            );
            chart.render();
        }
        if ($("#sales_charts3").length > 0) {

            // Mảng tên 12 tháng
            const monthNames = [
                "Thg 1", "Thg 2", "Thg 3", "Thg 4", "Thg 5", "Thg 6",
                "Thg 7", "Thg 8", "Thg 9", "Thg 10", "Thg 11", "Thg 12"
            ];

            // ----------------------------------------------------
            // BƯỚC 1: TẠO DANH SÁCH CÁC THÁNG ĐÃ TRÔI QUA TRONG NĂM
            // ----------------------------------------------------

            // Lấy tháng hiện tại (0 = Tháng 1, 11 = Tháng 12)
            const currentMonthIndex = new Date().getMonth();

            // Lấy số lượng tháng đã trôi qua (ví dụ: nếu là tháng 1, length = 1; tháng 12, length = 12)
            const monthsPassed = currentMonthIndex + 1;

            // Cắt mảng tên tháng để chỉ hiển thị các tháng đã trôi qua
            const currentYearCategories = monthNames.slice(0, monthsPassed);

            // ----------------------------------------------------
            // BƯỚC 2: KHỞI TẠO BIỂU ĐỒ VỚI DANH SÁCH THÁNG MỚI
            // ----------------------------------------------------

            // LƯU Ý QUAN TRỌNG: Mảng data BẮT BUỘC phải có số lượng phần tử
            // BẰNG VỚI số lượng categories (monthsPassed)
            // Ví dụ, nếu hiện tại là tháng 1 (monthsPassed = 1), data chỉ cần 1 giá trị.
            var sampleData = [50, 45, 60, 70, 50, 45, 60, 70, 80, 75, 90, 100]; // 12 giá trị mẫu
            var dataForCurrentMonths = sampleData.slice(0, monthsPassed);


            var options = {
                series: [
                    {
                        name: "Doanh thu",
                        data: dataForCurrentMonths // Sử dụng mảng data đã được cắt
                    },
                ],
                colors: ["#28C76F"],
                chart: {
                    type: "bar",
                    height: 300,
                    stacked: true,
                    zoom: { enabled: true },
                },
                responsive: [
                    {
                        breakpoint: 280,
                        options: { legend: { position: "bottom", offsetY: 0 } },
                    },
                ],
                plotOptions: {
                    bar: { horizontal: false, columnWidth: "50%" },
                },
                xaxis: {
                    // SỬ DỤNG MẢNG CATEGORIES CÁC THÁNG ĐÃ TRÔI QUA
                    categories: currentYearCategories,
                    // title: { text: `Doanh thu năm ${new Date().getFullYear()}` }
                },
                legend: { position: "right", offsetY: 40 },
                fill: { opacity: 1 },
            };

            var chart = new ApexCharts(
                document.querySelector("#sales_charts3"),
                options
            );
            chart.render();
        }

    </script>
@endsection
