<?php



namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="Siêu Thị Vina API Documentation",
 *     description="API documentation for Siêu Thị Vina application",
 *     @OA\Contact(
 *         email="lyhuu5570@gmail.com",
 *         name="Cao Kiến Hựu",
 *        url="kienhuu.id.vn",
 *    ),
 * )
 */
/**
 * @OA\Info(
 *      version="1.0.",
 *      title="Siêu Thị Vina API Documentation",
 *      description="API documentation for Siêu Thị Vina application",
 *      @OA\License(
 *          name="sieuthivina.com License",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      ),
 *     @OA\Contact(
 *         email="lyhuu5570@gmail.com",
 *         name="Cao Kiến Hựu",
 *        url="kienhuu.id.vn",
 *    )
 *)
 *
 * @OA\Server(
 *      url="https://sieuthivina.com/api/v1",
 *      description="Trung tâm dữ liệu thử API của Siêu Thị Vina"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
