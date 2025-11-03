<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;
use App\Models\GiohangModel;
use App\Models\BientheModel;
use Illuminate\Support\Facades\DB;

class MergeCartOnLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $session_cart = Session::get('cart');

        if (empty($session_cart)) {
            return;
        }

        DB::beginTransaction();

        try {
            foreach ($session_cart as $id_bienthe => $item) {
                $soluong_session = $item['soluong'];

                $giaban = $item['giaban'] ?? BientheModel::find($id_bienthe)->giadagiam;
                $thanhtien_session = $soluong_session * $giaban;

                $db_item = GiohangModel::where('id_nguoidung', $user->id)
                            ->where('id_bienthe', $id_bienthe)
                            ->first();

                if ($db_item) {
                    $db_item->soluong += $soluong_session;
                    $db_item->thanhtien = $db_item->soluong * $giaban; 
                    $db_item->save();
                } else {
                    GiohangModel::create([
                        'id_nguoidung' => $user->id,
                        'id_bienthe' => $id_bienthe,
                        'soluong' => $soluong_session,
                        'thanhtien' => $thanhtien_session,
                        'trangthai' => 'Hiển thị',
                    ]);
                }
            }

            DB::commit();
            Session::forget('cart'); 

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi đồng bộ giỏ hàng: ' . $e->getMessage());
        }
    }
}
