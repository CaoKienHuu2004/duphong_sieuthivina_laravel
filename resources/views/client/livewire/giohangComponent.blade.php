<div class="container container-lg">
    {{-- Hiển thị thông báo (Livewire Flash Messages) --}}
    @if (session()->has('update_message') || session()->has('error_message') || session()->has('voucher_success') || session()->has('voucher_error') || session()->has('voucher_info'))
        <div class="{{ session()->has('error_message') ? 'bg-main-200 border border-main-600 text-main-900 fw-medium' : 'bg-success-200 border border-success-600 text-success-900 fw-medium' }} mb-20 p-10 rounded-8">
            {{ session('update_message') ?? $message ?? session('error_message') ?? session('voucher_success') ?? session('voucher_error') ?? session('voucher_info')}}
        </div>
    @endif
    @php
        $mainItems = array_filter($giohang, fn($item) => ($item['thanhtien'] ?? 0) > 0);
        $giftItems = array_filter($giohang, fn($item) => ($item['thanhtien'] ?? 1) == 0);
    @endphp

    <div class="row gy-4">
        <div class="col-xl-9 col-lg-8">
            
            {{-- ================================================================= --}}
            {{-- 1. DANH SÁCH SẢN PHẨM CHÍNH ($giohang) --}}
            {{-- ================================================================= --}}
            <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0" wire:loading.class="opacity-50">
                <form action="" method="post" class="">
                    <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                        <table class="table style-three">
                            <thead>
                                <tr class="border-bottom border-gray-500 my-10 py-10">
                                    <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-24" colspan="2">
                                        <div>
                                            <i class="ph-bold ph-shopping-cart text-main-600 text-lg pe-6"></i> 
                                            Giỏ hàng ( {{ count($giohang) }} sản phẩm )
                                        </div>
                                    </th>
                                    <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Số lượng</th>
                                    <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mainItems as $item)
                                    @php
                                        // Dữ liệu từ mối quan hệ
                                        $bienthe = $item['bienthe'];
                                        $sanpham = $bienthe['sanpham'];
                                        $thuonghieu = $sanpham['thuonghieu']['ten'] ?? 'N/A';
                                        $loaibienthe = $bienthe['loaibienthe']['ten'] ?? '';
                                        $giagoc = $bienthe['giagoc'] ?? 0;
                                        $giadagiam= $bienthe['giadagiam'];
                                        $phantramgiam = $sanpham['giamgia'] ?? 0;
                                        $hinhanhsanpham = $sanpham['hinhanhsanpham'];
                                        $image = $hinhanhsanpham[0]['hinhanh'];
                                    @endphp
                                    <tr wire:key="cart-item-{{ $item['id_bienthe'] }}">
                                        <td class="py-20 px-5">
                                            <div class="d-flex align-items-center gap-12">
                                                {{-- Nút Xóa Sản phẩm --}}
                                                <button type="button" class="flex-align gap-8 hover-text-danger-600 pe-10" 
                                                        wire:click="xoagiohang({{ $item['id_bienthe'] }})" 
                                                        wire:confirm="Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?">
                                                    <i class="ph ph-trash text-2xl d-flex"></i> Xóa
                                                </button>
                                                
                                                {{-- Ảnh sản phẩm --}}
                                                <a href="{{ route('chi-tiet-san-pham',$sanpham['slug']) }}" class="border border-gray-100 rounded-8 flex-center" style="max-width: 120px; max-height: 120px; width: 100%; height: 100%">
                                                    <img src="{{ asset('assets/client') }}/images/thumbs/{{ $image }}" alt="{{ $sanpham['ten'] ?? 'Sản phẩm' }}" class="w-100 rounded-8">
                                                </a>

                                                <div class="table-product__content text-start">
                                                    {{-- Thương hiệu --}}
                                                    <div class="flex-align gap-16">
                                                        <div class="flex-align gap-4 mb-5">
                                                            <span class="text-main-two-600 text-md d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                            <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;" title="{{ $thuonghieu }}">{{ $thuonghieu }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- Tên sản phẩm --}}
                                                    <h6 class="title text-lg fw-semibold mb-0">
                                                        <a href="{{ route('chi-tiet-san-pham',$sanpham['slug']) }}" class="link text-line-2" title="{{ $sanpham['ten'] ?? 'Sản phẩm' }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $sanpham['ten'] ?? 'Sản phẩm' }}</a>
                                                    </h6>
                                                    
                                                    {{-- Loại biến thể --}}
                                                    @if ($loaibienthe)
                                                        <div class="flex-align gap-16 mb-6">
                                                            <a href="{{ route('chi-tiet-san-pham',$sanpham['slug']) }}" class="btn bg-gray-50 text-heading text-sm py-6 px-8 rounded-8 flex-center gap-8 fw-medium">
                                                                {{ $loaibienthe }}
                                                            </a>
                                                        </div>
                                                    @endif

                                                    {{-- Giá --}}
                                                    <div class="product-card__price mb-6">
                                                        @if ($phantramgiam > 0)
                                                            <div class="flex-align gap-4 text-main-two-600 text-sm">
                                                                <i class="ph-fill ph-seal-percent text-sm"></i> -{{ $phantramgiam }}% 
                                                                <span class="text-gray-400 text-xs fw-semibold text-decoration-line-through">{{ number_format($giagoc,'0',',','.') }} đ</span>
                                                            </div>
                                                        @endif
                                                        <span class="text-heading text-md fw-bold">{{ number_format($giadagiam,'0','.','.')}} đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="item-id" value="{{ $item['id_bienthe'] }}">
                                        </td>
                                        
                                        {{-- Cập nhật Số lượng (Livewire) --}}
                                        <td class="py-20 px-5">
                                            <div class="d-flex rounded-4 overflow-hidden">
                                                {{-- Giảm số lượng --}}
                                                <button type="button" class="quantity__minus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white"
                                                    wire:click="capnhatsoluong({{ $item['id_bienthe'] }}, {{ $item['soluong'] - 1 }})">
                                                    <i class="ph ph-minus"></i>
                                                </button>
                                                
                                                {{-- Input Số lượng --}}
                                                <input type="number" 
                                                    class="quantity__input flex-grow-1 border border-gray-100 border-start-0 border-end-0 text-center w-32 px-4" 
                                                    value="{{ $item['soluong'] }}" 
                                                    min="1" 
                                                    wire:change="capnhatsoluong({{ $item['id_bienthe'] }}, $event.target.value)"
                                                    >
                                                    
                                                {{-- Tăng số lượng --}}
                                                <button type="button" class="quantity__plus border border-end border-gray-100 flex-shrink-0 h-48 w-48 text-neutral-600 flex-center hover-bg-main-600 hover-text-white"
                                                    wire:click="capnhatsoluong({{ $item['id_bienthe'] }}, {{ $item['soluong'] + 1 }})">
                                                    <i class="ph ph-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        
                                        {{-- Thành tiền --}}
                                        <td class="py-20 px-5">
                                            <span class="text-lg h6 mb-0 fw-semibold text-main-600">{{ number_format($item['thanhtien'],'0',',','.') }} đ</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-20">Giỏ hàng không có sản phẩm nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            
            {{-- ================================================================= --}}
            {{-- 2. DANH SÁCH QUÀ TẶNG (giftItems) --}}
            {{-- ================================================================= --}}
            @if ($tongsoquatang > 0)
                    <div class="text-center mt-20 p-10 bg-yellow-50 rounded-lg text-yellow-800 font-semibold border-2 border-dashed border-yellow-500">
                        🎉 Bạn nhận được thêm {{ $tongsoquatang }} sản phẩm Quà Tặng miễn phí trong đơn hàng này!
                    </div>
            @endif
            @if (!empty($giftItems))
                <div class="cart-table border border-gray-100 rounded-8 p-30 pb-0 mt-20">
                    <div class="overflow-x-auto scroll-sm scroll-sm-horizontal">
                        <table class="table style-three">
                            <thead>
                                <tr class="border-bottom border-gray-500 my-10 py-10">
                                    <th class="h6 mb-0 p-0 pb-10 text-lg fw-bold flex-align gap-6" colspan="2">
                                        <i class="ph-bold ph-gift text-main-600 text-lg"></i> Quà tặng nhận được ( {{ count($giftItems) }} sản phẩm )
                                    </th>
                                    <th class="px-60"></th>
                                    <th class="px-60"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($giftItems as $gift)
                                    <tr wire:key="gift-item-{{ $gift['id_bienthe'] }}" class="">
                                                @php
                                                    $bientheGift = \App\Models\BientheModel::find($gift['id_bienthe']);
                                                    $sanphamGift = $bientheGift->sanpham ?? null;
                                                    $loaibientheGift = $bientheGift->loaibienthe->ten ?? '';
                                                    $hinhanhsanphamGift = $sanphamGift['hinhanhsanpham'];
                                                    $giagocGift = $bientheGift->giagoc ?? 0;
                                                @endphp
                                                <td class="py-20 px-5">
                                                    <div class="d-flex align-items-center gap-12">
                                                        <a href="{{ route('chi-tiet-san-pham',$sanphamGift['slug']) }}" class="border border-gray-100 rounded-8 flex-center" style="max-width: 100px; max-height: 100px; width: 100%; height: 100%">
                                                            <img src="{{ asset('assets/client') }}/images/thumbs/{{ $hinhanhsanphamGift[0]['hinhanh']}}" alt="{{ $sanphamGift['ten'] ?? 'Sản phẩm'}}" class="w-100 rounded-8">
                                                        </a>
                                                        <div class="table-product__content text-start">
                                                            <div class="flex-align gap-16">
                                                                <div class="flex-align gap-4 mb-5">
                                                                    <span class="text-main-two-600 text-sm d-flex"><i class="ph-fill ph-storefront"></i></span>
                                                                    <span class="text-gray-500 text-xs" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 250px; display: inline-block;">{{ $sanphamGift['thuonghieu']['ten'] ?? 'N/A'}}</span>
                                                                </div>
                                                            </div>
                                                            <h6 class="title text-md fw-semibold mb-0">
                                                                <a href="#" class="link text-line-2 fw-medium" title="{{ $sanphamGift['ten'] ?? 'Sản phẩm'}}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 350px; display: inline-block;">{{ $sanphamGift['ten'] ?? 'Sản phẩm'}}</a>
                                                            </h6>
                                                            <div class="flex-align gap-16 mb-6">
                                                                <a href="#" class="btn bg-gray-50 text-heading text-xs py-6 px-6 rounded-8 flex-center gap-8 fw-medium">
                                                                   {{ $loaibientheGift }}
                                                                </a>
                                                            </div>
                                                            <div class="product-card__price mb-6">
                                                                <div class="flex-align gap-4 text-main-two-600 text-xs">
                                                                    <span class="text-gray-400 text-sm fw-semibold text-decoration-line-through me-4">{{ number_format($giagocGift,'0',',','.') }} đ</span>
                                                                    <a href="#" class="flex-align gap-4 text-main-two-600 text-xs"><i class="ph-fill ph-seal-percent text-sm"></i> Quà tặng miễn phí</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-20 px-5">
                                                    <div class="d-flex rounded-4 overflow-hidden">
                                                        <input type="text" class="quantity__input flex-grow-1 border border-start-0 border-end-0 text-center w-32 px-4 py-8 bg-gray-100" value="x {{ $gift['soluong'] }}" min="1" readonly="">
                                                    </div>
                                                </td>
                                                <td class="py-20 px-5">
                                                    <span class="text-lg h6 mb-0 fw-semibold text-main-600">{{ number_format($gift['thanhtien'],'0',',','.') }} đ</span>
                                                </td>
                                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-xl-3 col-lg-4">
            <div class="cart-sidebar border border-gray-100 rounded-8 px-24 py-30 pb-20">
                <h6 class="text-lg mb-20 flex-align gap-8"><i class="ph-bold ph-ticket text-main-600 text-xl"></i>Áp dụng Voucher</h6>
                <form>
                    <div class="flex-align gap-16">
                        <input type="text" wire:model.live="voucherCode" class="common-input p-10" placeholder="Nhập mã giảm giá..." value="">
                    </div>
                    <button type="button" wire:click="applyVoucher" wire:loading.attr="disabled" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-text-white mt-20 py-10 w-100 rounded-8" style="width: 100px;">
                        <span>Áp Dụng</span>
                    </button>
                </form>
                @if (count($availableVouchers) > 0)
                    @foreach ($availableVouchers as $voucher)
                        <div class="flex-align flex-between gap-8 mt-10 border-dashed border-gray-200 py-10 px-12 rounded-4">
                            <span class="flex-align gap-8 text-sm fw-medium text-gray-900 pe-10">
                                <i class="ph-bold ph-ticket text-main-600 text-2xl"></i>
                                <div class="text-sm d-flex flex-column">
                                    <span class="text-sm text-gray-900 w-100">
                                        Giảm {{ number_format($voucher['giatri'],'0',',','.') }} đ
                                    </span>
                                    <span class="text-xs text-gray-500 w-100">
                                        {{ $voucher['magiamgia'] }}
                                    </span>
                                </div>
                            </span>
                            @php
                                $isApplied = $appliedVoucher && $appliedVoucher['magiamgia'] === $voucher['magiamgia'];
                            @endphp
                            @if($isApplied)
                                <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                    <button wire:click="removeVoucher" wire:loading.attr="disabled" class="btn border-main-600 text-main-600 hover-bg-main-600 hover-text-white p-6 rounded-4 text-xs" style="cursor: pointer;">
                                        Hủy
                                    </button>
                                </span>
                            @else
                                <span class="flex-align gap-8 text-xs fw-medium text-gray-900">
                                    <button wire:click="applyVoucher('{{ $voucher['magiamgia'] }}')" class="btn bg-main-600 hover-bg-main-100 text-white hover-text-main-600 p-6 rounded-4 text-xs" style="cursor: pointer;">
                                        Chọn
                                    </button>
                                </span>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            
            {{-- ================================================================= --}}
            {{-- 4. TỔNG KẾT (calculateTotals) --}}
            {{-- ================================================================= --}}
            <div class="cart-sidebar border border-gray-100 rounded-8 px-20 py-20 mt-20">
                <div class="mb-20">
                    <h6 class="text-lg mb-6 flex-align gap-4"><i class="ph-bold ph-shopping-cart text-main-600 text-xl"></i>Thông tin giỏ hàng</h6>
                    <a href="#" class="text-sm text-gray-600 flex-align gap-1 fw-medium" style="cursor:pointer;">
                        {{ count($giohang) }} sản phẩm @if($tongsoquatang > 0) + {{ $tongsoquatang }} quà tặng @endif
                    </a>
                </div>
                
                {{-- Tạm tính --}}
                <div class="mb-20 flex-between gap-8">
                    <span class="text-gray-900 font-heading-two">Tạm tính:</span>
                    <span class="text-gray-900 fw-semibold">{{ number_format($tamtinh,'0',',','.') }} đ</span>
                </div>
                @if($giamgiaVoucher > 0)
                <div class="flex-between gap-8">
                    <span class="text-gray-900 font-heading-two">Giảm giá Voucher:</span>
                    <span class="text-success-600 fw-semibold"> -{{ number_format($giamgiaVoucher,'0',',','.') }} đ</span>
                </div>
                @endif
                <div class="border-top border-gray-100 my-20 pt-24">
                    <div class="flex-between gap-8">
                        <span class="text-gray-900 text-lg fw-semibold">Tổng giá trị:</span>
                        <span class="text-main-600 text-lg fw-semibold">
                            {{ number_format($tonggiatri,'0',',','.') }} đ
                        </span>
                    </div>

                    <div class="text-end gap-8">
                        <span class="text-success-600 text-sm fw-normal">Tiết kiệm:</span>
                        <span class="text-success-600 text-sm fw-normal">
                            {{ number_format($tietkiem,'0',',','.') }} đ
                        </span>
                    </div>
                </div>
                <a href="#" class="btn btn-main py-14 w-100 rounded-8" wire:loading.class="opacity-50">Tiến hành thanh toán</a>
            </div>
        </div>
    </div>
</div>