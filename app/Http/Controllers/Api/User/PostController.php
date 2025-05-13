<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\Post\ListService;
use App\Services\User\Post\ShowService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function index (Request $request)
    {
        $data['limit'] = $request->get('limit');

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (string $slug)
    {
        $product = resolve(ShowService::class)->handle($slug);

        return response()->success($product);
    }
}
