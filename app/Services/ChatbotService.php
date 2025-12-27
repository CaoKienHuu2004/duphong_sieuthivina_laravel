<?php

namespace App\Services;

use App\Models\SanphamModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    public function getSystemContext()
    {
        // 1. Lấy sản phẩm kèm Mô Tả (Quan trọng)
        // Dùng DB::table cho nhanh và khớp với file SQL bạn gửi (khỏi lo thiếu Model)
        $products = SanphamModel::where('trangthai', 'Công khai')
            ->with(['hinhanhsanpham', 'thuonghieu', 'danhmuc', 'bienthe'])
            ->withSum('bienthe', 'luotban')
            ->orderBy('bienthe_sum_luotban', 'desc')
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

        $context = "Dưới đây là thông tin chi tiết sản phẩm (Học kỹ phần công dụng để tư vấn):\n";
        
        foreach ($products as $p) {
            // Tính giá
            $price = number_format($p->giagoc, 0, ',', '.') . 'đ';
            $salePrice = ($p->giamgia > 0) ? number_format($p->giadagiam, 0, ',', '.') . 'đ' : null;
            $finalPrice = $salePrice ? "Giá gốc $price giảm còn $salePrice" : "Giá $price";
            
            // Xử lý mô tả: Xóa tag HTML thừa để AI dễ đọc
            $desc = strip_tags($p->mota); 
            // Cắt ngắn nếu mô tả quá dài (tránh tốn token)
            $desc = \Illuminate\Support\Str::limit($desc, 150); 
            
            $variant = $p->loai ? "({$p->loai} {$p->donvi})" : "";

            // Nạp dữ liệu vào context
            $context .= "--- \n";
            $context .= "Tên: {$p->ten} {$variant}\n";
            $context .= "Giá bán: {$finalPrice}\n";
            $context .= "Công dụng/Đặc điểm: {$desc}\n"; // <--- AI sẽ dựa vào dòng này để tư vấn
        }

        return $context;
    }

    public function askAI($userMessage)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');
            $dataContext = $this->getSystemContext();

            // Prompt định hướng phong cách
            $finalPrompt = "Bạn là nhân viên tư vấn 'có tâm' của Siêu Thị Vina. \n" .
                           "Phong cách: Gen Z, thân thiện, dùng icon dễ thương (✨, 🌿, ☕).\n" .
                           "Nhiệm vụ: Dựa vào 'Công dụng/Đặc điểm' trong dữ liệu để tư vấn lợi ích cho khách, đừng chỉ báo giá không.\n\n" .
                           "--- DỮ LIỆU SẢN PHẨM ---\n" . 
                           $dataContext . 
                           "\n------------------------\n" .
                           "Khách hỏi: " . $userMessage;

            // SỬA URL API: Dùng bản 1.5 Flash chuẩn (Bản 3 chưa ra mắt public đâu)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $finalPrompt]]]
                ],
                'generationConfig' => [
                    'temperature' => 0.7, 
                    'maxOutputTokens' => 800,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, mình chưa load được thông tin.';
            } else {
                Log::error('Gemini Error: ' . $response->body());
                return "Hệ thống đang bảo trì xíu nha!";
            }

        } catch (\Exception $e) {
            Log::error("Chatbot Error: " . $e->getMessage());
            return "Lỗi hệ thống rồi bạn ơi.";
        }
    }
}