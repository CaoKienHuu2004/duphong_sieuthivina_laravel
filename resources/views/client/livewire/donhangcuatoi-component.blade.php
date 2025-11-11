
<div class="row g-12">
    <section class="trending-productss overflow-hidden mt-10 fix-scale-80" wire:loading.class="opacity-50">
        <div class="border border-gray-100 p-24 rounded-8">
            <div class="section-heading mb-20">
                <div class="flex-between flex-align flex-wrap gap-8">
                    <ul class="nav common-tab style-two nav-pills m-0 border-bottom overflow-auto flex-nowrap mb-3 pb-2">
            
                        @php
                            // Đảm bảo $filterCounts là một mảng nếu nó chưa được định nghĩa
                            $filterCounts = $filterCounts ?? []; 
                            // Lấy số lượng cho tab 'Chờ thanh toán' (Đã thêm kiểm tra an toàn)
                            $pendingCount = array_key_exists('Chờ thanh toán', $filterCounts) ? $filterCounts['Chờ thanh toán'] : 0;
                        @endphp
                        
                        {{-- 1. Chờ thanh toán --}}
                        @if(in_array('Chờ thanh toán', $trangThaiThanhToanFilter))
                        <li class="nav-item">
                            <button 
                            wire:click="changePaymentStatus('Chờ thanh toán')"
                            class="{{ $trangThaiThanhToanHienTai === 'Chờ thanh toán' && $trangThaiHienTai === 'Đang xác nhận' ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }} px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-wallet"></i> Chờ thanh toán ({{ $pendingCount }})
                            </button>
                        </li>
                        @endif

                        {{-- 2. Đang xác nhận --}}
                        @php
                            $trangThai = 'Đang xác nhận';
                            $count = array_key_exists($trangThai, $filterCounts) ? $filterCounts[$trangThai] : 0;
                            $isActive = ($trangThaiHienTai === $trangThai) && ($trangThaiThanhToanHienTai !== 'Chờ thanh toán');
                        @endphp
                        <li class="nav-item">
                            <button
                            wire:click="changeStatus('{{ $trangThai }}')" 
                            class=" {{ $isActive ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }}  px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-clock-countdown"></i> Đang xác nhận ({{ $count }})
                            </button>
                        </li>
                        
                        {{-- 3. Đang đóng gói --}}
                        @php
                            $trangThai = 'Đang đóng gói';
                            $count = array_key_exists($trangThai, $filterCounts) ? $filterCounts[$trangThai] : 0;
                            $isActive = ($trangThaiHienTai === $trangThai) && ($trangThaiThanhToanHienTai !== 'Chờ thanh toán');
                        @endphp
                        <li class="nav-item">
                            <button
                            wire:click="changeStatus('{{ $trangThai }}')" 
                            class=" {{ $isActive ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }}  px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-package"></i> Đang đóng gói ({{ $count }})
                            </button>
                        </li>
                        
                        {{-- 4. Đang giao hàng --}}
                        @php
                            $trangThai = 'Đang giao hàng';
                            $count = array_key_exists($trangThai, $filterCounts) ? $filterCounts[$trangThai] : 0;
                            $isActive = ($trangThaiHienTai === $trangThai) && ($trangThaiThanhToanHienTai !== 'Chờ thanh toán');
                        @endphp
                        <li class="nav-item">
                            <button
                            wire:click="changeStatus('{{ $trangThai }}')" 
                            class=" {{ $isActive ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }}  px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-truck"></i> Đang giao hàng ({{ $count }})
                            </button>
                        </li>
                        
                        {{-- 5. Đã giao hàng --}}
                        @php
                            $trangThai = 'Đã giao hàng';
                            $count = array_key_exists($trangThai, $filterCounts) ? $filterCounts[$trangThai] : 0;
                            $isActive = ($trangThaiHienTai === $trangThai) && ($trangThaiThanhToanHienTai !== 'Chờ thanh toán');
                        @endphp
                        <li class="nav-item">
                            <button
                            wire:click="changeStatus('{{ $trangThai }}')" 
                            class=" {{ $isActive ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }}  px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-check-fat"></i> Đã giao ({{ $count }})
                            </button>
                        </li>
                        
                        {{-- 6. Đã hủy --}}
                        @php
                            // Đã chỉnh sửa từ 'Đã hủy đơn' thành 'Đã hủy' để khớp với Component Livewire
                            $trangThai = 'Đã hủy'; 
                            $count = array_key_exists($trangThai, $filterCounts) ? $filterCounts[$trangThai] : 0;
                            $isActive = ($trangThaiHienTai === $trangThai) && ($trangThaiThanhToanHienTai !== 'Chờ thanh toán');
                        @endphp
                        <li class="nav-item">
                            <button
                            wire:click="changeStatus('{{ $trangThai }}')" 
                            class=" {{ $isActive ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }}  px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-prohibit"></i> Đã hủy ({{ $count }})
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            @forelse ($donHangs as $donHang)
                <div class="border border-gray-200 p-14 rounded-4 my-10">
                    <div class="d-flex flex-align flex-between">
                        <div class="flex-align gap-12">
                            <span class="fw-semibold text-gray-900 text-md">Đơn hàng #{{ $donHang->madon }}</span>
                        </div>
                        <div class="flex-align gap-12">
                            <span class="fw-medium text-xs text-gray-700 bg-gray-100 px-6 py-4 rounded-4 flex-align gap-8">
                                @php
                                    $statusText = $donHang->trangthai;
                                    
                                    // Chỉ hiển thị trạng thái thanh toán nếu là 'Chờ thanh toán'
                                    if ($donHang->trangthaithanhtoan === 'Chờ thanh toán') {
                                        $statusText = 'Chờ thanh toán';
                                    } 
                                    // Các trạng thái thanh toán khác (Đã thanh toán, Chưa thanh toán) sẽ hiển thị trạng thái xử lý ($donHang->trangthai)
                                @endphp
                                <i class="ph-bold ph-clock-countdown"></i> {{ $statusText }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-align flex-between mb-10">
                        <div class="flex-align gap-8">
                            <span class="fw-medium text-sm text-gray-600">Đặt ngày {{ \Carbon\Carbon::parse($donHang->created_at)->format('d/m/Y - H:i') }}</span>
                        </div>

                    </div>
                    @php
                        $tongGiaTri = 0;
                    @endphp
                    @foreach ($donHang->chitietdonhang as $chiTiet)
                    @php
                        $bienthe = $chiTiet->bienthe;
                        $sanpham = $bienthe->sanpham ?? null;
                        $hinhAnhUrl = $sanpham->hinhanhsanpham[0]['hinhanh'] ?? 'https://placehold.co/60x60/888/fff?text=No+Image';
                        $isGift = $chiTiet->dongia == 0;
                        $donGiaThuc = $chiTiet->dongia; // Đơn giá mỗi sản phẩm (đã bao gồm giảm giá nếu có trong chi tiết)
                        $thanhTienChiTiet = $chiTiet->soluong * $donGiaThuc;
                        $tongGiaTri += $thanhTienChiTiet;
                    @endphp
                    <div class="py-14 px-5">
                        <div class="d-flex align-items-center gap-12">
                            <a href="#"
                                class="border border-gray-100 rounded-8 flex-center"
                                style="max-width: 80px; max-height: 80px; width: 100%; height: 100%">
                                <img src="{{ asset('assets/client') }}/images/thumbs/{{ $hinhAnhUrl }}"
                                    alt="{{ $sanpham->ten }}" class="w-100 rounded-8">
                            </a>
                            <div class="table-product__content text-start">
                                <h6 class="title text-sm fw-semibold mb-0">
                                    <a href="#"
                                        class="link text-line-2" title="{{ $sanpham->ten }}"
                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $sanpham->ten }}</a>
                                </h6>
                                <div class="flex-align gap-16 mb-6">
                                    <a href="#"
                                        class="btn bg-gray-50 text-heading text-xs py-4 px-6 rounded-8 flex-center gap-8 fw-medium">
                                        Có đường (190ml/lon)
                                    </a>
                                </div>
                                <div class="product-card__price mb-6">
                                    <div class="flex-align gap-24">
                                        <span class="text-heading text-sm fw-medium ">Số lượng: 1</span>
                                        <span class="text-main-600 text-md fw-bold">51.000 ₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="item-id" value="30">
                    </div>
                    @endforeach
                    <div class="d-flex flex-align flex-between">
                        <div class="flex-align gap-12">
                            <span class="fw-semibold text-sm text-gray-600"></span>
                        </div>
                        <div class="flex-align gap-12">
                            <span class="fw-medium text-sm">Tổng giá trị</span>
                        </div>
                    </div>
                    <div class="d-flex flex-align flex-between">
                        <div class="flex-align gap-12">
                            <span class="fw-semibold text-sm text-gray-600">
                                <div class="flex-align gap-12">
                                    <button class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-trash"></i> Hủy đơn hàng</button>
                                    {{-- <div
                                        class="fw-medium text-main-400 text-sm border border-main-400 px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-trash"></i> Hủy đơn hàng
                                    </div> --}}
                                    <button class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-eye"></i> Xem chi tiết</button>
                                </div>
                            </span>
                        </div>
                        <div class="flex-align gap-12">
                            <span class="fw-bold text-main-600 text-lg">220.000 đ</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center mt-3 mb-0">
                    Không tìm thấy đơn hàng nào phù hợp với điều kiện lọc hiện tại.
                </div>
            @endforelse
        </div>
    </section>
</div>