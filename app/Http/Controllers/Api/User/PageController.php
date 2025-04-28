<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\Page\ListService;
use App\Services\Admin\Product\ShowService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PageController extends BaseController
{
    public function index (Request $request)
    {
        $data['limit'] = $request->get('limit', 12);

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (int $id)
    {
        $product = resolve(ShowService::class)->handle($id);

        return response()->success($product);
    }
}
