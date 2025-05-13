<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\Page\ListService;
use App\Services\User\Page\ShowService;
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

    public function show (string $slug)
    {
        $page = resolve(ShowService::class)->handle($slug);

        return response()->success($page);
    }
}
