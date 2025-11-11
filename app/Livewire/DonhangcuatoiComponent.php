<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DonhangModel;
use Illuminate\Support\Facades\Auth;

class DonhangcuatoiComponent extends Component
{
    // Mảng các trạng thái xử lý có thể lọc
    public $trangThaiFilter = [
        'Đang xác nhận', 
        'Đang đóng gói', 
        'Đang giao hàng', 
        'Đã giao hàng', 
        'Đã hủy đơn'
    ];
    
    // Trạng thái xử lý hiện tại đang được chọn (Mặc định là Đang xác nhận)
    public $trangThaiHienTai = 'Đang xác nhận'; 
    
    // Mảng các trạng thái THANH TOÁN có thể lọc
    public $trangThaiThanhToanFilter = [
        'Tất cả', // Lựa chọn để hiển thị tất cả trạng thái thanh toán
        'Hủy thanh toán', 
        'Thanh toán khi nhận hàng', 
        'Chờ thanh toán', 
        'Đã thanh toán', 
    ];

    // Trạng thái THANH TOÁN hiện tại đang được chọn
    public $trangThaiThanhToanHienTai = 'Tất cả'; 
    
    // Mảng lưu trữ tất cả đơn hàng đã được lọc
    public $donHangs = [];

    // MẢNG MỚI: Lưu trữ số lượng đơn hàng theo trạng thái (Dùng cho tab lọc có số lượng)
    public $filterCounts = [];

    // Hàm khởi tạo (component mount)
    public function mount()
    {
        $this->loadFilterCounts(); // Tải số lượng ban đầu cho các tab
        $this->loadDonHangs(); 
    }

    // HÀM MỚI: Tính tổng số lượng cho tất cả các tab lọc
    public function loadFilterCounts()
    {
        $userId = Auth::id();
        
        // 1. Tính count cho các trạng thái XỬ LÝ (Processing Status)
        // Lấy tất cả các count theo trạng thái xử lý
        $processingCounts = DonhangModel::where('id_nguoidung', $userId)
                                       ->selectRaw('trangthai, count(*) as count')
                                       ->groupBy('trangthai')
                                       ->pluck('count', 'trangthai')
                                       ->toArray();
        
        // 2. Tính count cho trạng thái THANH TOÁN 'Chờ thanh toán' (được hiển thị là một tab riêng)
        $pendingPaymentCount = DonhangModel::where('id_nguoidung', $userId)
                                           ->where('trangthaithanhtoan', 'Chờ thanh toán')
                                           ->count();
        
        // Gán kết quả vào biến public $filterCounts
        $this->filterCounts = $processingCounts;
        $this->filterCounts['Chờ thanh toán'] = $pendingPaymentCount;
    }

    // Hàm lấy dữ liệu đơn hàng (áp dụng logic lọc)
    public function loadDonHangs()
    {
        $userId = Auth::id();

        $query = DonhangModel::where('id_nguoidung', $userId)
            // Lọc theo trạng thái XỬ LÝ hiện tại
            ->where('trangthai', $this->trangThaiHienTai);
            
        // Lọc theo trạng thái THANH TOÁN nếu không phải là 'Tất cả'
        if ($this->trangThaiThanhToanHienTai !== 'Tất cả') {
            $query->where('trangthaithanhtoan', $this->trangThaiThanhToanHienTai);
        }

        // Tối ưu: Eager loading các quan hệ cần thiết
        $query->with([
            'chitietdonhang' => function ($query) {
                $query->with([
                    'bienthe' => function ($q) {
                        $q->with('sanpham.hinhanhsanpham'); // Tải ảnh sản phẩm
                    }
                ]);
            },
            'phivanchuyen' // Tải phí vận chuyển
        ])
        ->orderBy('created_at', 'desc');

        $this->donHangs = $query->get();
    }

    // Hàm chuyển trạng thái lọc XỬ LÝ (Processing Status)
    public function changeStatus($status)
    {
        $this->trangThaiHienTai = $status;
        
        // Khi chuyển sang tab xử lý, reset lọc thanh toán để chỉ lọc theo trạng thái xử lý
        $this->trangThaiThanhToanHienTai = 'Tất cả';

        $this->loadDonHangs();
    }

    // Hàm chuyển trạng thái lọc THANH TOÁN (Chủ yếu dùng cho tab 'Chờ thanh toán')
    public function changePaymentStatus($status)
    {
        // Khi chọn 'Chờ thanh toán', buộc phải đặt trạng thái xử lý là 'Đang xác nhận' 
        // để hiển thị đúng đơn hàng mới
        $this->trangThaiHienTai = 'Đang xác nhận';
        $this->trangThaiThanhToanHienTai = $status;
        $this->loadDonHangs();
    }
    
    // Hàm xử lý hủy đơn hàng
    public function huyDonHang($donHangId)
    {
        $donHang = DonhangModel::where('id', $donHangId)
                              ->where('id_nguoidung', Auth::id())
                              ->first();

        if (!$donHang) {
            session()->flash('error', 'Không tìm thấy đơn hàng hoặc bạn không có quyền hủy đơn hàng này.');
            return;
        }

        // Kiểm tra điều kiện hủy (chỉ cho phép hủy khi đang chờ xác nhận)
        if ($donHang->trangthai !== 'Đang xác nhận') {
            session()->flash('error', 'Đơn hàng đang được xử lý, không thể hủy.');
            return;
        }

        try {
            // Cập nhật trạng thái
            $donHang->trangthai = 'Đã hủy';
            // Tùy chọn: Cập nhật trạng thái thanh toán nếu là Chờ thanh toán
            $donHang->trangthaithanhtoan = 'Chưa thanh toán'; 
            $donHang->save();

            // Tải lại số lượng và danh sách đơn hàng
            $this->loadFilterCounts();
            $this->loadDonHangs(); 

            session()->flash('success', 'Đã hủy đơn hàng ' . $donHang->madon . ' thành công.');
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra khi hủy đơn hàng: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Tên view phải khớp với tên file Blade
        return view('client.livewire.donhangcuatoi-component'); 
    }
}