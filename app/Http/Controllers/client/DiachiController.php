<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\DiachinguoidungModel;
use App\Models\DonhangModel;
use Illuminate\Support\Facades\Crypt;
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
    // URL lấy tất cả tỉnh thành
    $apiUrl = 'https://provinces.open-api.vn/api/p/'; 

    try {
        $response = Http::timeout(5)->get($apiUrl);

        if ($response->successful()) {
            $tinhThanhs = collect($response->json());
            // Sắp xếp theo code hoặc tên tùy ý
            $tinhThanhs = $tinhThanhs->sortBy('code'); 
        } else {
            \Log::error('Lỗi API Tỉnh thành: ' . $response->status());
        }
    } catch (\Exception $e) {
        \Log::error('Exception API Tỉnh thành: ' . $e->getMessage());
    }

    return view('client.nguoidung.taodiachi', compact('tinhThanhs'));
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

        $isDefault = $request->input('trangthai') === 'Mặc định';

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

            $url = $request->input('url_back', route('trang-chu'));
            return redirect($url)->with('success', 'Đã thêm địa chỉ giao hàng mới thành công!');

        } catch (\Exception $e) {
            // Log lỗi
            \Log::error("Lỗi khi thêm địa chỉ: " . $e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: Không thể lưu địa chỉ. Vui lòng thử lại.')->withInput();
        }
    }

    public function suadiachi($id)
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
        $diachi = DiachinguoidungModel::findOrFail($id);
        return view('client.nguoidung.suadiachi', compact('diachi', 'tinhThanhs'));
    }

    public function capnhatdiachi(Request $request)
{
    // 1. Validate dữ liệu đầu vào
    $request->validate([
        'id_diachi'   => 'required|exists:diachi_nguoidung,id', // Nên validate cả ID này để bảo mật
        'hoten'       => 'required|string|max:255',
        'sodienthoai' => 'required|string|max:20',
        'tinhthanh'   => 'required|string',
        'diachi'      => 'required|string|max:255',
    ], [
        'required'             => 'Trường :attribute là bắt buộc.',
        'max'                  => 'Trường :attribute không được vượt quá :max ký tự.',
        'hoten.required'       => 'Vui lòng nhập Họ tên Người nhận.',
        'sodienthoai.required' => 'Vui lòng nhập Số điện thoại.',
        'tinhthanh.required'   => 'Vui lòng chọn Tỉnh/Thành phố.',
        'diachi.required'      => 'Vui lòng nhập Địa chỉ chi tiết.',
    ]);

    // --- [BẮT ĐẦU] LOGIC KIỂM TRA TRẠNG THÁI ĐƠN HÀNG ---
    $id_diachi = $request->id_diachi;
    
    // Kiểm tra xem địa chỉ này có đang nằm trong đơn hàng nào chưa hoàn tất không
    // Logic: Lấy đơn hàng có địa chỉ này VÀ trạng thái KHÔNG PHẢI là 'Đã giao hàng' hoặc 'Đã hủy'
    $diaChiDangBiKhoa = DonhangModel::where('id_diachinguoidung', $id_diachi)
        ->whereNotIn('trangthai', ['Đã giao hàng', 'Đã hủy đơn']) 
        ->exists(); // Trả về true nếu tìm thấy

    if ($diaChiDangBiKhoa) {
        return redirect()->back()->with('error', 'Không thể cập nhật: Địa chỉ này đang được sử dụng cho một đơn hàng đang xử lý hoặc đang giao.');
    }
    // --- [KẾT THÚC] LOGIC KIỂM TRA ---


    // 2. Xử lý cập nhật trạng thái Mặc định
    $isDefault = $request->input('trangthai') === 'Mặc định';

    if ($isDefault) {
        DiachinguoidungModel::where('id_nguoidung', Auth::id())
                            ->update(['trangthai' => 'Khác']);
    }

    // 3. Cập nhật thông tin địa chỉ
    $diachi = DiachinguoidungModel::findOrFail($id_diachi);
    
    // (Tùy chọn) Kiểm tra quyền sở hữu địa chỉ lần nữa cho chắc chắn
    if ($diachi->id_nguoidung != Auth::id()) {
         return redirect()->back()->with('error', 'Bạn không có quyền sửa địa chỉ này.');
    }

    $diachi->hoten = $request->hoten;
    $diachi->sodienthoai = $request->sodienthoai;
    $diachi->tinhthanh = $request->tinhthanh;
    $diachi->diachi = $request->diachi;
    $diachi->trangthai = $isDefault ? 'Mặc định' : 'Khác';
    $diachi->save();

    return redirect()->route('so-dia-chi')->with('success', 'Đã cập nhật địa chỉ giao hàng thành công!');
}

    public function xoadiachi(Request $request)
    {
        $request->validate([
            'id_diachi' => 'required|exists:diachi_nguoidung,id',
        ]);

        $diachi = DiachinguoidungModel::findOrFail($request->id_diachi);
        $diachi->delete();

        return redirect()->route('so-dia-chi')->with('success', 'Đã xóa địa chỉ giao hàng thành công!');
    }

    public function selectAddress()
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