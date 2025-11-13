<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\DiachinguoidungModel;
use Illuminate\Support\Facades\DB;

class DiachiController extends Controller
{
    /**
     * Hiển thị danh sách địa chỉ của người dùng để chọn.
     */
    public function index()
    {
        $diachis = DiachinguoidungModel::where('id_nguoidung', Auth::id())->orderBy('trangthai', 'asc')->get();

        if ($diachis->isEmpty()) {
            return redirect()->route('them-dia-chi-giao-hang')->with('info', 'Bạn chưa có địa chỉ nào được lưu. Vui lòng thêm địa chỉ mới.');
        }
        
        return view('client.nguoidung.sodiachi', compact('diachis'));
    }

    public function taodiachi()
    {
        $tinhThanhs = collect([]);
        $apiUrl = 'https://provinces.open-api.vn/api/v1/'; // API mẫu

        try {
            // *** BƯỚC 1: GỌI API LẤY DANH SÁCH TỈNH/THÀNH PHỐ ***
            $response = Http::timeout(5)->get($apiUrl);

            if ($response->successful()) {
                // Giả định API trả về JSON chứa mảng các tỉnh thành
                $tinhThanhs = collect($response->json());
                
                // Sắp xếp theo tên (nếu cần)
                $tinhThanhs = $tinhThanhs->sortBy('name'); 
            } else {
                 // Xử lý lỗi API (ví dụ: API trả về mã lỗi 4xx, 5xx)
                 // Trong thực tế, bạn nên log lỗi hoặc hiển thị thông báo thân thiện hơn
                 \Log::error('API Tỉnh/Thành phố trả về lỗi: ' . $response->status());
            }

        } catch (\Exception $e) {
            // Xử lý lỗi kết nối (timeout, mạng,...)
            \Log::error('Lỗi kết nối API Tỉnh/Thành phố: ' . $e->getMessage());
            // Có thể gán mảng rỗng để form vẫn tải nhưng không có dữ liệu
        }

        // return response()->json([
        //     'tinhThanhs' => $tinhThanhs,
        // ]);
        return view('client.nguoidung.taodiachi',compact('tinhThanhs'));
    }

    public function khoitaodiachi(Request $request)
    {
        $request->validate([
            // Trường từ form: hoten_nguoinhan, sodienthoai_nguoinhan
            'hoten' => 'required|string|max:255',
            'sodienthoai' => 'required|string|max:20',
            'tinhthanh' => 'required|string',
            'diachi' => 'required|string|max:255',
        ], [
            // Thông báo lỗi tiếng Việt
            'required' => 'Trường :attribute là bắt buộc.',
            'max' => 'Trường :attribute không được vượt quá :max ký tự.',
            'hoten.required' => 'Vui lòng nhập Họ tên Người nhận.',
            'sodienthoai.required' => 'Vui lòng nhập Số điện thoại.',
            'tinhthanh.required' => 'Vui lòng chọn Tỉnh/Thành phố.',
            'diachi.required' => 'Vui lòng nhập Địa chỉ chi tiết.',
        ]);

        $isDefault = $request->has('trangthai');

        if ($isDefault) {
            DiachinguoidungModel::where('id_nguoidung', Auth::id())
                                ->update(['trangthai' => 'Khác']);
        }

        // 4. LƯU ĐỊA CHỈ MỚI VÀO DATABASE
        try {
            DiachinguoidungModel::create([
                'id_nguoidung' => Auth::id(),
                'hoten' => $request->hoten,
                'sodienthoai' => $request->sodienthoai,
                'diachi' => $request->diachi,
                'tinhthanh' => $request->tinhthanh,
                'trangthai' => $isDefault ? 'Mặc định' : 'Khác', 
            ]);

            return back()->with('success', 'Đã thêm địa chỉ giao hàng mới thành công!');

        } catch (\Exception $e) {
            // Log lỗi
            \Log::error("Lỗi khi thêm địa chỉ: " . $e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: Không thể lưu địa chỉ. Vui lòng thử lại.')->withInput();
        }
    }

    public function suadiachi()
    {
        return view('client.nguoidung.suadiachi');
    }

    public function capnhatdiachi()
    {
        return view('client.nguoidung.sodiachi');
    }


    /**
     * Xử lý cập nhật địa chỉ được chọn thành 'Mặc định'.
     */
    public function updateDefaultAddress(Request $request)
    {
        $request->validate([
            'id_diachi' => 'required|exists:diachi_nguoidung,id',
        ]);

        $id_diachi_moi = $request->id_diachi;
        $id_nguoidung = Auth::id();

        DB::beginTransaction();
        try {
            // 1. Reset tất cả địa chỉ của người dùng này về trạng thái 'Bình thường' (ví dụ)
            DiachinguoidungModel::where('id_nguoidung', $id_nguoidung)
                                ->where('trangthai', 'Mặc định')
                                ->update(['trangthai' => 'Khác']);

            // 2. Đặt địa chỉ mới được chọn thành 'Mặc định'
            $diachi_moi = DiachinguoidungModel::find($id_diachi_moi);
            if ($diachi_moi && $diachi_moi->id_nguoidung == $id_nguoidung) {
                $diachi_moi->trangthai = 'Mặc định';
                $diachi_moi->save();
            } else {
                 DB::rollBack();
                 return redirect()->back()->with('error', 'Địa chỉ không hợp lệ.');
            }

            DB::commit();
            return redirect()->route('thanh-toan')->with('success', 'Đã cập nhật địa chỉ mặc định thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi khi cập nhật địa chỉ: ' . $e->getMessage());
        }
    }
}