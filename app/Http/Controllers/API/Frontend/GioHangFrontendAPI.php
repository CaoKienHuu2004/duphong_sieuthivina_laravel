<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiohangModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class GioHangFrontendAPI extends BaseFrontendController
{
    /** 🧺 Lấy toàn bộ giỏ hàng của người dùng hiện tại */
    public function index(Request $request)
    {
        // $userId = $request->user()->id;
        // Lấy user từ middleware
        $user = $request->get('auth_user');
        $userId = $user->id;

        $giohang = GiohangModel::with(['bienthe.sanpham'])
            ->where('id_nguoidung', $userId)
            ->where('trangthai', 'Hiển thị')
            ->get();

        return $this->jsonResponse([
            'status' => true,
            'message' => $giohang->isEmpty() ? 'Giỏ hàng trống' : 'Danh sách sản phẩm trong giỏ hàng',
            'data' => $giohang,
        ], Response::HTTP_OK);
    }

    /** ➕ Thêm sản phẩm vào giỏ hàng */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_bienthe' => 'required|exists:bienthe,id',
            'soluong' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->id;
        $gia = DB::table('bienthe')->where('id', $validated['id_bienthe'])->value('gia');

        // Kiểm tra nếu sản phẩm đã có trong giỏ → cập nhật
        $item = GiohangModel::where('id_nguoidung', $userId)
            ->where('id_bienthe', $validated['id_bienthe'])
            ->first();

        if ($item) {
            $item->soluong += $validated['soluong'];
            $item->thanhtien = $gia * $item->soluong;
            $item->save();
        } else {
            $item = GiohangModel::create([
                'id_bienthe' => $validated['id_bienthe'],
                'id_nguoidung'=> $userId,
                'soluong' => $validated['soluong'],
                'thanhtien' => $gia * $validated['soluong'],
                'trangthai' => 'Hiển thị',
            ]);
        }

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            'data' => $item->load('bienthe.sanpham'),
        ], Response::HTTP_CREATED);
    }

    /** 🔄 Cập nhật số lượng sản phẩm trong giỏ hàng */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'soluong' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->id;
        $item = GiohangModel::where('id_nguoidung', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $gia = DB::table('bienthe')->where('id', $item->id_bienthe)->value('gia');

        $item->update([
            'soluong' => $validated['soluong'],
            'thanhtien' => $gia * $validated['soluong'],
        ]);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Cập nhật số lượng thành công',
            'data' => $item->load('bienthe.sanpham'),
        ], Response::HTTP_OK);
    }

    /** ❌ Xóa sản phẩm khỏi giỏ hàng */
    public function destroy(Request $request, $id)
    {
        $userId = $request->user()->id;
        $item = GiohangModel::where('id_nguoidung', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $item->delete(); // xóa trực tiếp

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công',
            'data' => [],
        ], Response::HTTP_OK);
    }
}
