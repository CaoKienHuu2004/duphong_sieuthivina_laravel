<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\QuangcaoModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BannerQuangCaoFrontendAPI extends BaseFrontendController
{
    /**
     * 📄 Lấy danh sách banner (có phân trang nếu có per_page)
     */
    public function index(Request $request)
    {
        $query = QuangcaoModel::query();

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where('mota', 'like', "%{$q}%")
                  ->orWhere('vitri', 'like', "%{$q}%");
        }

        if ($request->has('per_page')) {
            $perPage = (int) $request->get('per_page', 5);
            $banners = $query->orderByDesc('created_at')->paginate($perPage);

            return $this->jsonResponse([
                'status' => true,
                'message' => 'Danh sách banner',
                'data' => $banners->items(),
                'meta' => [
                    'current_page' => $banners->currentPage(),
                    'last_page' => $banners->lastPage(),
                    'per_page' => $banners->perPage(),
                    'total' => $banners->total(),
                    'next_page_url' => $banners->nextPageUrl(),
                    'prev_page_url' => $banners->previousPageUrl(),
                ]
            ], Response::HTTP_OK);
        }

        $banners = $query->orderByDesc('created_at')->get();

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Danh sách banner',
            'data' => $banners
        ], Response::HTTP_OK);
    }

    /**
     * ➕ Tạo mới banner quảng cáo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vitri' => 'required|string|max:255',
            'hinhanh' => 'required|string|max:255',
            'lienket' => 'required|string',
            'mota' => 'nullable|string',
            'trangthai' => 'in:Hiển thị,Tạm ẩn',
        ]);

        $banner = QuangcaoModel::create([
            'vitri' => $validated['vitri'],
            'hinhanh' => $validated['hinhanh'],
            'lienket' => $validated['lienket'],
            'mota' => $validated['mota'] ?? null,
            'trangthai' => $validated['trangthai'] ?? 'Hiển thị',
        ]);

        return $this->jsonResponse([
            'status' => true,
            'message' => '🟢 Tạo banner thành công',
            'data' => $banner
        ], Response::HTTP_CREATED);
    }

    /**
     * 🔍 Xem chi tiết banner
     */
    public function show($id)
    {
        $banner = QuangcaoModel::findOrFail($id);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Chi tiết banner',
            'data' => $banner
        ], Response::HTTP_OK);
    }

    /**
     * ✏️ Cập nhật banner
     */
    public function update(Request $request, $id)
    {
        $banner = QuangcaoModel::findOrFail($id);

        $validated = $request->validate([
            'vitri' => 'sometimes|string|max:255',
            'hinhanh' => 'sometimes|string|max:255',
            'lienket' => 'sometimes|string',
            'mota' => 'sometimes|string|nullable',
            'trangthai' => 'sometimes|in:Hiển thị,Tạm ẩn',
        ]);

        $banner->update($validated);

        return $this->jsonResponse([
            'status' => true,
            'message' => '🟡 Cập nhật banner thành công',
            'data' => $banner
        ], Response::HTTP_OK);
    }

    /**
     * ❌ Xóa banner
     */
    public function destroy($id)
    {
        $banner = QuangcaoModel::findOrFail($id);
        $banner->delete();

        return $this->jsonResponse([
            'status' => true,
            'message' => '🔴 Xóa banner thành công'
        ], Response::HTTP_OK);
    }
}
