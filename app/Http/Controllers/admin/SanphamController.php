<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\HinhanhsanphamModel as Anhsp;
use App\Models\SanphamModel as Sanpham;
use App\Models\ThuonghieuModel as ThuongHieu;
use App\Models\DanhmucModel as Danhmuc;
use App\Models\BientheModel as Bienthesp;
use App\Models\LoaibientheModel as LoaiBienThe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SanphamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SanPham::with('bienthe', 'danhmuc');

        // Filter theo thương hiệu
        if ($request->filled('thuonghieu')) {
            $query->where('id_thuonghieu', $request->thuonghieu);
        }

        // Filter theo danh mục (many-to-many)
        if ($request->filled('danhmuc')) {
            $query->whereHas('danhmuc', function ($q) use ($request) {
                $q->where('id_danhmuc', $request->danhmuc);
            });
        }

        // Filter giá (dựa trên bảng bienthe_sp)
        if ($request->filled('gia_min') && $request->filled('gia_max')) {
            $query->whereHas('bienthe', function ($q) use ($request) {
                $q->whereBetween('gia', [$request->gia_min, $request->gia_max]);
            });
        } elseif ($request->filled('gia_min')) {
            $query->whereHas('bienthe', function ($q) use ($request) {
                $q->where('gia', '>=', $request->gia_min);
            });
        } elseif ($request->filled('gia_max')) {
            $query->whereHas('bienthe', function ($q) use ($request) {
                $q->where('gia', '<=', $request->gia_max);
            });
        }

        // Lấy kết quả
        $sanphams = $query->orderBy('id', 'desc')->get();

        // Lấy thêm list danh mục & thương hiệu để render filter
        $thuonghieus = ThuongHieu::all();
        $danhmucs = DanhMuc::all();

        return view('admin.sanpham', compact('sanphams', 'thuonghieus', 'danhmucs'));

        // // Lấy toàn bộ sản phẩm kèm quan hệ
        // $sanpham = Sanpham::with(['bienThe.loaiBienThe', 'anhSanPham', 'danhmuc', 'thuonghieu'])->get();

        // // Render view với dữ liệu
        // return view('sanpham', compact('sanpham'));
    }

    public function create()
    {
        $thuonghieus = Thuonghieu::all();
        // Lấy danh mục cha để hiển thị đệ quy
        $danhmucs = Danhmuc::all();
        $loaibienthes = Loaibienthe::all();

        return view('admin.taosanpham', compact('thuonghieus', 'danhmucs', 'loaibienthes'));
    }

    public function store(Request $request)
    {
        // --- 1. TIỀN XỬ LÝ DỮ LIỆU (Pre-processing) ---
        
        // Xử lý giá tiền: Xóa dấu chấm phân cách (VD: "100.000" -> "100000")
        if ($request->has('bienthe')) {
            $bientheClean = $request->bienthe;
            foreach ($bientheClean as $key => $item) {
                if (isset($item['gia'])) {
                    // Chỉ giữ lại số
                    $bientheClean[$key]['gia'] = preg_replace('/[^0-9]/', '', $item['gia']);
                }
            }
            // Gộp lại dữ liệu đã làm sạch vào request để validate
            $request->merge(['bienthe' => $bientheClean]);
        }

        // --- 2. VALIDATION ---
        $request->validate(
            [
                'tensp'         => 'required|string|max:255',
                'xuatxu'        => 'required|string|max:255',
                'sanxuat'       => 'nullable|string|max:255',
                'mo_ta'         => 'required',
                'id_danhmuc'    => 'required|array',
                'id_danhmuc.*'  => 'integer|exists:danhmuc,id',
                'id_thuonghieu' => 'required|integer|exists:thuonghieu,id',
                'anhsanpham'    => 'required|array|min:1', // Bắt buộc ít nhất 1 ảnh
                'anhsanpham.*'  => 'image', // Max 5MB
                'bienthe'       => 'required|array',
                'bienthe.*.gia' => 'required|numeric|min:0',
                'bienthe.*.soluong' => 'required|integer|min:0',
            ],
            [
                // 1. Tên sản phẩm
                'tensp.required'    => 'Vui lòng nhập tên sản phẩm.',
                'tensp.string'      => 'Tên sản phẩm phải là chuỗi ký tự.',
                'tensp.max'         => 'Tên sản phẩm không được vượt quá 255 ký tự.',

                // 2. Xuất xứ
                'xuatxu.required'   => 'Vui lòng nhập xuất xứ sản phẩm.',
                'xuatxu.string'     => 'Xuất xứ phải là chuỗi ký tự.',
                'xuatxu.max'        => 'Xuất xứ không được vượt quá 255 ký tự.',

                // 3. Nơi sản xuất (Không bắt buộc nhưng nếu nhập phải đúng)
                'sanxuat.string'    => 'Nơi sản xuất phải là chuỗi ký tự.',
                'sanxuat.max'       => 'Nơi sản xuất không được vượt quá 255 ký tự.',

                // 4. Mô tả
                'mo_ta.required'    => 'Vui lòng nhập mô tả chi tiết cho sản phẩm.',

                // 5. Danh mục
                'id_danhmuc.required'   => 'Vui lòng chọn ít nhất một danh mục sản phẩm.',
                'id_danhmuc.array'      => 'Dữ liệu danh mục không hợp lệ.',
                'id_danhmuc.*.integer'  => 'Mã danh mục phải là số nguyên.',
                'id_danhmuc.*.exists'   => 'Danh mục đã chọn không tồn tại trong hệ thống.',

                // 6. Thương hiệu
                'id_thuonghieu.required' => 'Vui lòng chọn thương hiệu sản phẩm.',
                'id_thuonghieu.integer'  => 'Mã thương hiệu phải là số nguyên.',
                'id_thuonghieu.exists'   => 'Thương hiệu đã chọn không tồn tại trong hệ thống.',

                // 7. Hình ảnh
                'anhsanpham.required'   => 'Vui lòng tải lên hình ảnh cho sản phẩm.',
                'anhsanpham.array'      => 'Dữ liệu hình ảnh không hợp lệ.',
                'anhsanpham.min'        => 'Vui lòng tải lên ít nhất 1 hình ảnh.',
                'anhsanpham.*.image'    => 'File tải lên phải là định dạng hình ảnh (jpg, jpeg, png, webp, gif).',

                // 8. Biến thể (Chung)
                'bienthe.required'      => 'Vui lòng thêm ít nhất một biến thể sản phẩm.',
                'bienthe.array'         => 'Dữ liệu biến thể không hợp lệ.',

                // 9. Giá bán (Từng dòng biến thể)
                'bienthe.*.gia.required' => 'Vui lòng nhập giá bán cho biến thể.',
                'bienthe.*.gia.numeric'  => 'Giá bán phải là số (Vui lòng kiểm tra lại định dạng tiền tệ).',
                'bienthe.*.gia.min'      => 'Giá bán không được nhỏ hơn 0.',

                // 10. Số lượng (Từng dòng biến thể)
                'bienthe.*.soluong.required' => 'Vui lòng nhập số lượng kho cho biến thể.',
                'bienthe.*.soluong.integer'  => 'Số lượng phải là số nguyên.',
                'bienthe.*.soluong.min'      => 'Số lượng không được nhỏ hơn 0.',
            
            ]
        );

        DB::beginTransaction();
        try {
            // --- 3. XỬ LÝ SMART SLUG (Tự động đánh số nếu trùng) ---
            $baseSlug = Str::slug($request->tensp);
            $slug = $baseSlug;
            $counter = 1;

            // Vòng lặp kiểm tra: Nếu slug đã tồn tại (kể cả trong thùng rác) thì thêm số
            // Sanpham::withTrashed() giúp tránh lỗi khi khôi phục sản phẩm cũ
            while (Sanpham::withTrashed()->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            // Kết quả: $slug bây giờ là DUY NHẤT (VD: ten-san-pham-2)

            // --- 4. TẠO SẢN PHẨM ---
            $sanpham = Sanpham::create([
                'ten'           => $request->tensp,
                'slug'          => $slug,
                'id_thuonghieu' => $request->id_thuonghieu,
                'xuatxu'        => $request->xuatxu,
                'sanxuat'       => $request->sanxuat,
                'mota'          => $request->mo_ta,
                'trangthai'     => $request->trangthai ?? 'Công khai',
                'giamgia'       => 0,
                'luotxem'       => 0,
            ]);

            // --- 5. LƯU DANH MỤC (Pivot Table) ---
            if ($request->id_danhmuc) {
                $sanpham->danhmuc()->attach($request->id_danhmuc);
            }

            // --- 6. LƯU HÌNH ẢNH ---
            if ($request->hasFile('anhsanpham')) {
                $i = 1;
                foreach ($request->file('anhsanpham') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    // Đặt tên file theo Slug để chuẩn SEO: ten-san-pham-2-1.jpg
                    $filename = $slug . '-' . $i . '.' . $extension;
                    
                    $file->move('assets/client/images/thumbs/', $filename);
                    // $file->move(public_path('assets/client/images/thumbs/'), $filename);

                    Anhsp::create([
                        'id_sanpham' => $sanpham->id,
                        'hinhanh'    => $filename,
                        'trangthai'  => 'Hiển thị'
                    ]);
                    $i++;
                }
            }

            // --- 7. LƯU BIẾN THỂ (Kèm logic tạo loại mới) ---
            foreach ($request->bienthe as $bt) {
                $id_tenloai = null;

                if (isset($bt['id_tenloai'])) {
                    // CASE 1: Người dùng chọn từ danh sách (Giá trị là ID số)
                    if (is_numeric($bt['id_tenloai'])) {
                        $id_tenloai = $bt['id_tenloai'];
                    } 
                    // CASE 2: Người dùng nhập text mới (Select2 Tags)
                    else {
                        $tenLoaiMoi = trim($bt['id_tenloai']);
                        // Kiểm tra lại trong DB xem tên này có chưa (tránh trùng lặp do viết hoa/thường)
                        $loaiTonTai = Loaibienthe::whereRaw('LOWER(ten) = ?', [strtolower($tenLoaiMoi)])->first();

                        if ($loaiTonTai) {
                            $id_tenloai = $loaiTonTai->id;
                        } else {
                            // Tạo loại biến thể mới
                            $newLoai = Loaibienthe::create([
                                'ten' => $tenLoaiMoi,
                                'trangthai' => 'Hiển thị'
                            ]);
                            $id_tenloai = $newLoai->id;
                        }
                    }
                }

                // Lưu vào bảng bienthe
                if ($id_tenloai) {
                    Bienthesp::create([
                        'id_sanpham'     => $sanpham->id,
                        'id_loaibienthe' => $id_tenloai,
                        'giagoc'         => $bt['gia'], // Đã clean ở bước 1
                        'soluong'        => $bt['soluong'] ?? 0,
                        'luottang'       => $bt['luottang'] ?? 0,
                        'luotban'        => 0,
                        'trangthai'      => ($bt['soluong'] > 0) ? 'Còn hàng' : 'Hết hàng',
                    ]);
                }
            }

            DB::commit(); // Lưu tất cả xuống DB
            
            return redirect()->route('quan-tri-vien.danh-sach-san-pham')
                             ->with('success', 'Thêm sản phẩm thành công!');

        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác dữ liệu DB nếu lỗi
            
            // DỌN DẸP FILE RÁC:
            // Nếu DB lỗi nhưng ảnh đã kịp upload, ta cần xóa ảnh đi để sạch server
            if (isset($slug)) {
                // Tìm tất cả file bắt đầu bằng slug này trong thư mục
                $files = File::glob(public_path('assets/client/images/thumbs/') . $slug . '-*');
                foreach ($files as $file) {
                    File::delete($file);
                }
            }

            return back()->withInput()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        $sanpham = Sanpham::with(['bienthe', 'anhsanpham', 'danhmuc'])->findOrFail($id);
        $danhmucs = DanhMuc::all();
        $thuonghieus = ThuongHieu::all();
        $loaibienthes = LoaiBienThe::all();

        return view('suasanpham', compact('sanpham', 'danhmucs', 'thuonghieus', 'loaibienthes'));
    }

    public function update(Request $request, $id)
    {
        $sanpham = Sanpham::with(['bienthe', 'anhsanpham'])->findOrFail($id);

        // Update thông tin sản phẩm
        $sanpham->ten = $request->ten;
        $sanpham->id_thuonghieu = $request->id_thuonghieu;
        $sanpham->xuatxu = $request->xuatxu;
        $sanpham->sanxuat = $request->sanxuat;
        $sanpham->mediaurl = $request->mediaurl;
        $sanpham->trangthai = $request->trangthai;
        $sanpham->mota = $request->mo_ta;
        $sanpham->save();

        // Nếu sản phẩm có nhiều danh mục (many-to-many)
        if ($request->id_danhmuc) {
            $sanpham->danhmuc()->sync($request->id_danhmuc); // sync để giữ những danh mục mới và remove danh mục bị bỏ
        }

        // --- Xử lý biến thể ---
        $bienthesInput = $request->bienthe ?? [];

        // 1. Lấy tất cả biến thể hiện tại
        $existingIds = $sanpham->bienthe->pluck('id')->toArray();
        $newIds = [];

        foreach ($bienthesInput as $i => $bt) {
            // Xử lý id_tenloai: có thể là id (int) hoặc tên mới (string)
            $idTenLoai = null;
            if (is_numeric($bt['id_tenloai'])) {
                // chọn có sẵn
                $idTenLoai = $bt['id_tenloai'];
            } else {
                // nhập mới (string)
                $tenLoai = trim($bt['id_tenloai']);
                if ($tenLoai != '') {
                    $loai = LoaiBienThe::firstOrCreate(
                        ['ten' => $tenLoai],
                        ['ten' => $tenLoai] // nếu chưa có thì tạo mới
                    );
                    $idTenLoai = $loai->id;
                }
            }

            if (!$idTenLoai) continue; // bỏ qua nếu không hợp lệ

            if (isset($bt['id'])) {
                // Nếu biến thể đã có id -> update
                $b = Bienthesp::find($bt['id']);
                if ($b) {
                    $b->id_tenloai = $idTenLoai;
                    $b->gia = $bt['gia'];
                    $b->soluong = $bt['soluong'];
                    $b->save();
                    $newIds[] = $b->id;
                }
            } else {
                // Thêm biến thể mới
                $b = new Bienthesp();
                $b->id_sanpham = $sanpham->id;
                $b->id_tenloai = $idTenLoai;
                $b->gia = $bt['gia'];
                $b->soluong = $bt['soluong'];
                $b->save();
                $newIds[] = $b->id;
            }
        }

        // Xóa biến thể cũ mà bị remove
        $toDelete = array_diff($existingIds, $newIds);
        if (!empty($toDelete)) {
            Bienthesp::destroy($toDelete);
        }

        // --- Xử lý ảnh ---
        $deletedImages = $request->deleted_image_ids ?? []; // những ảnh user muốn xóa
        foreach ($sanpham->anhsanpham as $anh) {
            if (in_array($anh->id, $deletedImages)) {
                // kiểm tra file tồn tại trước khi xóa
                $filePath = public_path('img/product/' . $anh->media);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                // xóa bản ghi DB
                $anh->delete();
            }
        }

        if ($request->hasFile('anhsanpham')) {
            $slugName = Str::slug($request->ten);

            foreach ($request->file('anhsanpham') as $i => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $slugName . '-' . ($i + 1) . '.' . $extension;

                // Lưu file trực tiếp vào public/img/product
                $file->move(public_path('img/product'), $filename);

                // Lưu tên file vào DB
                $anh = new Anhsp();
                $anh->id_sanpham = $sanpham->id;
                $anh->media = $filename;
                $anh->save();
            }
        }


        return redirect()->route('danh-sach')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sanpham = Sanpham::findOrFail($id);

        DB::beginTransaction();
        try {
            // Xoá ảnh sản phẩm
            if ($sanpham->anhSanPham && $sanpham->anhSanPham->count()) {
                foreach ($sanpham->anhSanPham as $anh) {
                    $anh->delete();
                }
            }

            // Xoá biến thể
            Bienthesp::where('id_sanpham', $sanpham->id)->delete();

            // Xoá sản phẩm chính
            $sanpham->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Xoá sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi khi xoá: ' . $e->getMessage());
        }
    }

    public function show($slug, $id)
    {
        $sanpham = SanPham::with(['anhsanpham', 'danhmuc', 'bienthe.loaiBienThe'])->findOrFail($id);

        // kiểm tra slug có đúng không, nếu không thì redirect về slug đúng
        $correctSlug = \Illuminate\Support\Str::slug($sanpham->ten);
        if ($slug !== $correctSlug) {
            return redirect()->route('sanpham.show', [
                'id' => $sanpham->id,
                'slug' => $correctSlug
            ]);
        }

        return view('chitietsanpham', compact('sanpham'));
    }
}
