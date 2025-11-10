<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DonhangModel;
use Illuminate\Support\Facades\Auth;

class DonhangcuatoiComponent extends Component
{
    // Mảng các trạng thái có thể lọc
    public $trangThaiFilter = [
        'Đang xác nhận', 
        'Đang đóng gói', 
        'Đang giao hàng', 
        'Đã giao hàng', 
        'Đã hủy'
    ];
    
    // Trạng thái hiện tại đang được chọn
    public $trangThaiHienTai = 'Đang xác nhận'; 
    
    // Mảng lưu trữ tất cả đơn hàng
    public $donHangs = [];

    // Hàm khởi tạo (component mount)
    public function mount()
    {
        // Tải đơn hàng ban đầu theo trạng thái mặc định
        $this->loadDonHangs(); 
    }

    // Hàm lấy dữ liệu đơn hàng
    public function loadDonHangs()
    {
        // Lấy ID người dùng hiện tại
        $userId = Auth::id();

        // Query cơ sở dữ liệu
        $query = DonhangModel::where('id_nguoidung', $userId)
            // Lọc theo trạng thái hiện tại đang được chọn
            ->where('trangthai', $this->trangThaiHienTai)
            // Tối ưu: Chỉ tải chi tiết và biến thể khi cần
            ->with([
                'chitietdonhang' => function ($query) {
                    $query->with([
                        'bienthe' => function ($q) {
                            $q->with('sanpham.hinhanhsanpham'); // Tải ảnh sản phẩm
                        }
                    ]);
                },
                'phivanchuyen' // Tải phí vận chuyển để hiển thị
            ])
            ->orderBy('created_at', 'desc');

        // Gán kết quả vào thuộc tính public
        $this->donHangs = $query->get();
    }

    // Hàm chuyển trạng thái lọc
    public function changeStatus($status)
    {
        $this->trangThaiHienTai = $status;
        $this->loadDonHangs();
    }

    // Hàm hủy đơn hàng (giả định chỉ hủy được khi 'Đang xác nhận')
    public function huyDonHang($donHangId)
    {
        $donHang = DonhangModel::where('id', $donHangId)
                               ->where('id_nguoidung', Auth::id())
                               ->first();

        if (!$donHang) {
            session()->flash('error', 'Không tìm thấy đơn hàng hoặc bạn không có quyền hủy.');
            return;
        }

        if ($donHang->trangthai !== 'Đang xác nhận') {
            session()->flash('error', 'Chỉ có thể hủy đơn hàng đang ở trạng thái "Đang xác nhận".');
            return;
        }

        // Thực hiện hủy (có thể cần hoàn trả tồn kho nếu bạn đã trừ khi đặt hàng)
        // ... (Logic hoàn trả tồn kho nếu cần) ...
        
        $donHang->trangthai = 'Đã hủy';
        $donHang->save();
        
        $this->loadDonHangs(); // Tải lại danh sách để cập nhật giao diện
        session()->flash('success', 'Đơn hàng ' . $donHang->madon . ' đã được hủy thành công.');
    }

    public function render()
    {
        return view('client.livewire.donhangcuatoi-component');
    }
}
