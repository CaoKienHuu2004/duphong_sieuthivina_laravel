<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TukhoaModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TukhoaFrontendAPI extends BaseFrontendController
{
    /**
     * Danh sách từ khóa (có thể tìm kiếm, phân trang)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $q = $request->get('q');

        $query = TukhoaModel::query();

        if ($q) {
            $query->where('tukhoa', 'like', "%{$q}%");
        }

        $tuKhoa = $query->orderByDesc('luottruycap')->paginate($perPage);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Danh sách từ khóa',
            'data' => $tuKhoa->items(),
            'meta' => [
                'current_page' => $tuKhoa->currentPage(),
                'last_page' => $tuKhoa->lastPage(),
                'per_page' => $tuKhoa->perPage(),
                'total' => $tuKhoa->total(),
                'next_page_url' => $tuKhoa->nextPageUrl(),
                'prev_page_url' => $tuKhoa->previousPageUrl(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Tạo mới một từ khóa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tukhoa' => 'required|string|max:255',
            'luottruycap' => 'nullable|integer|min:0',
        ]);

        $tuKhoa = TukhoaModel::create([
            'tukhoa' => $validated['tukhoa'],
            'luottruycap' => $validated['luottruycap'] ?? 0,
        ]);

        return $this->jsonResponse([
            'status' => true,
            'message' => '✅ Tạo từ khóa thành công',
            'data' => $tuKhoa,
        ], Response::HTTP_CREATED);
    }

    /**
     * Hiển thị chi tiết một từ khóa
     */
    public function show($id)
    {
        $tuKhoa = TukhoaModel::findOrFail($id);

        return $this->jsonResponse([
            'status' => true,
            'message' => '📄 Chi tiết từ khóa',
            'data' => $tuKhoa,
        ], Response::HTTP_OK);
    }

    /**
     * Cập nhật từ khóa hoặc tăng số lượt truy cập
     */
    public function update(Request $request, $id)
    {
        $tuKhoa = TukhoaModel::findOrFail($id);

        // Nếu có dữ liệu cập nhật cụ thể
        if ($request->has('tukhoa') || $request->has('luottruycap')) {
            $validated = $request->validate([
                'tukhoa' => 'sometimes|string|max:255',
                'luottruycap' => 'sometimes|integer|min:0',
            ]);

            $tuKhoa->update($validated);
        } else {
            // Nếu không có dữ liệu cụ thể thì tăng lượt truy cập lên 1
            $tuKhoa->increment('luottruycap');
            $tuKhoa->refresh();
        }

        return $this->jsonResponse([
            'status' => true,
            'message' => '🔄 Cập nhật từ khóa thành công',
            'data' => $tuKhoa,
        ], Response::HTTP_OK);
    }

    /**
     * Xóa từ khóa
     */
    public function destroy($id)
    {
        $tuKhoa = TukhoaModel::findOrFail($id);
        $tuKhoa->delete();

        return $this->jsonResponse([
            'status' => true,
            'message' => '🗑️ Xóa từ khóa thành công',
        ], Response::HTTP_OK);
    }
}
