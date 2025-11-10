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
        'Đã hủy'
    ];
    
    // Trạng thái xử lý hiện tại đang được chọn
    public $trangThaiHienTai = 'Đang xác nhận'; 
    
    // Mảng các trạng thái THANH TOÁN có thể lọc
    public $trangThaiThanhToanFilter = [
        'Tất cả', // Lựa chọn để hiển thị tất cả trạng thái thanh toán
        'Chưa thanh toán', 
        'Chờ thanh toán', 
        'Đã thanh toán', 
        // Thêm các trạng thái ENUM khác nếu cần (Thanh toán thất bại, Hoàn tiền)
    ];

    // Trạng thái THANH TOÁN hiện tại đang được chọn
    public $trangThaiThanhToanHienTai = 'Tất cả'; 
    
    // Mảng lưu trữ tất cả đơn hàng
    public $donHangs = [];

    // Hàm khởi tạo (component mount)
    public function mount()
    {
        $this->loadDonHangs(); 
    }

    // Hàm lấy dữ liệu đơn hàng
    public function loadDonHangs()
    {
        $userId = Auth::id();

        $query = DonhangModel::where('id_nguoidung', $userId)
            // Lọc theo trạng thái XỬ LÝ (Processing Status)
            ->where('trangthai', $this->trangThaiHienTai);
            
        // Lọc theo trạng thái THANH TOÁN (Payment Status) nếu không phải là 'Tất cả'
        if ($this->trangThaiThanhToanHienTai !== 'Tất cả') {
            $query->where('trangthai_thanhtoan', $this->trangThaiThanhToanHienTai);
        }

        // Tối ưu: Chỉ tải chi tiết và biến thể khi cần
        $query->with([
            'chitietdonhang' => function ($query) {
                $query->with([
                    'bienthe' => function ($q) {
                        $q->with('sanpham.hinhanhsanpham'); // Tải ảnh sản phẩm
                    }
                ]);
            },
            'phivanchuyen' 
        ])
        ->orderBy('created_at', 'desc');

        $this->donHangs = $query->get();
    }

    // Hàm chuyển trạng thái lọc XỬ LÝ
    public function changeStatus($status)
    {
        $this->trangThaiHienTai = $status;
        $this->loadDonHangs();
    }

    // Hàm chuyển trạng thái lọc THANH TOÁN MỚI
    public function changePaymentStatus($status)
    {
        $this->trangThaiThanhToanHienTai = $status;
        $this->loadDonHangs();
    }
    
    // ... (Hàm huyDonHang giữ nguyên) ...

    public function render()
    {
        // ... (View đã sửa tên)
        return view('client.livewire.donhangcuatoi-component'); 
    }
}