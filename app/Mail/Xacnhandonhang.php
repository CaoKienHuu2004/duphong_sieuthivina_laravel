<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Carbon\Carbon; // Thêm thư viện Carbon

class Xacnhandonhang extends Mailable implements ShouldQueue
{
    use Queueable;

    // Khai báo các thuộc tính để truyền vào View
    public $order;
    public $user;
    
    // Dữ liệu đã định dạng sẵn cho View
    public $formattedData;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\DonhangModel $order
     * @param \App\Models\NguoidungModel $user
     * @return void
     */
    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
        
        // Chuẩn bị dữ liệu để sử dụng trực tiếp trong HTML/Blade
        $this->prepareFormattedData();
    }

    /**
     * Định nghĩa Envelope (Tiêu đề email).
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bạn đã đặt hàng thành công | ' . $this->order->madon,
        );
    }

    /**
     * Định nghĩa Content (Nội dung email).
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        // Trỏ đến file HTML đã làm (Giả sử bạn sẽ chuyển HTML sang Blade để dễ dàng thay thế biến)
        // Hoặc bạn sẽ sử dụng biến $this->formattedData để thực hiện thay thế thủ công (tìm và thay thế) trong View tĩnh.
        return new Content(
            html: 'mail.xacnhandonhang', // Tên file Blade/HTML mới
            with: [
                'data' => $this->formattedData,
                'order' => $this->order,
                'user' => $this->user,
            ]
        );
    }
    
    /**
     * Chuẩn bị dữ liệu đã được định dạng và tính toán trước.
     * Cần đảm bảo các mối quan hệ (relationships) của DonhangModel đã được Eager Load.
     */
    protected function prepareFormattedData()
    {
        $madon = $this->order->madon;
        $ngay_dat_hang = Carbon::parse($this->order->created_at)->setTimezone(config('app.timezone'))->format('M j, Y H:i A');
        
        // Tính tổng mặt hàng
        $tong_so_mat_hang = $this->order->tongsoluong;
        
        // Giả định các mối quan hệ đã được Eager Load trong Controller
        $giam_gia_1 = optional($this->order->maGiamGia)->giatri ?? 0;
        $phi_van_chuyen_giam = 0; // Giả định không có trường cụ thể cho giảm giá vận chuyển
        $phi_van_chuyen_goc = optional($this->order->phiVanChuyen)->phi ?? 0;
        
        // CHUYỂN LOGIC FOREACH VÀO ĐÂY, TRẢ VỀ COLLECTION/ARRAY SẢN PHẨM
        // Sử dụng $this->order->chiTietDonHang trực tiếp
        
        // Giả định tổng mặt hàng (tạm thời sử dụng để tính toán)
        $tong_mat_hang_tinh_toan = 0;
        
        // Lấy chi tiết đơn hàng dưới dạng Collection/Array để foreach trong Blade
        $chi_tiet_don_hang = $this->order->chiTietDonHang->map(function ($item) use (&$tong_mat_hang_tinh_toan) {
            $productName = $item->tensanpham ?? 'Sản phẩm không rõ';
            $variantName = $item->tenbienthe ?? 'Biến thể không rõ';
            $productImage = optional(optional(optional($item->bienthe)->sanpham)->hinhanhsanpham)->first()->hinhanh ?? 'https://placehold.co/60x80/222222/ffffff?text=SP';
            $lineTotal = $item->soluong * $item->dongia;
            $tong_mat_hang_tinh_toan += $item->soluong;
            
            return [
                'product_name' => $productName,
                'variant_name' => $variantName,
                'so_luong' => $item->soluong,
                'don_gia' => number_format($item->dongia, 0, ',', '.'),
                'thanh_tien' => number_format($lineTotal, 0, ',', '.'),
                'product_image' => 'https://placehold.co/60x80/222222/ffffff?text=SP',
            ];
        });

        $this->formattedData = [
            'hoten' => $this->user->hoten,
            'madon' => $madon,
            'ngay_dat_hang' => $ngay_dat_hang,
            'link_theo_doi_don_hang' => route('chi-tiet-don-hang', $madon),
            
            // THAY THẾ CHUỖI HTML BẰNG COLLECTION
            'chi_tiet_don_hang' => $chi_tiet_don_hang,
            'tong_so_mat_hang' => $tong_mat_hang_tinh_toan,
            
            'tong_phu' => number_format($this->order->tamtinh, 0, ',', '.'),
            'phi_van_chuyen' => number_format($phi_van_chuyen_goc, 0, ',', '.'),
            'giam_gia_1' => number_format($giam_gia_1, 0, ',', '.'),
            'giam_gia_2' => number_format($phi_van_chuyen_giam, 0, ',', '.'),
            'tong_cong' => number_format($this->order->thanhtien, 0, ',', '.'),
            
            'nguoi_nhan' => optional($this->order->diachiNguoiDung)->hoten ?? 'N/A',
            'sdt' => optional($this->order->diachiNguoiDung)->sodienthoai ?? 'N/A',
            'dia_chi_chi_tiet' => optional($this->order->diachiNguoiDung)->diachi ?? 'N/A',
            'tinh_thanh' => optional($this->order->diachiNguoiDung)->tinhthanh ?? 'N/A',
            'email_nguoi_nhan' => $this->user->email,
            'link_trung_tam_tro_giup' => 'https://yourdomain.com/help',
        ];
    }
}