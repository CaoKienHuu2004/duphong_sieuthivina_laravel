<?php

namespace App\Http\Controllers\client\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SanphamModel;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->message;
        $apiKey = env('OPENAI_API_KEY');

        try {
            // -----------------------------------------------------------
            // BƯỚC 1: TRÍCH XUẤT TỪ KHÓA TÌM KIẾM (AI KEYWORD EXTRACTION)
            // -----------------------------------------------------------
            // Mục đích: Biến "Shop có bán yến sào không?" thành "yến sào"

            $keywordResponse = Http::withOptions(['verify' => false]) // Tắt verify nếu lỗi SSL local
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Nhiệm vụ: Trích xuất tên sản phẩm chính từ câu hỏi của người dùng để tìm kiếm trong Database. Chỉ trả về duy nhất tên sản phẩm. Nếu không có sản phẩm cụ thể, trả về "NULL". Ví dụ: "Giá yến sào nhiêu?" -> Trả về: "yến sào"'
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'temperature' => 0.3, // Thấp để chính xác
                    'max_tokens' => 50,
                ]);

            $searchKeyword = $keywordResponse->json('choices.0.message.content');

            // Làm sạch từ khóa (bỏ dấu ngoặc kép nếu AI lỡ thêm vào)
            $searchKeyword = trim($searchKeyword, '"\' ');

            // -----------------------------------------------------------
            // BƯỚC 2: TÌM KIẾM TRONG DATABASE VỚI TỪ KHÓA ĐÃ LỌC
            // -----------------------------------------------------------

            $productContext = "Không tìm thấy sản phẩm nào trong hệ thống khớp với yêu cầu.";

            // ...
            if ($searchKeyword && $searchKeyword !== 'NULL') {
                // Tìm sản phẩm và LỌC BIẾN THỂ CÒN HÀNG
                $products = SanphamModel::with(['bienthe' => function ($q) {
                    // Chỉ lấy các biến thể có số lượng > 0
                    $q->where('soluong', '>', 0);
                }])
                    ->where('ten', 'LIKE', "%{$searchKeyword}%")
                    ->where('trangthai', 'Công khai') // Nhớ giữ trạng thái Công khai như đã sửa
                    ->whereHas('bienthe', function ($q) {
                        // Chỉ lấy sản phẩm có ít nhất 1 biến thể còn hàng
                        $q->where('soluong', '>', 0);
                    })
                    ->take(5)
                    ->get();

                if ($products->count() > 0) {
                    $productContext = "Danh sách sản phẩm tìm thấy cho từ khóa '{$searchKeyword}':\n";
                    foreach ($products as $sp) {
                        // Nếu sau khi lọc mà không còn biến thể nào thì bỏ qua
                        if ($sp->bienthe->isEmpty()) continue;

                        // Tính giá dựa trên các biến thể còn hàng
                        $minPrice = $sp->bienthe->min('gia'); // Lưu ý: Cột giá trong DB của bạn tên là 'giagoc' hay 'gia'? Check lại Model nhé
                        // Theo file SQL: cột là 'giagoc'
                        $minPrice = $sp->bienthe->min('giagoc');
                        $maxPrice = $sp->bienthe->max('giagoc');

                        // Tính tổng tồn kho thực tế
                        $stockCount = $sp->bienthe->sum('soluong');

                        $priceStr = ($minPrice == $maxPrice)
                            ? number_format($minPrice) . ' đ'
                            : number_format($minPrice) . ' - ' . number_format($maxPrice) . ' đ';

                        $productContext .= "- Tên: {$sp->ten} | Giá: {$priceStr} | Tồn kho: {$stockCount} | Link: " . 'https://sieuthivina.shop/san-pham/' . $sp->slug . "\n";
                    }
                }
            }
            // ...

            // -----------------------------------------------------------
            // BƯỚC 3: TỔNG HỢP CÂU TRẢ LỜI CUỐI CÙNG
            // -----------------------------------------------------------

            $finalResponse = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "Bạn là nhân viên tư vấn gen Z của Siêu Thị Vina. \n" .
                                "Hãy trả lời khách hàng dựa trên dữ liệu sản phẩm dưới đây.\n" .
                                "DỮ LIỆU SẢN PHẨM TÌM ĐƯỢC:\n" . $productContext
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage
                        ]
                    ],
                    'temperature' => 0.7,
                ]);

            return response()->json([
                'search_keyword' => $searchKeyword, // (Debug) Xem AI tìm từ khóa gì
                'reply' => $finalResponse->json('choices.0.message.content')
            ]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Lỗi hệ thống: ' . $e->getMessage()], 500);
        }
    }
}
