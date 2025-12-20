<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use App\Models\BaivietModel; // Giả định tên Model của bạn
// use App\Models\DanhmucBaivietModel; 
use Illuminate\Http\Request;

class BaivietController extends Controller
{
    /**
     * Danh sách bài viết (Index)
     * Hỗ trợ phân trang, lọc theo danh mục và tìm kiếm
     */
    public function index(Request $request)
    {
        $query = BaivietModel::with(['nguoidung']) // Load danh mục và tác giả
            ->where('trangthai', 'Hiển thị');

        // 1. Lọc theo danh mục bài viết
        // if ($request->filled('category_id')) {
        //     $query->where('id_danhmuc', $request->category_id);
        // }

        // 2. Tìm kiếm theo tiêu đề
        // if ($request->filled('keyword')) {
        //     $query->where('tieude', 'LIKE', '%' . $request->keyword . '%');
        // }

        // 3. Sắp xếp mới nhất
        $baiviet = $query->orderBy('created_at', 'desc')->paginate(10);

        // 4. Chuyển đổi URL ảnh tuyệt đối cho thumbnail bài viết
        $baiviet->getCollection()->transform(function ($item) {
            if ($item->hinhanh) {
                $item->hinhanh = asset('assets/client/images/thumbs/' . $item->hinhanh);
            }
            return $item;
        });

        return response()->json([
            'status' => 200,
            'data' => $baiviet,
        ]);
    }

    /**
     * Chi tiết bài viết (Show)
     */
    public function show($slug)
    {
        $post = BaivietModel::with([ 'nguoidung'])
            ->where('slug', $slug)
            ->where('trangthai', 'Hiển thị')
            ->first();

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Bài viết không tồn tại.'
            ], 404);
        }

        // Tăng lượt xem
        $post->increment('luotxem');

        // Chuyển đổi URL ảnh tuyệt đối
        if ($post->hinhanh) {
            $post->hinhanh = asset('assets/client/images/thumbs/' . $post->hinhanh);
        }

        // Lấy thêm bài viết liên quan (cùng danh mục, trừ bài hiện tại)
        // $relatedPosts = BaivietModel::where('id_danhmuc', $post->id_danhmuc)
        //     ->where('id', '!=', $post->id)
        //     ->where('trangthai', 'Hiển thị')
        //     ->orderBy('created_at', 'desc')
        //     ->limit(5)
        //     ->get()
        //     ->each(function($item) {
        //         if ($item->hinhanh) {
        //             $item->hinhanh = asset('assets/client/images/posts/' . $item->hinhanh);
        //         }
        //     });

        return response()->json([
            'status' => 200,
            'data' => $post,
            // 'related_posts' => $relatedPosts
        ]);
    }
}