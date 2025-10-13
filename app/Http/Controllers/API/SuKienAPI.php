<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SukienModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SuKienAPI extends BaseController
{
    /**
     * Lấy danh sách sự kiện (phân trang + tìm kiếm)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $q = $request->get('q'); // từ khóa tìm kiếm

        $query = SukienModel::query();

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('tieude', 'like', "%$q%")
                    ->orWhere('slug', 'like', "%$q%")
                    ->orWhere('noidung', 'like', "%$q%");
            });
        }

        $items = $query->latest('created_at')->paginate($perPage);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Danh sách sự kiện',
            'data' => $items,
        ], Response::HTTP_OK);
    }

    /**
     * Lấy chi tiết một sự kiện
     */
    public function show($id)
    {
        $item = SukienModel::findOrFail($id);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Chi tiết sự kiện',
            'data' => $item,
        ], Response::HTTP_OK);
    }

    /**
     * Tạo mới một sự kiện (admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieude'      => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:sukien,slug',
            'hinhanh'     => 'required|string|max:255',
            'noidung'     => 'required|string',
            'ngaybatdau'  => 'required|date',
            'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau',
            'trangthai'   => 'nullable|in:Hiển thị,Tạm ẩn',
        ]);

        $item = SukienModel::create($validated);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Tạo sự kiện thành công',
            'data' => $item,
        ], Response::HTTP_CREATED);
    }

    /**
     * Cập nhật thông tin sự kiện
     */
    public function update(Request $request, $id)
    {
        $item = SukienModel::findOrFail($id);

        $validated = $request->validate([
            'tieude'      => 'sometimes|required|string|max:255',
            'slug'        => 'sometimes|required|string|max:255|unique:sukien,slug,' . $item->id,
            'hinhanh'     => 'sometimes|required|string|max:255',
            'noidung'     => 'sometimes|required|string',
            'ngaybatdau'  => 'sometimes|required|date',
            'ngayketthuc' => 'sometimes|required|date|after_or_equal:ngaybatdau',
            'trangthai'   => 'nullable|in:Hiển thị,Tạm ẩn',
        ]);

        $item->update($validated);

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Cập nhật sự kiện thành công',
            'data' => $item,
        ], Response::HTTP_OK);
    }

    /**
     * Xóa mềm sự kiện
     */
    public function destroy($id)
    {
        $item = SukienModel::findOrFail($id);
        $item->delete(); // nhờ SoftDeletes => chỉ cập nhật deleted_at

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Đã xóa (ẩn) sự kiện thành công',
        ], Response::HTTP_OK);
    }

    /**
     * Khôi phục sự kiện đã xóa mềm
     */
    public function restore($id)
    {
        $item = SukienModel::onlyTrashed()->findOrFail($id);
        $item->restore();

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Khôi phục sự kiện thành công',
            'data' => $item,
        ], Response::HTTP_OK);
    }

    /**
     * Xóa vĩnh viễn sự kiện (hard delete)
     */
    public function forceDelete($id)
    {
        $item = SukienModel::onlyTrashed()->findOrFail($id);
        $item->forceDelete();

        return $this->jsonResponse([
            'status' => true,
            'message' => 'Đã xóa vĩnh viễn sự kiện',
        ], Response::HTTP_OK);
    }
}
