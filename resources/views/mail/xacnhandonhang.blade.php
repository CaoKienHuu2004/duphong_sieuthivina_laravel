<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đã xác nhận đơn hàng</title>
    
    <!-- CSS nhúng (Inline CSS) để tương thích tốt nhất với các client email -->
    <style>
        /* Styling */
        /* Nền chung và màu chữ chính */
        body { margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Arial', sans-serif; color: #1f2937; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        .header { background-color: #ffffff; padding: 20px 25px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .content { padding: 25px; color: #1f2937; } /* Màu chữ tối trên nền sáng */
        .main-title { font-size: 24px; font-weight: bold; color: #000000; margin-bottom: 15px; }
        
        .product-item { background-color: #ffffff; padding: 15px 0; border-bottom: 1px solid #e5e7eb; }
        .summary-title { font-size: 18px; font-weight: bold; color: #000000; margin: 30px 0 15px 0; }
        
        /* Bảng Tóm tắt/Totals */
        .flex-row { display: table; width: 100%; }
        .flex-label, .flex-value { display: table-cell; padding: 4px 0; }
        .flex-label { color: #6b7280; width: 70%; font-size: 14px; } /* Màu xám nhẹ hơn */
        .flex-value { text-align: right; font-size: 14px; color: #1f2937; }
        
        .cta-button { display: block; width: 100%; padding: 12px 0; text-align: center; background-color: #ef4444; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 15px 0; }
        
        /* Box Nổi bật (Địa chỉ vận chuyển, Tóm tắt) */
        .shipping-box { background-color: #f7f7f7; padding: 15px; border-radius: 8px; line-height: 1.6; font-size: 14px; color: #1f2937; margin-top: 15px; }
        .footer { text-align: center; padding: 20px 25px; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Arial', sans-serif; font-size: 14px; line-height: 1.6; color: #1f2937;">

    <center style="width: 100%;">
        <div class="container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
            
            <!-- Header (Tiêu đề trên cùng) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; background-color: #ffffff;">
                <tr>
                    <td style="padding: 20px 25px 0px 25px; text-align: left;">
                        <h1 style="margin: 0; font-size: 24px; color: #000000;">Đã xác nhận đơn hàng</h1>
                    </td>
                </tr>
            </table>

            <!-- Banner/Logo SIEU THI VINA (Ảnh đã cung cấp) -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                <tr>
                    <td style="padding: 0;">
                        
                        <img src="{{ asset('assets/client') }}/image/bg/emailbanner1.png" alt="Banner Siêu Thị Vina" width="600" style="max-width: 100%; height: auto; display: block;">
                    </td>
                </tr>
            </table>

            <!-- Body Content -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                <tr>
                    <td class="content" style="padding: 25px; color: #1f2937;">
                        
                        <p style="margin: 0 0 15px 0;">
                            Xin chào <strong>{{ $data['hoten'] }}</strong>!
                        </p>

                        <p style="margin: 0 0 20px 0;">
                            Tin vui – đơn hàng của bạn đã được xác nhận. Chúng tôi sẽ gửi cho bạn xác nhận vận chuyển kèm chi tiết theo dõi ngay khi kiện hàng xuất kho.
                        </p>
                        <p style="margin: 0 0 20px 0; font-weight: bold; color: #000000;">
                            Đội ngũ Siêu Thị Vina
                        </p>

                        <!-- SẢN PHẨM VÀ ID ĐƠN HÀNG (GIỐNG APP) -->
                        <div style="padding: 15px 0;">
                            
                            <!-- Vòng lặp foreach cho chi tiết sản phẩm -->
                            @foreach ($data['chi_tiet_don_hang'] as $item)
                            <div style='padding: 15px 0; border-top: 1px solid #e5e7eb;'>
                                <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                                    <tr>
                                        <td width='60' style='padding-right: 10px;'>
                                            <!-- Ảnh sản phẩm từ URL động -->
                                            <img src='{{ $item['product_image'] }}' alt='Ảnh sản phẩm' width='60' style='border-radius: 4px; display: block;'>
                                        </td>
                                        <td style='color: #000000; font-size: 14px;'>
                                            <strong>{{ $item['product_name'] }}</strong>
                                            <div style='font-size: 12px; color: #6b7280;'>{{ $item['variant_name'] }}</div>
                                        </td>
                                        <td style='text-align: right; color: #000000; font-weight: bold;'>
                                            {{ $item['thanh_tien'] }}₫
                                            <div style='font-size: 12px; color: #6b7280;'>x{{ $item['so_luong'] }}</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endforeach
                            <!-- KẾT THÚC DỮ LIỆU SẢN PHẨM -->
                            
                            <p style="margin: 15px 0 5px 0; font-size: 12px; color: #6b7280;">ID đơn hàng: <strong style="color: #1f2937;">{{ $data['madon'] }}</strong></p>
                            <p style="margin: 0 0 15px 0; font-size: 12px; color: #6b7280;">Ngày đặt hàng: {{ $data['ngay_dat_hang'] }}</p>
                            
                            <!-- NÚT CTA CHÍNH -->
                            <a href="{{ $data['link_theo_doi_don_hang'] }}" class="cta-button" style="display: block; width: 100%; padding: 12px 0; text-align: center; background-color: #ef4444; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 15px 0;">
                                Xem chi tiết đơn hàng
                            </a>
                        </div>
                        

                        <!-- TỔNG QUAN ĐƠN HÀNG/THANH TOÁN -->
                        <h2 class="summary-title" style="font-size: 18px; font-weight: bold; color: #000000; margin-top: 30px; margin-bottom: 15px;">Tổng quan đơn hàng</h2>
                        
                        <div style="margin-bottom: 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                {{-- Tổng phụ --}}
                                <tr>
                                    <td class="flex-label" style="color: #6b7280; padding: 4px 0;">Tổng phụ</td>
                                    <td class="flex-value" style="text-align: right; color: #1f2937; padding: 4px 0;">{{ $data['tong_phu'] }}₫</td>
                                </tr>
                                {{-- Vận chuyển --}}
                                <tr>
                                    <td class="flex-label" style="color: #6b7280; padding: 4px 0;">Vận chuyển</td>
                                    <td class="flex-value" style="text-align: right; color: #1f2937; padding: 4px 0;">{{ $data['phi_van_chuyen'] }}₫</td>
                                </tr>
                                {{-- Phiếu giảm giá --}}
                                <tr>
                                    <td class="flex-label" style="color: #6b7280; padding: 4px 0;">Phiếu giảm giá</td>
                                    <td class="flex-value" style="text-align: right; color: #ef4444; padding: 4px 0;">-{{ $data['giam_gia_1'] }}₫</td>
                                </tr>
                                {{-- Phiếu giảm giá Vận chuyển --}}
                                <tr>
                                    <td class="flex-label" style="color: #6b7280; padding: 4px 0;">Phiếu giảm giá vận chuyển cũ</td>
                                    <td class="flex-value" style="text-align: right; color: #ef4444; padding: 4px 0;">-{{ $data['giam_gia_2'] }}₫</td>
                                </tr>
                                {{-- TỔNG CỘNG CUỐI CÙNG --}}
                                <tr>
                                    <td style="font-size: 16px; font-weight: bold; padding-top: 10px; border-top: 1px solid #d1d5db; color: #000000;">Tổng ({{ $data['tong_so_mat_hang'] }} mặt hàng)</td>
                                    <td style="font-size: 16px; font-weight: bold; color: #ef4444; text-align: right; padding-top: 10px; border-top: 1px solid #d1d5db;">{{ $data['tong_cong'] }}₫</td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- ĐỊA CHỈ VẬN CHUYỂN -->
                        <h2 class="summary-title" style="font-size: 18px; font-weight: bold; color: #000000; margin-top: 30px; margin-bottom: 15px;">Địa chỉ vận chuyển</h2>
                        <div class="shipping-box" style="background-color: #f7f7f7; padding: 15px; border-radius: 8px; line-height: 1.6; font-size: 14px; color: #1f2937;">
                            <p style="margin: 0; color: #000000;"><strong>{{ $data['nguoi_nhan'] }}</strong></p>
                            <p style="margin: 0; color: #1f2937;">(+84) {{ $data['sdt'] }}</p>
                            <p style="margin: 0; color: #1f2937;">{{ $data['dia_chi_chi_tiet'] }}</p>
                            <p style="margin: 0; color: #1f2937;">{{ $data['tinh_thanh'] }}, Việt Nam</p>
                        </div>
                        
                        <!-- TRUNG TÂM TRỢ GIÚP -->
                        <div style="margin-top: 30px; padding: 15px 0; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-weight: bold; color: #000000;">Bạn gặp vấn đề?</p>
                            <a href="{{ $data['link_trung_tam_tro_giup'] }}" style="color: #ef4444; text-decoration: none; display: block; margin-top: 5px;">Xem tất cả vấn đề &gt;</a>
                        </div>
                        
                        <!-- GỬI ĐẾN EMAIL NÀO -->
                        <p style="margin-top: 20px; font-size: 12px; color: #9ca3af; text-align: center;">
                            Email này đã được gửi đến {{ $data['email_nguoi_nhan'] }}
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                <tr>
                    <td class="footer" style="text-align: center; padding: 20px 25px; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb;">
                        &copy; 2025 Siêu Thị Vina. | Cảm ơn bạn đã mua sắm!
                    </td>
                </tr>
            </table>

        </div>
    </center>
</body>
</html>