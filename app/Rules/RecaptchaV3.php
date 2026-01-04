<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaV3 implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Gửi request sang Google để check token
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip(), // Tùy chọn
        ]);

        $data = $response->json();

        // Check 1: Google trả về success true
        // Check 2: Điểm số (score) phải cao hơn ngưỡng (0.5 là mức trung bình)
        // Bot thường có điểm < 0.5, Người thật thường > 0.7
        if (!$data['success'] || $data['score'] < 0.5) {
            $fail('Hệ thống phát hiện nghi vấn spam. Vui lòng thử lại sau.');
        }
    }
}