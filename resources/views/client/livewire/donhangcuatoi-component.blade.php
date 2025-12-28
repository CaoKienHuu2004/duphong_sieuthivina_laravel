
<div class="row g-12">
    <section class="trending-productss overflow-hidden mt-10 fix-scale-80" wire:loading.class="opacity-50">
        <div class="border border-gray-100 p-24 rounded-8">
            <div class="section-heading mb-20">
                <div class="flex-between flex-align flex-wrap gap-8">
                    <ul class="nav common-tab style-two nav-pills m-0 overflow-auto flex-nowrap mb-3 pb-2">
            
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
                            class="{{ $trangThaiThanhToanHienTai === 'Chờ thanh toán' && $trangThaiHienTai === 'Chờ xác nhận' ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }} px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-wallet"></i> Chờ thanh toán ({{ $pendingCount }})
                            </button>
                        </li>
                        @endif

                        {{-- 2. Chờ xác nhận --}}
                        @php
                            $trangThai = 'Chờ xác nhận';
                            $count = array_key_exists($trangThai, $filterCounts) ? $filterCounts[$trangThai] : 0;
                            $isActive = ($trangThaiHienTai === $trangThai) && ($trangThaiThanhToanHienTai !== 'Chờ thanh toán');
                        @endphp
                        <li class="nav-item">
                            <button
                            wire:click="changeStatus('{{ $trangThai }}')" 
                            class=" {{ $isActive ? 'bg-main-600 text-white' : 'border border-gray-600 text-gray-900 hover-border-main-600 hover-text-main-600' }}  px-10 py-8 rounded-10 flex-align gap-8 fw-medium text-xs transition-1 me-2 mb-2">
                                <i class="ph-bold ph-clock-countdown"></i> Chờ xác nhận ({{ $count }})
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
                            $trangThai = 'Đã hủy đơn'; 
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
                            @php
                                        $statusText = $donHang->trangthai;
                                        // $status = $donHang->trangthai;
                                        
                                        // Chỉ hiển thị trạng thái thanh toán nếu là 'Chờ thanh toán'
                                        if ($donHang->trangthaithanhtoan === 'Chờ thanh toán') {
                                            $statusText = 'Chờ thanh toán';
                                        } 
                                        // Các trạng thái thanh toán khác (Đã thanh toán, Chưa thanh toán) sẽ hiển thị trạng thái xử lý ($donHang->trangthai)
                                    @endphp
                            @if ($donHang->trangthai === 'Chờ xác nhận' && $donHang->trangthaithanhtoan === 'Thanh toán khi nhận hàng'||$donHang->trangthai === 'Chờ xác nhận' && $donHang->trangthaithanhtoan === 'Chờ thanh toán'||$donHang->trangthai === 'Chờ xác nhận' && $donHang->trangthaithanhtoan === 'Đã thanh toán')
                                <span class="fw-medium text-xs text-warning-700 bg-warning-100 px-6 py-4 rounded-4 flex-align gap-8" data-c-tooltip="Cập nhật: {{ $donHang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">
                                    <i class="ph-bold ph-clock-countdown"></i> {{ $statusText }}
                                </span>
                            @elseif($donHang->trangthai === 'Chờ thanh toán' && $donHang->trangthaithanhtoan === 'Chờ thanh toán')
                                <span class="fw-medium text-xs text-gray-700 bg-gray-100 px-6 py-4 rounded-4 flex-align gap-8" data-c-tooltip="Cập nhật: {{ $donHang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">
                                    <i class="ph-bold ph-wallet"></i> {{ $statusText }}
                                </span>
                            @elseif($donHang->trangthai === 'Đang đóng gói')
                                <span class="fw-medium text-xs text-primary-700 bg-primary-100 px-6 py-4 rounded-4 flex-align gap-8" data-c-tooltip="Cập nhật: {{ $donHang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">
                                    <i class="ph-bold ph-package"></i> {{ $statusText }}
                                </span>
                            @elseif ($donHang->trangthai === 'Đang giao hàng')
                                <span class="fw-medium text-xs text-info-700 bg-info-100 px-6 py-4 rounded-4 flex-align gap-8" data-c-tooltip="Cập nhật: {{ $donHang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">
                                    <i class="ph-bold ph-truck"></i> {{ $statusText }}
                                </span>
                            @elseif ($donHang->trangthai === 'Đã giao hàng')
                                <span class="fw-medium text-xs text-success-700 bg-success-100 px-6 py-4 rounded-4 flex-align gap-8" data-c-tooltip="Cập nhật: {{ $donHang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">
                                    <i class="ph-bold ph-check-fat"></i> {{ $statusText }}
                                </span>
                            @else
                                <span class="fw-medium text-xs text-main-700 bg-main-100 px-6 py-4 rounded-4 flex-align gap-8" data-c-tooltip="Cập nhật: {{ $donHang->updated_at->format('d/m/Y - H:i') }}" tooltip-position="top">
                                    <i class="ph-bold ph-prohibit"></i> {{ $statusText }}
                                </span>
                            @endif
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
                    <div class="py-6 px-5">
                        @if($chiTiet->dongia == 0) <span class="flex-align mt-10 mb-4 text-gray-900 text-sm fw-medium"><i class="ph-bold ph-gift text-main-600 text-lg pe-4"></i>Quà tặng của bạn</span> @endif
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
                                        {{ $bienthe->loaibienthe->ten }}
                                    </a>
                                </div>
                                <div class="product-card__price mb-6">
                                    <div class="flex-align gap-24">
                                        <span class="text-heading text-sm fw-medium ">Số lượng: {{ $chiTiet->soluong }}</span>
                                        <span class="text-main-600 text-md fw-bold">{{ number_format($chiTiet->dongia,0,',','.')}} ₫</span>
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
                            <span class="fw-medium text-sm">Tổng thanh toán</span>
                        </div>
                    </div>
                    <div class="d-flex flex-align flex-between">
                        <div class="flex-align gap-12">
                            <span class="fw-semibold text-sm text-gray-600">
                                @if($donHang->trangthai == 'Chờ xác nhận' || $donHang->trangthai == 'Chờ thanh toán')
                                <div class="flex-align gap-12">
                                    @if ($donHang->trangthaithanhtoan === 'Chờ thanh toán')
                                        <a href="{{ route('dat-hang-thanh-cong', ['madon' => $donHang->madon]) }}"
                                         class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-credit-card"></i> Quay lại thanh toán</a>
                                    @endif
                                    <button 
                                    wire:click="huyDonHang({{ $donHang->id }})" 
                                    wire:confirm="Bạn có chắc chắn muốn hủy đơn hàng này không?" 
                                    class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-trash"></i> Hủy đơn</button>
                                    {{-- <div
                                        class="fw-medium text-main-400 text-sm border border-main-400 px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-trash"></i> Hủy đơn hàng
                                    </div> --}}
                                    
                                    <a href="{{ route('chi-tiet-don-hang',$donHang->madon) }}" class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                        <i class="ph-bold ph-eye"></i> Xem chi tiết</a>
                                </div>
                                @else
                                    <div class="flex-align gap-12">
                                        <span
                                        class="fw-medium text-main-300 text-sm border border-main-300 px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                            <i class="ph-bold ph-trash"></i> Hủy đơn</span>
                                        {{-- <div
                                            class="fw-medium text-main-400 text-sm border border-main-400 px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                            <i class="ph-bold ph-trash"></i> Hủy đơn hàng
                                        </div> --}}
                                        <a href="{{ route('chi-tiet-don-hang',$donHang->madon) }}" class="fw-medium text-main-600 text-sm border border-main-600 hover-bg-main-600 hover-text-white px-8 py-4 rounded-4 transition-1 flex-align gap-8">
                                            <i class="ph-bold ph-eye"></i> Xem chi tiết</a>
                                    </div>
                                @endif
                            </span>
                        </div>
                        <div class="flex-align gap-12">
                            <span class="fw-bold text-main-600 text-lg">{{ number_format($donHang->thanhtien,'0',',','.') }} đ</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-gray-900 rounded-4 text-center mt-3 mb-0 p-20">
                    Chưa có đơn hàng nào !
                </div>
            @endforelse
        </div>
    </section>
</div>