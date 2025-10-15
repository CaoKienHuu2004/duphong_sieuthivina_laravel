<?php

namespace App\Http\Controllers\Swagger;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="EcomVina API Documentation",
 *     description="Tài liệu API hệ thống thương mại điện tử EcomVina",
 *     @OA\Contact(
 *         email="fpolydn@fpt.edu.vn",
 *         name="EcomVina Dev Team"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Server cục bộ"
 * )
 *
 * @OA\Server(
 *     url="https://ecomvina.yourdomain.com",
 *     description="Server sản phẩm"
 * )
 */
class SwaggerInfo {}
