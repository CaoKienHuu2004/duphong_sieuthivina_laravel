@extends('client.layouts.app')

@section('title')
    Siêu Thị Vina -  Nền Tảng Bán Hàng Trực Tuyến Siêu Thị Vina
@endsection

@section('content')
    <div class="page">
    <section class="cart py-40">
        <div class="container container-lg">
            <div class="row gy-4">
                <div class="col-xl-9 col-lg-8">
                    <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0">
                        {{-- DIV CHỨA TOÀN BỘ BẢNG SẢN PHẨM & TỔNG SẢN PHẨM --}}
                        <div id="cart-items-main-container">
                            {{-- THAY THẾ DỮ LIỆU TĨNH BẰNG DỮ LIỆU ĐANG TẢI --}}
                            <div class="text-center p-5 mb-20" id="cart-loading-spinner">
                                <div class="spinner-border text-main-600" role="status"></div>
                                <p class="mt-2 text-gray-600">Đang tải giỏ hàng...</p>
                            </div>

                            <form action="" method="post" id="cart-update-form" class="d-none">
                                @csrf
                                <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                                    <table class="table style-three">
                                        <thead>
                                            <tr class="border-bottom border-gray-500 my-10 py-10">
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-24" colspan="2">
                                                    <div>
                                                        {{-- CẬP NHẬT SỐ LƯỢNG SP VÀO ĐÂY --}}
                                                        <i class="ph-bold ph-shopping-cart text-main-600 text-lg pe-6"></i> Giỏ hàng (<span id="total-product-count">0</span> sản phẩm )
                                                    </div>
                                                    
                                                </th>
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Số lượng</th>
                                                <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        {{-- THAY THẾ TOÀN BỘ NỘI DUNG <tbody> BẰNG DỮ LIỆU AJAX --}}
                                        <tbody id="cart-items-body">
                                            {{-- Dữ liệu sản phẩm sẽ được render tại đây --}}
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    {{-- BẢNG QUÀ TẶNG (TẠM THỜI GIỮ NGUYÊN TĨNH VÌ CHƯA CÓ DỮ LIỆU TỪ SERVICE) --}}
                    <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                        <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                            <table class="table style-three">
                                <thead>
                                    <tr class="border-bottom border-gray-500 my-10 py-10">
                                        <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-6" colspan="2">
                                            <i class="ph-bold ph-gift text-main-600 text-lg"></i> Quà tặng nhận được ( 1 sản phẩm )
                                        </th>
                                        <th class="px-60"></th>
                                        <th class="px-60"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td class="py-20 px-5">
                                            <div class="d-flex align-items-center gap-12">
                                                <a href="" class="border border-gray-100 rounded-8 flex-center" style="max-width: 100px; max-height: 100px; width: 100%; height: 100%">
                                                    <img src="{{asset('assets/client')}}/images/thumbs/ca-phe-bao-tu-linh-chi-pha-vach-giup-tinh-tao-1.webp" alt="" class="w-100 rounded-8">
                                                </a>
                                                <div class="table-product__content text-start">
                                                    <div class="flex-align gap-16">
                                                        <div class="flex-align gap-4 mb-5">
                                                            <span class="text-main-two-600 text-sm d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                            <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">CHẤT VIỆT GROUP</span>
                                                        </div>
                                                    </div>
                                                    <h6 class="title text-md fw-semibold mb-0">
                                                        <a href="#" class="link text-line-2" title="Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">Cà phê bào tử Linh Chi phá vách – Giúp tỉnh táo</a>
                                                    </h6>
                                                    <div class="flex-align gap-16 mb-6">
                                                        <a href="#" class="btn bg-gray-50 text-heading text-xs py-6 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                            Loại thường (20 gói x 15g)
                                                        </a>
                                                    </div>
                                                    <div class="product-card__price mb-6">
                                                        <div class="flex-align gap-4 text-main-two-600 text-xs">
                                                            <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through me-4">340.000 đ</span>
                                                            <a href="#" class="flex-align gap-4 text-main-two-600 text-xs"><i class="ph-fill ph-seal-percent text-sm"></i> Quà tặng miễn phí</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-20 px-5">
                                            <div class="d-flex rounded-4 overflow-hidden">
                                                <input type="text" class="quantity__input flex-grow-1 border border-start-0 border-end-0 text-center w-32 px-4 py-8 bg-gray-100" value="x 1" min="1" readonly>
                                            </div>
                                        </td>
                                        <td class="py-20 px-5">
                                            <span class="text-lg h6 mb-0 fw-semibold text-main-600">0 đ</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                {{-- CỘT BÊN PHẢI --}}
                <div class="col-xl-3 col-lg-4">
                    {{-- PHẦN VOUCHER --}}
                    <div class="cart-sidebar border border-gray-100 rounded-8 px-24 py-30 pb-20">
                        <h6 class="text-lg mb-20 flex-align gap-8"><i class="ph-bold ph-ticket text-main-600 text-xl"></i>Áp dụng Voucher</h6>
                        
                        {{-- HIỂN THỊ VOUCHER ĐÃ ÁP DỤNG HOẶC FORM --}}
                        <div id="voucher-status-container">
                            {{-- Sẽ được điền bằng JS --}}
                        </div>

                        <form action="" method="post" id="voucher-form">
                            @csrf
                            <div class="flex-align gap-16">
                                <input type="text" name="voucher_code" id="voucher_code_input" class="common-input p-10 flex-grow-1" placeholder="Nhập mã giảm giá..." value="">
                            </div>
                            <div class="flex-align gap-16">
                                
                            </div>
                            <button type="submit" id="apply-voucher-btn" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-text-white mt-20 py-10 w-100 rounded-8">
                                Áp dụng
                            </button>
                        </form>
                    </div>

                    {{-- PHẦN TỔNG KẾT ĐƠN HÀNG --}}
                    <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 mt-20">
                        <div id="cart-summary-container">
                            {{-- Dữ liệu tóm tắt sẽ được render tại đây --}}
                            <div class="mb-20">
                                <h6 class="text-lg mb-6 flex-align gap-4"><i class="ph-bold ph-shopping-cart text-main-600 text-xl"></i>Thông tin giỏ hàng</h6>    
                                <a href="#" class="text-sm text-gray-600 flex-align gap-1 fw-medium" style="cursor:pointer;"><span id="summary-total-items">0</span> sản phẩm  + 1 quà tặng </a>
                            </div>
                            <div class="mb-20 flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Tạm tính:</span>
                                <span class="text-gray-900 fw-semibold" id="summary-tong-tam-tinh">Đang tải...</span>
                            </div>
                            <div class="flex-between gap-8">
                                <span class="text-gray-900 font-heading-two">Giảm giá:</span>
                                <span class="text-main-600 fw-semibold" id="summary-giam-gia-voucher">Đang tải...</span>
                            </div>
                            <div class="border-top border-gray-100 my-20 pt-24">
                                <div class="flex-between gap-8">
                                    <span class="text-gray-900 text-lg fw-semibold">Tổng giá trị:</span>
                                    <span class="text-main-600 text-lg fw-semibold" id="summary-tong-gia-tri">
                                        Đang tải...
                                    </span>
                                </div>
                                <div class="text-end gap-8">
                                    <span class="text-success-600 text-sm fw-normal">Tiết kiệm:</span>
                                    <span class="text-success-600 text-sm fw-normal" id="summary-tong-tiet-kiem">
                                        Đang tải...
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="" id="checkout-btn" class="btn btn-main py-14 w-100 rounded-8 disabled">Tiến hành thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Thư viện cần thiết --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Hàm format tiền tệ
    const formatCurrency = (number) => {
        // Đảm bảo đầu vào là số
        const num = parseFloat(number) || 0;
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(num);
    };
    
    // Đặt token CSRF cho tất cả request AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * Dựng HTML cho từng dòng sản phẩm trong giỏ hàng.
     */
    function createCartItemHtml(item) {
        const giaGocDisplay = item.gia_goc > item.don_gia_da_giam 
            ? `<span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">${formatCurrency(item.gia_goc)}</span>` 
            : '';
        
        const phanTramGiamDisplay = item.phan_tram_giam_sp > 0 
            ? `<a href="#" class="flex-align gap-4 text-main-two-600 text-sm"><i class="ph-fill ph-seal-percent text-sm"></i> -${item.phan_tram_giam_sp}%</a>`
            : '';
            
        const maxQuantity = item.ton_kho > 0 ? item.ton_kho : 1;
        const errorQuantityClass = item.soluong > item.ton_kho ? 'border-danger-600' : '';
        const rowClass = item.soluong > item.ton_kho ? 'bg-danger-50' : '';

        return `
            <tr id="row-${item.id_bienthe}" class="${rowClass}">
                <td class="py-20 px-5">
                    <div class="d-flex align-items-center gap-12">
                        <form data-id="${item.id_bienthe}" class="remove-item-form" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="flex-align gap-8 hover-text-danger-600 pe-10">
                                <i class="ph ph-trash text-2xl d-flex"></i>Xóa
                            </button>
                        </form>
                        <a href="#" class="border border-gray-100 rounded-8 flex-center" style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                            <img src="{{ asset('assets/client') }}/images/thumbs/${item.sanpham.anh_dai_dien}" alt="${item.sanpham.ten}" class="w-100 rounded-8">
                        </a>
                        <div class="table-product__content text-start">
                            <div class="flex-align gap-16">
                                <div class="flex-align gap-4 mb-5">
                                    <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                    <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">${item.sanpham.thuong_hieu}</span>
                                </div>
                            </div>
                            <h6 class="title text-lg fw-semibold mb-0">
                                <a href="#" class="link text-line-2" title="${item.sanpham.ten}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">${item.sanpham.ten}</a>
                            </h6>
                            <div class="flex-align gap-16 mb-6">
                                <a href="#" class="product-card__cart btn bg-gray-50 text-heading text-sm py-7 px-8 rounded-8 flex-center gap-8 fw-medium">
                                    ${item.sanpham.ten_bien_the}
                                </a>
                            </div>
                            <div class="product-card__price mb-6">
                                <div class="flex-align gap-4 text-main-two-600 text-sm">
                                    ${phanTramGiamDisplay}
                                    ${giaGocDisplay}
                                </div>
                                <span class="text-heading text-md fw-bold">${formatCurrency(item.don_gia_da_giam)}</span>
                            </div>
                            ${errorQuantityClass ? `<div class="text-danger-600 text-sm fw-medium">Chỉ còn ${maxQuantity} sản phẩm trong kho!</div>` : ''}
                        </div>
                    </div>
                </td>
                <td class="py-20 px-5">
                    <div class="d-flex rounded-4 overflow-hidden">
                        <button type="button" data-id="${item.id_bienthe}" class="quantity__minus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                            <i class="ph ph-minus"></i>
                        </button>
                        <input type="number" data-id="${item.id_bienthe}" name="soluong_${item.id_bienthe}" class="quantity__input cart-quantity-input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4 ${errorQuantityClass}" value="${item.soluong}" min="1" max="${maxQuantity}">
                        <button type="button" data-id="${item.id_bienthe}" class="quantity__plus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white">
                            <i class="ph ph-plus"></i>
                        </button>
                    </div>
                </td>
                <td class="py-20 px-5">
                    <span class="item-total-price text-lg h6 mb-0 fw-semibold text-main-600">${formatCurrency(item.thanh_tien)}</span>
                </td>
            </tr>
        `;
    }

    /**
     * Tải và hiển thị dữ liệu giỏ hàng
     */
    function loadCartData() {
        const url = '{{ route('gio-hang.data') }}';
        
        // Hiển thị loading và ẩn form/table
        $('#cart-loading-spinner').removeClass('d-none');
        $('#cart-update-form').addClass('d-none');
        $('#checkout-btn').addClass('disabled');

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    renderCart(response.data);
                    renderSummary(response.data);
                }
            },
            error: function(xhr) {
                // Xử lý lỗi (ví dụ: chưa đăng nhập)
                $('#cart-loading-spinner').addClass('d-none');
                $('#cart-items-main-container').html('<div class="alert alert-warning">Vui lòng <a href="{{ route('login') }}" class="text-main-600 fw-bold">đăng nhập</a> để xem giỏ hàng của bạn.</div>');
                $('#checkout-btn').addClass('disabled');
            }
        });
    }

    /**
     * Dựng HTML cho Bảng Sản phẩm
     */
    function renderCart(data) {
        let html = '';
        if (data.items.length === 0) {
            html = '<div class=" text-main-600 fw-medium rounded-4 p-10 mb-24">Giỏ hàng của bạn đang trống !</div>';
            $('#cart-items-main-container').html(html);
            $('#checkout-btn').addClass('disabled');
        } else {
            // Hiển thị form/table và ẩn loading
            $('#cart-loading-spinner').addClass('d-none');
            $('#cart-update-form').removeClass('d-none');
            $('#checkout-btn').removeClass('disabled');

            data.items.forEach(item => {
                html += createCartItemHtml(item);
            });
            $('#cart-items-body').html(html);
            $('#total-product-count').text(data.items.length); // Cập nhật tổng số sản phẩm
        }
    }

    /**
     * Dựng HTML cho Tóm tắt đơn hàng và Voucher
     */
    function renderSummary(data) {
        // Cập nhật tóm tắt đơn hàng
        $('#summary-total-items').text(data.items.length);
        $('#summary-tong-tam-tinh').text(formatCurrency(data.tong_tam_tinh));
        // Đặt màu cho giảm giá voucher
        const voucherColorClass = data.giam_gia_voucher > 0 ? 'text-success-600' : 'text-gray-500';
        $('#summary-giam-gia-voucher').removeClass('text-gray-500 text-danger-600').addClass(voucherColorClass);
        $('#summary-giam-gia-voucher').text(`-${formatCurrency(data.giam_gia_voucher)}`);
        $('#summary-tong-gia-tri').text(formatCurrency(data.tong_gia_tri_don_hang));
        $('#summary-tong-tiet-kiem').text(formatCurrency(data.tong_tien_tiet_kiem));

        // Hiển thị trạng thái Voucher
        let voucherStatusHtml = '';
        if (data.voucher) {
            voucherStatusHtml = `
                <div class="alert alert-success d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-semibold text-success-600">Mã: ${data.voucher.ma} (-${formatCurrency(data.voucher.gia_tri_giam)})</span>
                    <button type="button" id="remove-voucher-btn" class="btn border-danger-600 text-danger-600 hover-bg-danger-600 hover-text-white py-2 px-3 rounded-8" aria-label="Xóa">
                        <i class="ph ph-x text-sm"></i> Hủy
                    </button>
                </div>
            `;
            $('#voucher_code_input').val(data.voucher.ma).prop('readonly', true);
            $('#apply-voucher-btn').prop('disabled', true).text('Đã áp dụng').removeClass('border-main-600 text-main-600').addClass('bg-gray-100 text-gray-500 border-gray-100');
        } else {
            $('#voucher_code_input').val('').prop('readonly', false).attr('placeholder', 'Nhập mã giảm giá...');
            $('#apply-voucher-btn').prop('disabled', false).text('Áp dụng').removeClass('bg-gray-100 text-gray-500 border-gray-100').addClass('border-main-600 text-main-600');
        }
        $('#voucher-status-container').html(voucherStatusHtml);
    }

    // ========================================================================
    // XỬ LÝ SỰ KIỆN JQUERY/AJAX
    // ========================================================================

    $(document).ready(function() {
        loadCartData();

        // 1. Nút cộng/trừ số lượng
        $(document).on('click', '.quantity__plus, .quantity__minus', function() {
            const id_bienthe = $(this).data('id');
            const $input = $(`input.cart-quantity-input[data-id="${id_bienthe}"]`);
            let soluong = parseInt($input.val());
            const max = parseInt($input.attr('max'));

            if ($(this).hasClass('quantity__plus')) {
                soluong = Math.min(soluong + 1, max);
            } else {
                soluong = Math.max(soluong - 1, 1); // Không cho giảm dưới 1
            }
            
            $input.val(soluong);
            // Kích hoạt event input để trigger cập nhật (trong trường hợp người dùng không nhấn nút Cập nhật)
            $input.trigger('input'); 
        });

        // 2. Cập nhật số lượng qua input (sử dụng debounce)
        $(document).on('input', '.cart-quantity-input', function() {
            const $input = $(this);
            const id_bienthe = $input.data('id');
            const soluong = parseInt($input.val());
            const max = parseInt($input.attr('max'));
            
            if (soluong < 1) {
                $input.val(1);
                return;
            }
            if (soluong > max) {
                 // Không hiển thị lỗi ngay, chỉ cảnh báo và giới hạn lại số lượng
                 $input.val(max);
                 Swal.fire('Cảnh báo', `Số lượng tối đa có thể mua là ${max}.`, 'warning');
            }

            // Debounce để tránh gửi quá nhiều request khi người dùng nhập nhanh
            clearTimeout($input.data('timer'));
            $input.data('timer', setTimeout(function() {
                
                $.ajax({
                    url: '{{ route('cap-nhat-gio-hang') }}',
                    method: 'POST',
                    data: { id_bienthe: id_bienthe, soluong: parseInt($input.val()) },
                    success: function(response) {
                        // Cập nhật lại dữ liệu giỏ hàng để phản ánh sự thay đổi
                        loadCartData();
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON.error || 'Có lỗi xảy ra khi cập nhật.';
                        Swal.fire('Thất bại!', errorMsg, 'error');
                        loadCartData(); // Load lại để đồng bộ trạng thái cũ
                    }
                });
            }, 800)); // Chờ 0.8 giây trước khi gửi request
        });
        
        // 3. Nút "Cập nhật giỏ hàng" (Có thể dùng nếu không dùng debounce)
        $('#cart-update-form').on('submit', function(e) {
             e.preventDefault();
             // Dùng loadCartData() để refresh UI sau khi input đã debounce
             loadCartData();
             Swal.fire('Thành công', 'Giỏ hàng đã được cập nhật!', 'success');
        });

        // 4. Xóa sản phẩm
        $(document).on('click', '.remove-item-form button[type="submit"]', function(e) {
            e.preventDefault();
            const id_bienthe = $(this).closest('form').data('id');
            
            Swal.fire({
                title: 'Xác nhận xóa?',
                text: "Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#de4740',
                cancelButtonColor: '#2ABC79',
                confirmButtonText: 'Đồng ý xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('gio-hang/xoa') }}/' + id_bienthe,
                        method: 'DELETE',
                        success: function(response) {
                            Swal.fire('Đã xóa!', response.message, 'success');
                            loadCartData();
                        },
                        error: function() {
                            Swal.fire('Lỗi', 'Không thể xóa sản phẩm.', 'error');
                        }
                    });
                }
            });
        });

        // 5. Áp dụng Voucher
        $('#voucher-form').on('submit', function(e) {
            e.preventDefault();
            const code = $('#voucher_code_input').val().trim();
            if (!code) {
                 Swal.fire('Lỗi', 'Vui lòng nhập mã giảm giá.', 'error');
                 return;
            }

            $.ajax({
                url: '{{ route('ap-dung-voucher') }}',
                method: 'POST',
                data: { voucher_code: code },
                success: function(response) {
                    Swal.fire('Thành công!', response.message, 'success');
                    loadCartData();
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON.error || 'Mã giảm giá không hợp lệ.';
                    Swal.fire('Lỗi', errorMsg, 'error');
                    loadCartData();
                }
            });
        });

        // 6. Xóa Voucher
        $(document).on('click', '#remove-voucher-btn', function() {
            $.ajax({
                url: '{{ route('xoa-voucher') }}',
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Thành công!', response.message, 'success');
                    loadCartData();
                },
                error: function() {
                    Swal.fire('Lỗi', 'Không thể xóa mã giảm giá.', 'error');
                }
            });
        });

    });
</script>

@endsection