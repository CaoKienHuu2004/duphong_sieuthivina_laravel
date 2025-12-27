<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChatbotService;

class ChatboxController extends Controller
{
    protected $chatbot;

    public function __construct(ChatbotService $chatbot)
    {
        $this->chatbot = $chatbot;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $userMessage = $request->input('message');
        
        try {
            $botReply = $this->chatbot->askAI($userMessage);
            return response()->json(['reply' => $botReply]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Xin lỗi, hệ thống đang bận. Vui lòng thử lại sau.'], 500);
        }
    }
}