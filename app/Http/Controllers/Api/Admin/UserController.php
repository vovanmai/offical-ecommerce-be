<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\Admin\User\ListService;
use App\Services\Admin\Post\ShowService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function index (Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'status',
            'created_at_from',
            'created_at_to',
            'per_page',
            'sort',
            'order',
        ]);

        $items = resolve(ListService::class)->handle($data);

        return response()->success($items);
    }

    public function show (int $id)
    {
        $product = resolve(ShowService::class)->handle($id);

        return response()->success($product);
    }
}
