<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ThongbaoModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon để xử lý thời gian trong View

class ThongbaoComponent extends Component
{
    use WithPagination;
    
    // Thuộc tính công khai (public) cần thiết để đồng bộ với View
    public $activeTab = 'content-7'; // Mặc định là Đơn hàng
    public $perPage = 10;
    
    // Lưu trữ các mục thông báo đã tải (items) - Livewire có thể serialize array này
    public $loadedNotifications = [];

    // Mảng lưu trữ các loại thông báo và pageName/page hiện tại
    public $notificationTypes = [
        'content-7' => ['name' => 'Đơn hàng', 'pageName' => 'orderPage', 'page' => 1],
        'content-1' => ['name' => 'Khuyến mãi', 'pageName' => 'promotionPage', 'page' => 1],
        'content-11' => ['name' => 'Quà tặng', 'pageName' => 'giftPage', 'page' => 1],
        'content-6' => ['name' => 'Hệ thống', 'pageName' => 'systemPage', 'page' => 1],
    ];

    // Thuộc tính PROTECTED để lưu đối tượng Paginator phức tạp (KHÔNG BỊ SERIALIZE)
    protected $currentPaginator;
    
    // --- Lifecycle Hooks và Actions ---
    
    public function mount()
    {
        // Kiểm tra page hiện tại từ URL để đặt activeTab chính xác khi người dùng chia sẻ link
        foreach ($this->notificationTypes as $tabId => $data) {
            if (request()->has($data['pageName'])) {
                $this->activeTab = $tabId;
                $this->notificationTypes[$tabId]['page'] = (int)request($data['pageName']);
            }
        }
        $this->loadNotifications();
    }
    
    public function updatedActiveTab()
    {
        // Reset về Page 1 khi chuyển tab
        $this->notificationTypes[$this->activeTab]['page'] = 1;
        $this->resetPage($this->notificationTypes[$this->activeTab]['pageName']);
        $this->loadNotifications();
    }
    
    public function loadMore()
    {
        // Tăng số trang của tab hiện tại và tải thêm dữ liệu
        $this->notificationTypes[$this->activeTab]['page']++;
        $this->loadNotifications();
    }
    
    public function loadNotifications()
    {
        $currentType = $this->notificationTypes[$this->activeTab]['name'];
        $currentPage = $this->notificationTypes[$this->activeTab]['page'];
        $pageName = $this->notificationTypes[$this->activeTab]['pageName'];
        $userId = Auth::id();

        // 1. Lấy dữ liệu phân trang cho trang hiện tại
        $newNotifications = ThongbaoModel::where('id_nguoidung', $userId)
            ->where('loaithongbao', $currentType)
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], $pageName, $currentPage);

        // 2. LƯU TRỮ đối tượng Paginator vào thuộc tính PROTECTED
        $this->currentPaginator = $newNotifications;

        // 3. LƯU TRỮ DỮ LIỆU THÔ (items) vào thuộc tính PUBLIC
        // Eloquent Models phải được chuyển đổi thành Array trước khi merge để Livewire serialize đúng cách
        $newItems = $newNotifications->items();

        if ($currentPage === 1) {
            // Tải lại toàn bộ mảng items cho Page 1
            $this->loadedNotifications = $newItems;
        } else {
            // Nối thêm items vào mảng hiện tại
            $this->loadedNotifications = array_merge($this->loadedNotifications, $newItems);
        }
    }
    
    public function markAllAsRead()
    {
         ThongbaoModel::where('id_nguoidung', Auth::id())
             ->where('trangthai', 'Chưa đọc')
             ->update(['trangthai' => 'Đã đọc']);
             
         // Tải lại thông báo sau khi đánh dấu để cập nhật trạng thái đã đọc
         $this->loadNotifications(); 
         session()->flash('success', 'Đã đánh dấu tất cả thông báo là đã đọc.');
    }

    // Livewire yêu cầu phương thức render()
    public function render()
    {
        return view('client.livewire.thongbao-component', [
            // Truyền đối tượng Paginator đã được lưu trữ xuống View
            'paginator' => $this->currentPaginator,
        ]);
    }
}