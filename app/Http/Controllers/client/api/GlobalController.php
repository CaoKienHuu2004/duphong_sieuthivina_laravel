<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DanhmucModel;
use App\Models\TukhoaModel;
use App\Models\GiohangModel;
use App\Models\SanphamModel; // Thêm model sản phẩm để làm chức năng tìm kiếm
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // [MỚI] Để gửi mail
use Illuminate\Support\Facades\Validator;
use App\Mail\LienheMail;

class GlobalController extends Controller
{
    /**
     * 1. LẤY DỮ LIỆU CHUNG CHO HEADER (Thay thế ComposerServiceProvider)
     * API này Frontend sẽ gọi 1 lần khi load trang (Layout)
     * Method: GET
     */
    public function getHeaderData()
    {
        // 1. Lấy danh sách Danh mục (Menu)
        $danhmuc = DanhmucModel::select('id', 'ten', 'logo', 'slug')
            ->where('trangthai', 'Hiển thị') // Nên thêm điều kiện này cho chắc
            ->orderBy('sapxep', 'asc')
            ->get();

        // [MỚI] Duyệt qua danh sách để gắn đường dẫn asset cho logo
        $danhmuc->transform(function ($item) {
            if ($item->logo) {
                // Kiểm tra xem trong folder public của bạn, ảnh danh mục nằm ở đâu.
                // Thường là: assets/client/images/categories/
                $item->logo = asset('assets/client/images/categories/' . $item->logo);
            }
            return $item;
        });

        // 2. Lấy Từ khóa Placeholder ngẫu nhiên từ TOP 15
        $tukhoaplaceholder = "Tìm kiếm sản phẩm..."; // Mặc định
        $top15tukhoa = TukhoaModel::orderBy('luottruycap', 'desc')->take(15)->get();
        
        if ($top15tukhoa->isNotEmpty()) {
            $tukhoaplaceholder = $top15tukhoa->random()->tukhoa;
        }

        // 3. Lấy 5 Từ khóa Phổ biến (Top 5)
        $tukhoaphobien = TukhoaModel::select('tukhoa', 'luottruycap')
            ->orderBy('luottruycap', 'desc')
            ->take(5)
            ->get();

        // 4. Lấy số lượng giỏ hàng (Chỉ áp dụng cho User đã Login)
        // Lưu ý: Với API (Next.js), Backend không quản lý Session giỏ hàng của khách vãng lai.
        // Khách vãng lai sẽ lưu ở LocalStorage phía Frontend.
        $cartCount = 0;
        $cartItems = [];

        if (Auth::guard('sanctum')->check()) {
            $userId = Auth::guard('sanctum')->id();
            $cartItems = GiohangModel::where('id_nguoidung', $userId)->get();
            $cartCount = $cartItems->sum('soluong'); // Hoặc count() tùy logic bạn muốn hiển thị số dòng hay tổng số lượng
        }

        return response()->json([
            'status' => 200,
            'message' => 'Lấy dữ liệu header thành công',
            'data' => [
                'danhmuc' => $danhmuc,
                'tukhoa_placeholder' => $tukhoaplaceholder,
                'tukhoa_phobien' => $tukhoaphobien,
                'cart_auth_count' => $cartCount, // Frontend dùng cái này nếu user đã login
                // 'cart_auth_items' => $cartItems // Nếu muốn trả về chi tiết giỏ hàng luôn thì mở cái này
            ]
        ]);
    }

    /**
     * 2. XỬ LÝ GỬI LIÊN HỆ (Gửi mail đến Admin)
     * Method: POST
     */
    /**
     * GỬI LIÊN HỆ (Sử dụng Mail Template)
     * Method: POST
     * Body: hoten, email, sodienthoai, noidung
     */
    public function submitContact(Request $request)
    {
        // 1. Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'hoten' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sodienthoai' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'noidung' => 'required|string',
        ], [
            'hoten.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'sodienthoai.required' => 'Vui lòng nhập số điện thoại.',
            'noidung.required' => 'Vui lòng nhập nội dung.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Chuẩn bị dữ liệu gửi sang Template
            $dataInfo = [
                'hoten' => $request->hoten,
                'email' => $request->email,
                'phone' => $request->sodienthoai,
                'content' => $request->noidung,
                'time' => now()->format('d/m/Y H:i:s')
            ];

            // 3. Gửi Mail sử dụng Class Mailable (ContactEmail)
            // Gửi đến email quản trị viên (ví dụ: admin@sieuthivina.com)
            Mail::to('hotb@fpt.edu.vn')->send(new LienheMail($dataInfo));

            return response()->json([
                'status' => 200,
                'message' => 'Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Lỗi gửi mail: ' . $e->getMessage()
            ], 500);
        }
    }
}