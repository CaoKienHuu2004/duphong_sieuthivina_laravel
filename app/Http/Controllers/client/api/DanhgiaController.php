<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // [QUAN TRỌNG] Dùng để join thủ công
use App\Models\DanhgiaModel;
use App\Models\BientheModel;
use App\Models\SanphamModel;

class DanhgiaController extends Controller
{
    /**
     * 1. GỬI ĐÁNH GIÁ (STORE)
     * Method: POST
     * Body: { id_chitietdonhang: 1, diem: 5, noidung: "..." }
     */
    public function store(Request $request)
    {
        // 1. Validate
        $validator = Validator::make($request->all(), [
            'id_chitietdonhang' => 'required|exists:chitiet_donhang,id',
            'diem' => 'required|integer|min:1|max:5',
            'noidung' => 'nullable|string|max:500',
        ], [
            'id_chitietdonhang.exists' => 'Chi tiết đơn hàng không tồn tại.',
            'diem.min' => 'Vui lòng chọn ít nhất 1 sao.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        // 2. [FIX LỖI SQL] Dùng Query Builder Join trực tiếp (Bypass Model)
        // Lưu ý: Tôi đang dùng 'chitiet_donhang.id_donhang' để join với 'donhang.id'
        // Nếu DB bạn cột tên là 'donhang_id' hay 'madonhang', hãy sửa chữ 'id_donhang' bên dưới nhé.
        
        $chiTiet = DB::table('chitiet_donhang')
            ->join('donhang', 'chitiet_donhang.id_donhang', '=', 'donhang.id') 
            ->where('chitiet_donhang.id', $request->id_chitietdonhang)
            ->select(
                'chitiet_donhang.*', 
                'donhang.id_nguoidung as donhang_id_nguoidung', 
                'donhang.trangthai as donhang_trangthai'
            )
            ->first();

        // Check 2.1: Có tìm thấy không?
        if (!$chiTiet) {
            return response()->json(['status' => 404, 'message' => 'Dữ liệu đơn hàng bị lỗi hoặc không tồn tại.'], 404);
        }

        // Check 2.2: Chính chủ (User đang login phải là chủ đơn hàng)
        if ($chiTiet->donhang_id_nguoidung != $user->id) {
            return response()->json(['status' => 403, 'message' => 'Bạn không có quyền đánh giá đơn hàng này.'], 403);
        }

        // Check 2.3: Trạng thái đơn hàng
        // Kiểm tra kỹ trong DB xem bạn lưu là 'Đã giao hàng', 'Hoàn thành' hay 'Giao thành công'
        if ($chiTiet->donhang_trangthai !== 'Đã giao hàng') { 
            return response()->json(['status' => 400, 'message' => 'Bạn chỉ có thể đánh giá khi đơn hàng đã giao thành công.'], 400);
        }

        // Check 2.4: Đã đánh giá chưa (Chống spam)
        $daDanhGia = DanhgiaModel::where('id_chitietdonhang', $request->id_chitietdonhang)->exists();
        if ($daDanhGia) {
            return response()->json(['status' => 400, 'message' => 'Sản phẩm này bạn đã đánh giá rồi.'], 400);
        }

        // 3. Lấy ID Sản phẩm gốc từ Biến thể
        // (Bảng chitiet_donhang chỉ lưu id_bienthe, ta cần id_sanpham cho bảng danhgia)
        $bienthe = BientheModel::find($chiTiet->id_bienthe);
        $idSanPham = $bienthe ? $bienthe->id_sanpham : null;

        if (!$idSanPham) {
            return response()->json(['status' => 500, 'message' => 'Lỗi dữ liệu: Không tìm thấy sản phẩm gốc.'], 500);
        }

        // 4. Lưu đánh giá
        try {
            $danhGia = DanhgiaModel::create([
                'id_sanpham' => $idSanPham,
                'id_nguoidung' => $user->id,
                'id_chitietdonhang' => $request->id_chitietdonhang,
                'diem' => $request->diem,
                'noidung' => $request->noidung,
                'trangthai' => 'Hiển thị' // Mặc định hiện luôn
            ]);

            return response()->json([
                'status' => 201, 
                'message' => 'Cảm ơn bạn đã đánh giá sản phẩm!',
                'data' => $danhGia
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }

    /**
     * 2. LẤY DANH SÁCH ĐÁNH GIÁ (INDEX)
     * Method: GET
     * URL: /api/san-pham/{slug}/danh-gia
     */
    public function index($slug)
    {
        // 1. Tìm Sản phẩm từ Slug
        $sanpham = SanphamModel::where('slug', $slug)->first();

        if (!$sanpham) {
            return response()->json(['status' => 404, 'message' => 'Sản phẩm không tồn tại.'], 404);
        }

        $id_sanpham = $sanpham->id;

        // 2. Lấy danh sách đánh giá (Phân trang)
        $listDanhGia = DanhgiaModel::with(['nguoidung' => function($query) {
                $query->select('id', 'hoten', 'avatar');
            }])
            ->where('id_sanpham', $id_sanpham)
            ->where('trangthai', 'Hiển thị')
            ->orderBy('diem', 'desc') // Mặc định hiển thị sao cao nhất trước
            ->paginate(5);


            // Duyệt qua từng đánh giá trong trang hiện tại để sửa link ảnh
        $listDanhGia->getCollection()->transform(function ($danhGia) {
            if ($danhGia->nguoidung) {
                $avatarGoc = $danhGia->nguoidung->avatar;

                // Case 1: Nếu chưa có avatar -> Trả về ảnh mặc định
                if (empty($avatarGoc)) {
                    $danhGia->nguoidung->avatar = asset('assets/client/images/thumbs/default-user.png');
                } 
                // Case 2: Nếu là ảnh từ Google/Facebook (bắt đầu bằng http) -> Giữ nguyên
                elseif (str_starts_with($avatarGoc, 'http')) {
                    $danhGia->nguoidung->avatar = $avatarGoc;
                } 
                // Case 3: Ảnh upload local -> Thêm đường dẫn asset
                else {
                    // Bạn kiểm tra lại folder chứa avatar của bạn có phải là 'thumbs' không nhé
                    $danhGia->nguoidung->avatar = asset('assets/client/images/thumbs/' . $avatarGoc);
                }
            }
            return $danhGia;
        });
        // 3. THỐNG KÊ CHI TIẾT (Điểm TB, Tổng số, Chi tiết từng sao)
        // Kỹ thuật: Dùng SUM(CASE...) để đếm trong 1 lần truy vấn duy nhất -> Rất nhanh
        $thongKe = DanhgiaModel::where('id_sanpham', $id_sanpham)
            ->where('trangthai', 'Hiển thị')
            ->selectRaw('
                count(*) as total, 
                avg(diem) as average_rating,
                sum(case when diem = 5 then 1 else 0 end) as nam_sao,
                sum(case when diem = 4 then 1 else 0 end) as bon_sao,
                sum(case when diem = 3 then 1 else 0 end) as ba_sao,
                sum(case when diem = 2 then 1 else 0 end) as hai_sao,
                sum(case when diem = 1 then 1 else 0 end) as mot_sao
            ')
            ->first();

        return response()->json([
            'status' => 200,
            'thong_ke' => [
                'diem_trung_binh' => round($thongKe->average_rating ?? 0, 1),
                'tong_so_danh_gia' => $thongKe->total,
                'chi_tiet_sao' => [
                    '5_sao' => (int) $thongKe->nam_sao,
                    '4_sao' => (int) $thongKe->bon_sao,
                    '3_sao' => (int) $thongKe->ba_sao,
                    '2_sao' => (int) $thongKe->hai_sao,
                    '1_sao' => (int) $thongKe->mot_sao,
                ]
            ],
            'data' => $listDanhGia
        ]);
    }
}