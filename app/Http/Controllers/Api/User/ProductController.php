<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\Admin\Product\CreateRequest;
use App\Http\Requests\Admin\Product\EditRequest;
use App\Models\Category;
use App\Services\Admin\Product\DeleteService;
use App\Services\User\Product\ListService;
use App\Services\Admin\Product\StoreService;
use App\Services\Admin\Category\UpdateOrderService;
use App\Services\User\Product\ShowService;
use App\Services\Admin\Product\UpdateService;
use App\Services\User\Product\ListByCategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Log;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    public function index (Request $request)
    {
        $data['limit'] = $request->get('limit', 12);

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (string $slug)
    {
        $product = resolve(ShowService::class)->handle($slug);

        return response()->success($product);
    }

    public function getByCategory (Request $request, string $slug)
    {
        $data['page'] = $request->get('page', 1);
        $data['limit'] = $request->get('limit', 15);

        $products = resolve(ListByCategoryService::class)->handle($slug, $data);

        return response()->success($products);
    }
}
