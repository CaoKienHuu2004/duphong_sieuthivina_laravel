<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\DiachinguoidungModel;
use App\Models\DonhangModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DiachiController extends Controller
{
    /**
     * Lấy danh sách địa chỉ của user hiện tại
     * Method: GET
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
             return response()->json(['status' => 401, 'message' => 'Chưa đăng nhập'], 401);
        }

        $diachis = DiachinguoidungModel::where('id_nguoidung', $user->id)
            ->orderBy('trangthai', 'asc') // Để 'Mặc định' lên đầu hoặc cuối tùy logic của bạn (asc: K-M, desc: M-K)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $diachis,
            'message' => $diachis->isEmpty() ? 'Chưa có địa chỉ nào.' : 'Lấy danh sách thành công.'
        ]);
    }

    /**
     * Lấy danh sách Tỉnh/Thành phố (Proxy API)
     * Method: GET
     * Note: Frontend Next.js nên gọi trực tiếp API Open Provinces sẽ nhanh hơn, 
     * nhưng nếu bạn muốn giấu logic thì gọi qua đây.
     */
    public function getProvinces()
    {
        $apiUrl = 'https://provinces.open-api.vn/api/v1/';

        try {
            $response = Http::timeout(5)->get($apiUrl);

            if ($response->successful()) {
                $tinhThanhs = collect($response->json())->sortBy('name')->values()->all();
                return response()->json(['status' => 200, 'data' => $tinhThanhs]);
            }

            return response()->json(['status' => 500, 'message' => 'Lỗi từ API thứ 3'], 500);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Lỗi kết nối: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Thêm mới địa chỉ
     * Method: POST
     */
    public function store(Request $request)
    {
        // 1. Validate
        $validator = Validator::make($request->all(), [
            'hoten' => 'required|string|max:255',
            'sodienthoai' => 'required|string|max:20',
            'tinhthanh' => 'required|string',
            'diachi' => 'required|string|max:255',
            'trangthai' => 'nullable|string' // FE gửi lên 'Mặc định' hoặc 'Khác'
        ], [
            'required' => ':attribute không được để trống.',
            'max' => ':attribute quá dài.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        $userId = Auth::id();
        $isDefault = $request->input('trangthai') === 'Mặc định';

        DB::beginTransaction();
        try {
            // 2. Nếu chọn mặc định, reset các cái cũ
            if ($isDefault) {
                DiachinguoidungModel::where('id_nguoidung', $userId)->update(['trangthai' => 'Khác']);
            } else {
                // Logic phụ: Nếu đây là địa chỉ ĐẦU TIÊN user tạo, ép nó thành Mặc định luôn
                $count = DiachinguoidungModel::where('id_nguoidung', $userId)->count();
                if ($count === 0) {
                    $isDefault = true;
                }
            }

            // 3. Tạo mới
            $newAddress = DiachinguoidungModel::create([
                'id_nguoidung' => $userId,
                'hoten' => $request->hoten,
                'sodienthoai' => $request->sodienthoai,
                'diachi' => $request->diachi,
                'tinhthanh' => $request->tinhthanh,
                'trangthai' => $isDefault ? 'Mặc định' : 'Khác', 
            ]);

            DB::commit();
            return response()->json([
                'status' => 201, 
                'message' => 'Thêm địa chỉ thành công!', 
                'data' => $newAddress
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Lỗi Server: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Lấy chi tiết 1 địa chỉ (để hiển thị lên form sửa)
     * Method: GET /diachi/{id}
     */
    public function show($id)
    {
        $diachi = DiachinguoidungModel::find($id);

        if (!$diachi || $diachi->id_nguoidung != Auth::id()) {
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy địa chỉ hoặc bạn không có quyền.'], 404);
        }

        return response()->json(['status' => 200, 'data' => $diachi]);
    }

    /**
     * Cập nhật địa chỉ
     * Method: PUT /diachi/{id}
     */
    public function update(Request $request, $id)
    {
        $diachi = DiachinguoidungModel::find($id);

        if (!$diachi || $diachi->id_nguoidung != Auth::id()) {
            return response()->json(['status' => 403, 'message' => 'Không có quyền truy cập.'], 403);
        }

        // 1. Validate
        $validator = Validator::make($request->all(), [
            'hoten' => 'required|string|max:255',
            'sodienthoai' => 'required|string|max:20',
            'tinhthanh' => 'required|string',
            'diachi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        // 2. Logic kiểm tra đơn hàng đang xử lý (Quan trọng)
        $diaChiDangBiKhoa = DonhangModel::where('id_diachinguoidung', $id)
            ->whereNotIn('trangthai', ['Đã giao hàng', 'Đã hủy đơn', 'Hoàn thành']) // Thêm 'Hoàn thành' nếu có status này
            ->exists();

        if ($diaChiDangBiKhoa) {
            return response()->json([
                'status' => 403, 
                'message' => 'Không thể sửa: Địa chỉ này đang gắn với đơn hàng chưa hoàn tất.'
            ], 403);
        }

        // 3. Xử lý update
        $isDefault = $request->input('trangthai') === 'Mặc định';

        DB::beginTransaction();
        try {
            if ($isDefault) {
                DiachinguoidungModel::where('id_nguoidung', Auth::id())->update(['trangthai' => 'Khác']);
            }

            $diachi->update([
                'hoten' => $request->hoten,
                'sodienthoai' => $request->sodienthoai,
                'tinhthanh' => $request->tinhthanh,
                'diachi' => $request->diachi,
                'trangthai' => $isDefault ? 'Mặc định' : 'Khác'
            ]);

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Cập nhật thành công!', 'data' => $diachi]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Lỗi update: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Xóa địa chỉ
     * Method: DELETE /diachi/{id}
     */
    public function destroy($id)
    {
        $diachi = DiachinguoidungModel::find($id);

        if (!$diachi || $diachi->id_nguoidung != Auth::id()) {
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy địa chỉ.'], 404);
        }

        // Kiểm tra xem địa chỉ có đang dùng cho đơn hàng nào không (kể cả đơn đã xong cũng không nên xóa để giữ lịch sử, hoặc chỉ xóa mềm)
        // Ở đây ta check đơn đang chạy thôi
        $dangSuDung = DonhangModel::where('id_diachinguoidung', $id)->exists();
        
        if ($dangSuDung) {
             return response()->json(['status' => 403, 'message' => 'Không thể xóa: Địa chỉ đã từng được dùng để đặt hàng.'], 403);
        }

        $diachi->delete();

        return response()->json(['status' => 200, 'message' => 'Xóa địa chỉ thành công.']);
    }

    /**
     * Set 1 địa chỉ làm mặc định nhanh
     * Method: PATCH /diachi/set-default/{id}
     */
    public function setDefault($id)
    {
        $diachi = DiachinguoidungModel::find($id);
        $userId = Auth::id();

        if (!$diachi || $diachi->id_nguoidung != $userId) {
            return response()->json(['status' => 404, 'message' => 'Địa chỉ không hợp lệ.'], 404);
        }

        DB::beginTransaction();
        try {
            // Reset all
            DiachinguoidungModel::where('id_nguoidung', $userId)->update(['trangthai' => 'Khác']);
            
            // Set one
            $diachi->trangthai = 'Mặc định';
            $diachi->save();

            DB::commit();
            return response()->json(['status' => 200, 'message' => 'Đã đặt làm địa chỉ mặc định.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }
}