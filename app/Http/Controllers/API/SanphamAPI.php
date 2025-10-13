<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SanphamModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SanphamAPI extends Controller
{
    /**
     * Danh sách sản phẩm (có lọc + phân trang)
     */
    public function index(Request $request)
    {
        $perPage     = $request->get('per_page', 20);
        $currentPage = $request->get('page', 1);
        $thuonghieu  = $request->get('thuonghieu');
        $trangthai   = $request->get('trangthai');
        $cuahang     = $request->get('id_cuahang');
        $q           = $request->get('q'); // từ khóa tìm kiếm

        $query = SanphamModel::with(['cuahang', 'danhmuc', 'hinhanhsanpham', 'bienthe'])
            ->latest('updated_at');

        // Tìm kiếm theo tên, slug hoặc mô tả
        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('ten', 'like', "%$q%")
                    ->orWhere('slug', 'like', "%$q%")
                    ->orWhere('mota', 'like', "%$q%");
            });
        }

        // Lọc theo thương hiệu
        if ($thuonghieu) {
            $query->where('thuonghieu', 'like', "%$thuonghieu%");
        }

        // Lọc theo trạng thái
        if ($trangthai) {
            $query->where('trangthai', $trangthai);
        }

        // Lọc theo cửa hàng
        if ($cuahang) {
            $query->where('id_cuahang', (int) $cuahang);
        }

        // Phân trang
        $items = $query->paginate($perPage, ['*'], 'page', $currentPage);

        // Nếu người dùng nhập page vượt quá last_page
        if ($currentPage > $items->lastPage() && $currentPage > 1) {
            return response()->json([
                'status'  => false,
                'message' => 'Trang không tồn tại. Trang cuối cùng là ' . $items->lastPage(),
                'meta'    => [
                    'current_page' => $currentPage,
                    'last_page'    => $items->lastPage(),
                    'per_page'     => $perPage,
                    'total'        => $items->total(),
                ]
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Danh sách sản phẩm',
            'data'    => $items->items(),
            'meta'    => [
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'per_page'     => $items->perPage(),
                'total'        => $items->total(),
                'next_page_url' => $items->nextPageUrl(),
                'prev_page_url' => $items->previousPageUrl(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Thêm sản phẩm mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cuahang'  => 'required|integer|exists:cuahang,id',
            'ten'         => 'required|string|max:255',
            'slug'        => 'required|string|max:255',
            'mota'        => 'nullable|string',
            'xuatxu'      => 'nullable|string|max:255',
            'sanxuat'     => 'nullable|string|max:255',
            'trangthai'   => 'required|in:Công khai,Chờ duyệt,Tạm ẩn,Tạm khóa',
            'giamgia'     => 'nullable|integer|min:0',
            'luotxem'     => 'nullable|integer|min:0',
            'luotban'     => 'nullable|integer|min:0',
            'thuonghieu'  => 'nullable|string|max:255',
        ]);

        $product = SanphamModel::create($validated);

        // Gán danh mục nếu có
        if ($request->has('id_danhmuc')) {
            $product->danhmuc()->sync($request->id_danhmuc);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Thêm sản phẩm thành công',
            'data'    => $product->load(['cuahang', 'danhmuc']),
        ], Response::HTTP_CREATED);
    }

    /**
     * Xem chi tiết sản phẩm
     */
    public function show(string $id)
    {
        $product = SanphamModel::with(['cuahang', 'danhmuc', 'hinhanhsanpham', 'bienthe'])
            ->findOrFail($id);

        return response()->json([
            'status'  => true,
            'message' => 'Chi tiết sản phẩm',
            'data'    => $product,
        ], Response::HTTP_OK);
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, string $id)
    {
        $product = SanphamModel::findOrFail($id);

        $validated = $request->validate([
            'ten'         => 'sometimes|string|max:255',
            'slug'        => 'sometimes|string|max:255',
            'mota'        => 'nullable|string',
            'xuatxu'      => 'nullable|string|max:255',
            'sanxuat'     => 'nullable|string|max:255',
            'trangthai'   => 'nullable|in:Công khai,Chờ duyệt,Tạm ẩn,Tạm khóa',
            'giamgia'     => 'nullable|integer|min:0',
            'thuonghieu'  => 'nullable|string|max:255',
        ]);

        $product->update($validated);

        if ($request->has('id_danhmuc')) {
            $product->danhmuc()->sync($request->id_danhmuc);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Cập nhật sản phẩm thành công',
            'data'    => $product->refresh()->load(['cuahang', 'danhmuc']),
        ], Response::HTTP_OK);
    }

    /**
     * Xóa mềm sản phẩm
     */
    public function destroy(string $id)
    {
        $product = SanphamModel::findOrFail($id);
        $product->delete(); // xóa mềm nhờ SoftDeletes

        return response()->json([
            'status'  => true,
            'message' => 'Đã xóa sản phẩm (xóa mềm)',
        ], Response::HTTP_OK);
    }

    /**
     * Khôi phục sản phẩm đã xóa mềm
     */
    public function restore(string $id)
    {
        $product = SanphamModel::onlyTrashed()->findOrFail($id);
        $product->restore();

        return response()->json([
            'status'  => true,
            'message' => 'Khôi phục sản phẩm thành công',
            'data'    => $product,
        ], Response::HTTP_OK);
    }

    /**
     * Xóa vĩnh viễn sản phẩm
     */
    public function forceDestroy(string $id)
    {
        $product = SanphamModel::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return response()->json([
            'status'  => true,
            'message' => 'Đã xóa vĩnh viễn sản phẩm',
        ], Response::HTTP_OK);
    }
}
