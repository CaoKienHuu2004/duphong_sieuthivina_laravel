<div class="border border-gray-100 rounded-8 p-16">
    {{-- Hiển thị thông báo flash nếu có (ví dụ: sau khi đánh dấu đã đọc) --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-10" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-10" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="py-10 flex-between flex-align mb-20">
        <ul class="nav common-tab style-two nav-pills m-0" id="pills-tab" role="tablist">
            @foreach ($notificationTypes as $tabId => $data)
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link flex-align gap-8 fw-medium text-sm hover-border-main-600 {{ $activeTab === $tabId ? 'active' : '' }}"
                        id="tab-{{ $tabId }}" data-bs-toggle="pill" data-bs-target="#{{ $tabId }}" type="button" role="tab"
                        aria-controls="{{ $tabId }}" aria-selected="{{ $activeTab === $tabId ? 'true' : 'false' }}"
                        wire:click="$set('activeTab', '{{ $tabId }}')">

                        {{-- Chọn icon dựa trên tên tab --}}
                        <i class="ph-bold 
                                @if ($data['name'] == 'Đơn hàng') ph-notepad 
                                @elseif ($data['name'] == 'Mã khuyến mãi') ph-ticket 
                                @elseif ($data['name'] == 'Quà tặng') ph-gift 
                                @else ph-gear 
                                @endif text-lg">
                        </i> {{ $data['name'] }}
                    </button>
                </li>
            @endforeach
        </ul>

        <a href="#" wire:click.prevent="markAllAsRead"
            class="text-white hover-bg-main-800 text-sm bg-main-600 px-10 py-6 rounded-8 flex-align gap-12"
            wire:loading.attr="disabled">
            <i class="ph-bold ph-check"></i> Đánh dấu tất cả là đã đọc
        </a>
    </div>

    <div class="tab-content" id="pills-tabContent">
        @foreach ($notificationTypes as $tabId => $data)
            <div class="tab-pane fade {{ $activeTab === $tabId ? 'show active' : '' }}" id="{{ $tabId }}" role="tabpanel"
                aria-labelledby="tab-{{ $tabId }}" tabindex="0">

                <div wire:key="list-{{ $tabId }}">
                    {{-- Lặp qua dữ liệu đã được tải --}}
                    @forelse ($loadedNotifications as $notification)
                        @php
                            $isUnread = $notification['trangthai'] == 'Chưa đọc';
                            $cssClass = $isUnread ? 'bg-gray-50' : '';
                            $iconClass = match ($notification['loaithongbao']) {
                                'Mã khuyến mãi' => 'ph-ticket',
                                'Quà tặng' => 'ph-gift',
                                'Hệ thống' => 'ph-gear',
                                default => 'ph-notepad', // Đơn hàng
                            };
                        @endphp

                        <div
                            class="border border-gray-100 {{ $cssClass }} box-shadow-sm text-main-900 rounded-4 px-20 py-16 mb-10 flex-align gap-8">
                            <i class="ph-bold {{ $iconClass }} text-main-600 text-4xl"></i>
                            <div class="w-100">
                                <div class="flex-align flex-between gap-12">
                                    <span
                                        class="text-gray-900 text-lg fw-medium flex-align gap-8">{{ $notification['tieude'] }}</span>
                                    @if ($notification['lienket'])
                                        <a href="{{ $notification['lienket'] }}"
                                            class="border border-main-600 text-main-600 hover-text-white hover-bg-main-600 px-8 py-4 rounded-4 text-sm">Xem
                                            chi tiết</a>
                                    @endif
                                </div>
                                <div class="flex-align gap-12">
                                    <span class="text-gray-900 text-md fw-normal">{!! $notification['noidung'] !!}</span>
                                </div>
                                <small
                                    class="text-muted">{{ (new \Carbon\Carbon($notification['created_at']))->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        @if ($activeTab === $tabId)
                            <div class="alert alert-info text-center">Không có thông báo nào trong mục này.</div>
                        @endif
                    @endforelse
                </div>

                {{-- Nút Đọc thêm (Load More) --}}
                @if ($paginator && $paginator->hasMorePages() && $activeTab === $tabId)
                    <button wire:click="loadMore" wire:loading.attr="disabled" class="btn btn-block btn-secondary mt-20 w-100">
                        <span wire:loading.remove wire:target="loadMore">Đọc thêm {{ $data['name'] }}</span>
                        <span wire:loading wire:target="loadMore">Đang tải...</span>
                    </button>
                @endif

            </div>
        @endforeach
    </div>
</div>