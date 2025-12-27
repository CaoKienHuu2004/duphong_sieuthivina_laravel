<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // <--- Dùng cái này thay vì OpenAI
use Illuminate\Support\Facades\Log;
use App\Models\BientheModel;
use App\Models\SanphamModel;

class ChatbotService
{
    /**
     * Hàm lấy dữ liệu (GIỮ NGUYÊN, KHÔNG CẦN SỬA)
     */
    public function getSystemContext()
    {
        // ... (Giữ nguyên code lấy sản phẩm/sự kiện ở câu trả lời trước) ...
        // Copy lại đoạn code getSystemContext() từ câu trả lời trước vào đây
        
        // Để ngắn gọn tôi viết tóm tắt lại đoạn này, bạn nhớ copy full nhé:
        // --- PHẦN 1: LẤY TOP 5 SẢN PHẨM BÁN CHẠY NHẤT ---
        // Logic: Join 3 bảng (sanpham, bienthe, loaibienthe) để lấy đầy đủ tên, giá và đơn vị
        $products = SanphamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('bienthe_sum_luotban', 'desc')
            ->limit(10)
            ->get()
            ->tap(function ($collection) {
                $collection->each(function ($sanpham) {
                    if ($sanpham->bienthe->isNotEmpty()) {
                        $cheapestVariant = $sanpham->bienthe->sortBy('giagoc')->first();
                        $sanpham->bienthe = $cheapestVariant;
                        $giagoc = $cheapestVariant->giagoc;
                        $giamgiaPercent = $sanpham->giamgia / 100;
                        $sanpham->giadagiam = $giagoc * (1 - $giamgiaPercent);
                    } else {
                        $sanpham->bienthe = null;
                        $sanpham->giadagiam = null;
                    }
                });
            });

        $context = "Dưới đây là dữ liệu sản phẩm:\n";
        foreach ($products as $p) {
             $price = number_format($p->giadagiam, 0, ',', '.') . ' đ';
             $context .= "- {$p->ten} | Giá: {$price}\n";
        }
        return $context;
    }

    /**
     * Hàm gọi sang Google Gemini (SỬA ĐOẠN NÀY)
     */
    public function askAI($userMessage)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            $dataContext = $this->getSystemContext();

            // 1. Chuẩn bị Prompt
            // Gemini API cấu trúc hơi khác OpenAI, ta nên gộp System Prompt vào nội dung
            $finalPrompt = "Bạn là nhân viên tư vấn của Siêu Thị Vina. " .
                           "Hãy trả lời ngắn gọn, thân thiện Gen Z bằng tiếng Việt.\n" .
                           "Chỉ dựa vào dữ liệu sau để trả lời (nếu không có thì bảo khách gọi hotline):\n" .
                           "--- DỮ LIỆU CỬA HÀNG ---\n" . 
                           $dataContext . 
                           "\n------------------------\n" .
                           "Câu hỏi của khách: " . $userMessage;

            // 2. Gọi API Gemini qua HTTP
            // Sử dụng model 'gemini-1.5-flash' vì nó nhanh và rẻ (hoặc miễn phí)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $finalPrompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 500,
                ]
            ]);

            // 3. Xử lý kết quả trả về
            if ($response->successful()) {
                $data = $response->json();
                
                // Gemini trả về cấu trúc JSON khá sâu, cần trỏ đúng chỗ
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                } else {
                    // Trường hợp bị chặn nội dung (Safety filter)
                    return "Xin lỗi, tôi không thể trả lời câu hỏi này do chính sách an toàn.";
                }
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return "Đang có lỗi kết nối đến AI. Mã lỗi: " . $response->status();
            }

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            return "Xin lỗi, hệ thống đang bận.";
        }
    }
}