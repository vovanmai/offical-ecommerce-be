<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\Product\ListService;
use App\Services\User\Product\ShowService;
use App\Services\User\Product\ListByCategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    public function index (Request $request)
    {
        $data['limit'] = $request->get('limit');
        $data['keyword'] = $request->get('keyword');
        $data['per_page'] = $request->get('per_page', 12);

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
