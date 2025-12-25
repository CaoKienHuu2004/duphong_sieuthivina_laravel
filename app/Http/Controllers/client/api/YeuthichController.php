<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YeuthichModel;
use App\Models\SanphamModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class YeuthichController extends Controller
{
    /**
     * 1. XEM DANH SÁCH YÊU THÍCH
     */
    public function index()
    {
        $userId = Auth::guard('sanctum')->id();

        // Lấy danh sách yêu thích kèm thông tin sản phẩm và ảnh
        $favorites = YeuthichModel::with(['sanpham.hinhanhsanpham', 'sanpham.thuonghieu'])
            ->where('id_nguoidung', $userId)
            ->orderByDesc('id') // Mới nhất lên đầu
            ->get();

        // Format lại dữ liệu (xử lý link ảnh)
        $data = $favorites->map(function ($item) {
            $sp = $item->sanpham;
            
            // Lấy ảnh đầu tiên
            $hinhAnh = null;
            if ($sp && $sp->hinhanhsanpham->count() > 0) {
                $hinhAnh = asset('assets/client/images/thumbs/' . $sp->hinhanhsanpham->first()->hinhanh);
            }

            return [
                'id_yeuthich' => $item->id,
                'id_sanpham' => $sp->id,
                'ten_sanpham' => $sp->ten,
                'slug' => $sp->slug,
                'thuonghieu' => $sp->thuonghieu->ten ?? '',
                'hinhanh' => $hinhAnh ?? asset('assets/client/images/thumbs/product-placeholder.png'),
                'giaban' => $sp->giaban ?? 0, // Hoặc giadagiam tùy logic DB của bạn
                'giagoc' => $sp->giagoc ?? 0,
                'ngay_them' => $item->created_at->format('d/m/Y')
            ];
        });

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * 2. THÊM VÀO YÊU THÍCH (Toggle: Nếu có rồi thì báo đã có)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sanpham' => 'required|exists:sanpham,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => $validator->errors()->first()], 422);
        }

        $userId = Auth::guard('sanctum')->id();
        $proId = $request->id_sanpham;

        // Kiểm tra đã tồn tại chưa
        $exists = YeuthichModel::where('id_nguoidung', $userId)
            ->where('id_sanpham', $proId)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 200, 
                'message' => 'Sản phẩm này đã có trong danh sách yêu thích!'
            ]);
        }

        // Tạo mới
        YeuthichModel::create([
            'id_nguoidung' => $userId,
            'id_sanpham' => $proId
        ]);

        return response()->json([
            'status' => 201, 
            'message' => 'Đã thêm vào danh sách yêu thích thành công!'
        ]);
    }

    /**
     * 3. XÓA KHỎI YÊU THÍCH
     * Param: id_sanpham (để tiện cho FE gọi khi đang ở trang detail sản phẩm)
     */
    public function destroy($id_sanpham)
    {
        $userId = Auth::guard('sanctum')->id();

        $deleted = YeuthichModel::where('id_nguoidung', $userId)
            ->where('id_sanpham', $id_sanpham)
            ->delete();

        if ($deleted) {
            return response()->json([
                'status' => 200, 
                'message' => 'Đã xóa khỏi danh sách yêu thích.'
            ]);
        }

        return response()->json([
            'status' => 404, 
            'message' => 'Sản phẩm không tồn tại trong danh sách yêu thích.'
        ], 404);
    }
}